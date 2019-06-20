<?php 
    require '../Admin/DataBase.php';
    $Info=array();
if(isset($_POST)){
    switch($_POST['Action'])
    {
        case "InsertionBoulagerie":
            extract($_POST);
            $db=DB::connect();
            $insertionVersement=$db->prepare('INSERT INTO  boulangerie (id_boul,date,prise,retour,somme_a_verser,somme_verser,manquant_du_jour) VALUES(?,?,?,?,?,?,?)');
            $insertionVersement->execute(array($idBoul,$date,$prise,$retour,$sommeDu,$versement,$rest));
            if($insertionVersement){
                //en suite on met a jour son solde 
                $miseAjour=$db->prepare('UPDATE  liste_boulangerie SET solde=? WHERE id=?');
                $miseAjour->execute(array($totalSolde,$idBoul));
                if($miseAjour){
                    $Info['insertionOk']=true;
                    $Info['miseAjourSolde']=true;
                }
                
            }
            echo json_encode($Info);
        break;
        case 'selectPrise':
        extract($_POST);
        $db=DB::connect();
        $selectPrise=$db->prepare('SELECT prise FROM boulangerie WHERE date=?');
        $selectPrise->execute(array($date));
        $resultPrise=$selectPrise->fetch();
        if($resultPrise){
            $Info['dateOk']=true;
            $Info['Prise']=$resultPrise['prise'];
        }
        echo json_encode($Info);
        break;
        case 'recupInfoBoul':
            extract($_POST);
            $db=DB::connect();
            //SELECTION DE TOUTE LES INFORMATION SUR LA BOUALGERIE
            $selectInfo=$db->prepare('SELECT * FROM liste_boulangerie WHERE id=? ');
            $selectInfo->execute(array($idBoul));
            $resultInfo=$selectInfo->fetch();
            if($resultInfo){
               $Info['prixUniBoul']=$resultInfo['prix_unitaire'];
               $Info['totalManquant']=$resultInfo['solde'];
            }
            echo json_encode($Info);
        break;
        case 'enregistrementBoulangerie':
            //verification dans la base de bonne 
            extract($_POST);
            $db=DB::connect();
            //RECUPERATION DE SON SOLDE 
            $seleSolde=$db->prepare('SELECT * FROM liste_boulangerie WHERE id=?');
            $seleSolde->execute(array($idBoul));
            $resultSolde=$seleSolde->fetch();
            if($resultSolde){
                //si on a pu recuprer son ensien solde 
                //on verifie si il y un enregistrement dans la table boulangerie
                $verif=$db->prepare('SELECT * FROM boulangerie WHERE date = ? AND id_boul=?');
                $verif->execute(array($date,$idBoul));
                $resulVerif=$verif->fetch();
                
                if($resulVerif){
                    
                    //un enregistrement a deja ete effectue 
                    //c'est une mise a jour on doit en premier temps retablire son solde 
                    $newSolde=$resultSolde['solde']- $resulVerif['somme_a_verser'];
                    $newSolde+=$sommeDu;
                    //en suite on met a jour son solde 
                    $miseAjour=$db->prepare('UPDATE  liste_boulangerie SET solde=? WHERE id=?');
                    $miseAjour->execute(array($newSolde,$idBoul));
                    //mise a jour de la table boulangerie
                    $miseAjourTabBoul=$db->prepare('UPDATE  boulangerie SET prise=?,somme_a_verser=?,manquant_du_jour=? WHERE id_boul=? AND date=?');
                    $miseAjourTabBoul->execute(array($prise,$sommeDu,$rest,$idBoul,$date));
                    if($miseAjourTabBoul){
                        $Info['miseAJourOk']=true;
                        $Info['totalManquant']=$newSolde;
                    }
                }else{
                    //aucun enregistrement a ete effectue 
                    //on cree donc la requette 
                    $insert=$db->prepare('INSERT INTO boulangerie (date,id_boul,prise,somme_a_verser,manquant_du_jour ) VALUES (?,?,?,?,?)');
                    $insert->execute(array($date,$idBoul,$prise,$sommeDu,$rest));
                    //Augmentation du Manquant de la boulangerie 
                    $newSolde=$resultSolde['solde']+$sommeDu;
                    $miseAjour=$db->prepare('UPDATE  liste_boulangerie SET solde=? WHERE id=?');
                    $miseAjour->execute(array($newSolde,$idBoul));
                    $Info['totalManquant']=$newSolde;
                }
            }
            echo json_encode($Info);
        break;
        case 'MiseAjourRetour':
                //verification dans la base de bonne 
                extract($_POST);
                $db=DB::connect();
                //RECUPERATION DE SON SOLDE 
                $seleSolde=$db->prepare('SELECT * FROM liste_boulangerie WHERE id=?');
                $seleSolde->execute(array($idBoul));
                $resultSolde=$seleSolde->fetch();
                if($resultSolde){
                    //si on a pu recuprer son ensien solde 
                    $verif=$db->prepare('SELECT * FROM boulangerie WHERE date = ? AND id_boul=? AND prise= ?');
                    $verif->execute(array($date,$idBoul,$prise));
                    $resulVerif=$verif->fetch();
                
                if($resulVerif){
                    //un enregistrement a deja ete effectue 
                    //c'est une mise a jour on doit en premier temps retablire son solde 
                    //1=>D'abord on verifie la valleur du retour 
                    if( ($retour < 0 ) || ($retour > $prise)){
                        $Info['error']=true;
                        $Info['Message']="Valleur du retour trop grande ou negative ";
                    }
                    else{
                        $newSolde=$resultSolde['solde']- $resulVerif['somme_a_verser'];
                        $newSolde+=$sommeDu;
                        //en suite on met a jour son solde 
                        $miseAjour=$db->prepare('UPDATE  liste_boulangerie SET solde=? WHERE id=?');
                        $miseAjour->execute(array($newSolde,$idBoul));
                        //mise a jour de la table boulangerie
                        //mise a jour de la table boulangerie
                        $miseAjourTabBoul=$db->prepare('UPDATE  boulangerie SET prise=?,retour=?,somme_a_verser=?,manquant_du_jour=? WHERE id_boul=? AND date=?');
                        $miseAjourTabBoul->execute(array($prise,$retour,$sommeDu,$rest,$idBoul,$date));
                        if($miseAjourTabBoul){
                            $Info['miseAJourDuRetourOk']=true;
                            $Info['totalManquant']=$newSolde;
                        } 
                    }
                    
                }
                else{
                    //probleme car il existe pas de ligne correspondant a ces differant parametre 
                    $Info['error']=true;
                    $Info['Message']="Veillez verifier la date ou la valleur de votre prise ";
                    $Info['totalManquant']=$resultSolde['solde'];
                }
            }
            echo json_encode($Info);
        break;
        case "MiseAjourVersement":
            //verification dans la base de bonne 
            extract($_POST);
            $db=DB::connect();
            //RECUPERATION DE SON SOLDE 
            $seleSolde=$db->prepare('SELECT * FROM liste_boulangerie WHERE id=?');
            $seleSolde->execute(array($idBoul));
            $resultSolde=$seleSolde->fetch();
            if($resultSolde){
                //si on a pu recuprer son ensien solde 
                $verif=$db->prepare('SELECT * FROM boulangerie WHERE date = ? AND id_boul=? AND prise= ? AND retour=? AND somme_a_verser = ?');
                $verif->execute(array($date,$idBoul,$prise,$retour,$sommeDu));
                $resulVerif=$verif->fetch();
            
            if($resulVerif){
                        //un enregistrement a deja ete effectue 
                        //c'est une mise a jour on doit en premier temps retablire son solde
                        $newSolde=$resultSolde['solde'] + $resulVerif['somme_verser'];
                        $newSolde=$newSolde - $versement;
                        //en suite on met a jour son solde 
                        $miseAjour=$db->prepare('UPDATE  liste_boulangerie SET solde=? WHERE id=?');
                        $miseAjour->execute(array($newSolde,$idBoul));
                        //mise a jour de la table boulangerie
                        $miseAjourTabBoul=$db->prepare('UPDATE  boulangerie SET prise=?,retour=?,somme_a_verser=?,somme_verser=?,manquant_du_jour=? WHERE id_boul=? AND date=?');
                        $miseAjourTabBoul->execute(array($prise,$retour,$sommeDu,$versement,$rest,$idBoul,$date));
                        if($miseAjourTabBoul){
                            $Info['miseAJourDuRetourOk']=true;
                            $Info['totalManquant']=$newSolde;
                        } 
                }
            else{
                //Dans cette situation le client fait un versement san prise 
                //on fait donc une insertion dans la table 
                $insertionVersement=$db->prepare('INSERT INTO  boulangerie (id_boul,date,prise,retour,somme_a_verser,somme_verser,manquant_du_jour) VALUES(?,?,?,?,?,?,?)');
                $insertionVersement->execute(array($idBoul,$date,$prise,$retour,$sommeDu,$versement,$rest));
                if($insertionVersement){
                    $newSolde = $resultSolde['solde'] - $versement;
                    //en suite on met a jour son solde 
                    $miseAjour=$db->prepare('UPDATE  liste_boulangerie SET solde=? WHERE id=?');
                    $miseAjour->execute(array($newSolde,$idBoul));
                    if($miseAjour){
                        $Info['miseAJourDuRetourOk']=true;
                        $Info['totalManquant']=$newSolde;
                    }
                    
                }
                }

            }
            
        echo json_encode($Info);
        break;
        case 'VerifClient':

            $db=DB::connect();
            $query =$db->prepare('SELECT * FROM user WHERE name =?');
            $query->execute(array($_POST['Nom']));
            $reponse=$query->fetch();
            if($reponse){
                //Si le client existe on selectionne donc toute les information a son sujet 
                $Info['NameExist']=TRUE;
                $Info['newSolde']=$reponse['solde'];
                $Info['typeClient']=$reponse['type'];
                $Info['prixUnitaireClient']=$reponse['unitary_price'];
            }else{
                $Info['NameExist']=FALSE; 
            }
        echo json_encode($Info);
        break;
        case 'CreationCompte':
          
            $db=DB::connect();
            $query =$db->prepare('SELECT * FROM user WHERE name =?');
            $query->execute(array($_POST['Nom']));
            $reponse=$query->fetch();
            if($reponse){
                //si le nom existe plus d'insertion dans la base de bonne
                $Info['NameExist']=true;
            }else{
                $Info['NameExist']=false;
                $NomClient=$_POST['Nom'];
                $request =$db->prepare('INSERT INTO user (name,type,unitary_price,solde) VALUES (?,?,?,?)');
                $request->execute(array($_POST['Nom'],$_POST['typeClient'],$_POST['PrixAchat'],'0'));
                if($request)
                {
                    $Info['InsertionOk']=true;
                }
                else
                {
                    $Info['InsertionOk']=false;
                }
            }
            echo json_encode($Info);
        break;
        case'CreationCompteBoul':
            $db=DB::connect();
            $query =$db->prepare('SELECT * FROM liste_boulangerie WHERE nom =?');
            $query->execute(array($_POST['Nom']));
            $reponse=$query->fetch();
            if($reponse){
                //si le nom existe plus d'insertion dans la base de bonne
                $Info['NameExist']=true;
            }else{
                $Info['NameExist']=false;
                $NomClient=$_POST['Nom'];
                $request =$db->prepare('INSERT INTO liste_boulangerie (nom,prix_unitaire,solde) VALUES (?,?,?)');
                $request->execute(array($_POST['Nom'],$_POST['PrixAchat'],'0'));
                if($request)
                {
                    $Info['InsertionOk']=true;
                }
                else
                {
                    $Info['InsertionOk']=false;
                }
            }
        echo json_encode($Info);
        break;
        case 'actualisationPrise':
            extract($_POST);
            //prise des information sur l'utilisateur 
            $db=DB::connect();
            $query =$db->prepare('SELECT * FROM user WHERE name =?');
            $query->execute(array($_POST['Nom']));
            $response=$query->fetch();
            if($response){
                //verifions si c'est une mise  jours ou une premiers insertion 
                $verif =$db->prepare('SELECT * FROM vente WHERE date = ? and id_client=?');
                $verif->execute(array($date,$response['id']));
                $resVerif=$verif->fetch();
                if ($resVerif) {
                    //ok ici la requette a dans la table vente a deja ete faite c'est donc une modification
                    $Info['NameExist']=true;
                    $Info['prixUnitaire']=$response['unitary_price'];
                    //Retablisons le solde du client
                    $lastSolde =$response['solde'];
                    $lastPrise=$resVerif['prise_client'];
                    $newSoldeUser = $lastSolde - ($lastPrise * $response['unitary_price']);
                    
                    $updateSolde =$db->prepare('UPDATE user SET solde = ? WHERE id=?');
                    $updateSolde->execute(array($newSoldeUser,$response['id']));
                    if($updateSolde) {
                        //ok on a remis sons solde en bon etat
                        //on passe a la mise a jour dans la table vente

                        //Calcule de la somme a verser
                        $SommeDu =$prise * $response['unitary_price'];
                        $updatePrise =$db->prepare('UPDATE  vente SET prise_client = ?,etat_prise =? , somme_a_verser = ?  WHERE date = ? and id_client = ? ');
                        $updatePrise->execute(array($prise,0,$SommeDu,$date,$response['id']));
                        if ($updatePrise) {
                            //Insertion dans la table vente ok
                            //Nouvelle Mise a jour du solde du client
                            $newSoldeUser += $SommeDu ;
                            $UpdateClient =$db->prepare('UPDATE  user SET solde =?  WHERE id = ?');
                            $UpdateClient->execute(array($newSoldeUser,$response['id']));
                            if ($UpdateClient) {
                                $Info['miseAJourOk']=true;
                                $Info['newSolde']=$newSoldeUser;
                            }
                        }
                    }
                }//dans le cas ou c'est une premier insertion 
                else{
                //Calcule de la somme a verser 
                $SommeDu =$prise * $response['unitary_price'];
                $Info['NameExist']=TRUE; 
                $Info['prixUnitaire']=$response['unitary_price']; 
                $InsertPrise = $db->prepare('INSERT INTO vente (date,id_client,prise_client,etat_prise,somme_a_verser) VALUES (?,?,?,?,?)');
                $InsertPrise->execute(array($date,$response['id'],$prise,0,$SommeDu));
                if($InsertPrise){
                    //Insertion dans la table vente ok 
                    //Mise a jour du solde du client 
                    $newSolde =$response['solde'] + $SommeDu ;
                    $UpdateClient =$db->prepare('UPDATE  user SET solde =?  WHERE id = ?');
                    $UpdateClient->execute(array($newSolde,$response['id']));
                        if($UpdateClient){
                        $Info['miseAJourOk']=TRUE;
                        $Info['newSolde']=$newSolde;
                        } 
                    }
                }
                
            }
            echo json_encode($Info);
        break;
        case 'actualisation':
            extract($_POST);
            //prise des information sur l'utilisateur 
            $db=DB::connect();
            $query =$db->prepare('SELECT * FROM user WHERE name =?');
            $query->execute(array($_POST['Nom']));
            $response=$query->fetch();
            if($response){
                //ici le client est bien dans la base de donnee 
                $Info['NameExist']=TRUE;  
                $Info['prixUnitaire']=$response['unitary_price']; 
                //verification dans la table vente si une requete en attente 
                $verifTab=$db->prepare('SELECT * FROM vente WHERE date= ? and id_client=?');
                $verifTab->execute(array($date,$response['id']));
                $resVerifTab=$verifTab->fetch();
                if($resVerifTab){
                    //si on a un enregistrement en attente 
                    if($resVerifTab['etat_prise']=="0"){
                        
                        //calcule de la difference entre la somme a verser t la somme verser 
                        $diffSomme = $Somme - $SomAverser;
                        $updateSommeVerser=$db->prepare('UPDATE vente set etat_prise=?, somme_verser =? ,rest=? WHERE date =? and id_client=? and prise_client=?');
                        $updateSommeVerser->execute(array(1,$Somme,$diffSomme,$date,$response['id'],$priseClient));
                        if($updateSommeVerser){
                            //ok on a mis a jour la table vente 
                            //on doit maintement actualiser le solde de l'utilisateur 
                            $lastSoldeUser=$response['solde'];
                            $newSoldeUser =$lastSoldeUser - $Somme;
                            $MiseAjoutComptClient =$db->prepare('UPDATE  user SET solde =?  WHERE id = ?');
                            $MiseAjoutComptClient->execute(array($newSoldeUser,$response['id']));
                            if($MiseAjoutComptClient){
                               
                                //ok on a retabli le sode du client 
                                //Selectionnons la somme total recu par tous nos client ce jour 
                                $totalSommeRecu =$db->prepare("SELECT SUM(somme_verser) AS totalSommeRecu FROM vente WHERE date =?");
                                $totalSommeRecu->execute(array($date));
                                $resultTotalSommeRecu=$totalSommeRecu->fetch();
                                if($resultTotalSommeRecu){
                                    //ok on a selectionne le total de la somme recu par nos client
                                    $Info['miseAJourOk']=TRUE;
                                    $Info['newSolde']=$newSoldeUser;
                                    $Info['totalSommeRecu']=$resultTotalSommeRecu['totalSommeRecu'];
                                }
                                
                            } 

                        }
                    }
                    
                    if($resVerifTab['etat_prise']=='1'){
                        //dans le cas ou on a dejat saisie une somme a verser 
                        //Retablisons le compte du client 
                        $lastSolde =$response['solde'];
                        $lastSommeVerser=$resVerifTab['somme_verser'];
                        $newSoldeUser = $lastSolde + $lastSommeVerser;
                        $updateSolde =$db->prepare('UPDATE user SET solde = ? WHERE id=?');
                        $updateSolde->execute(array($newSoldeUser,$response['id']));
                        if($updateSolde){
                            $Info['miseAJourOk']=TRUE;
                            $Info['newSolde']=$newSoldeUser;
                        }
                        //ok on a retablie son solde 
                        //mise a jour de la table vente 
                        $updateSommeVerser=$db->prepare('UPDATE vente set somme_verser =?  WHERE date =? and id_client=?  ');
                        $updateSommeVerser->execute(array($Somme,$date,$response['id']));
                        if($updateSommeVerser){
                            //ok on a mis a jour la table vente 
                            //on doit maintement actualiser le solde de l'utilisateur 
                            $lastSoldeUser=$response['solde'];
                            $newSoldeUser -= $Somme;//ici $newSoldeUser et la derinier valleur du solde apres sa mise a jour juste en haut
                            $MiseAjoutComptClient =$db->prepare('UPDATE  user SET solde =?  WHERE id = ?');
                            $MiseAjoutComptClient->execute(array($newSoldeUser,$response['id']));
                            if($MiseAjoutComptClient){
                                //Selectionnons la somme total recu par tous nos client ce jour 
                                $totalSommeRecu =$db->prepare("SELECT SUM(somme_verser) AS totalSommeRecu FROM vente WHERE date =?");
                                $totalSommeRecu->execute(array($date));
                                $resultTotalSommeRecu=$totalSommeRecu->fetch();
                                if($resultTotalSommeRecu){
                                $Info['miseAJourOk']=TRUE;
                                $Info['newSolde']=$newSoldeUser;
                                $Info['totalSommeRecu']=$resultTotalSommeRecu['totalSommeRecu'];

                                } 
                            } 
                        }

                    }
                }
                else{
                    //si il n'y a pas d'enregistrement dans la table vente 
                    
                    //insertion des information 
                    $InsertVente = $db->prepare('INSERT INTO vente (date,id_user,somme_verser) VALUES (?,?,?)');
                    $InsertVente->execute(array($date,$response['id'],$Somme));
                    if($InsertVente){
                        //Insertion dans la table vente ok 
                        //Mise a jour du solde du client 
                        $newSolde =$response['solde'] - $Somme ;
                        $UpdateClient =$db->prepare('UPDATE TABLE user SET selde =? WHERE id_user = ?');
                        $UpdateClient->execute(array($nweSolde,$response['id']));
                            if($UpdateClient){
                              //Selectionnons la somme total recu par tous nos client ce jour 
                              $totalSommeRecu =$db->prepare("SELECT SUM(somme_verser) AS totalSommeRecu FROM vente WHERE date =?");
                              $totalSommeRecu->execute(array($date));
                              $resultTotalSommeRecu=$totalSommeRecu->fetch();
                              if($resultTotalSommeRecu){  
                              $Info['miseAJourOk']=TRUE;
                              $Info['newSolde']=$newSolde;
                              $Info['totalSommeRecu']=$resultTotalSommeRecu['totalSommeRecu'];
                              }

                            }   
                        }
                }

                
            }
            echo json_encode($Info);
            break;
    }
}