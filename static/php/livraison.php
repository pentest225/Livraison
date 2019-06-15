<?php 
    require '../Admin/DataBase.php';
    $Info=array();
if(isset($_POST)){
    switch($_POST['Action'])
    {
        case 'VerifClient':

            $db=DB::connect();
            $query =$db->prepare('SELECT * FROM user WHERE name =?');
            $query->execute(array($_POST['Nom']));
            $reponse=$query->fetch();
            if($reponse){
                //Si le client existe on selectionne donc toute les information a son sujet 
                $Info['NameExist']=TRUE;
                $Info['valSolde']=$reponse['solde'];
                $Info['typeClient']=$reponse['type'];
                $Info['prixUnitaire']=$reponse['unitary_price'];
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
                $Info['NameExist']=TRUE;
            }else{
                $Info['NameExist']=FALSE;
                $NomClient=$_POST['Nom'];
                $request =$db->prepare('INSERT INTO user (name,type,unitary_price,solde) VALUES (?,?,?,?)');
                $request->execute(array($_POST['Nom'],$_POST['typeClient'],$_POST['PrixAchat'],'0'));
                if($request)
                {
                    $Info['InsertionOk']=TRUE;
                }
                else
                {
                    $Info['InsertionOk']=FALSE;
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
                            $newSolde =$response['solde'] + $SommeDu ;
                            $UpdateClient =$db->prepare('UPDATE  user SET solde =?  WHERE id = ?');
                            $UpdateClient->execute(array($newSolde,$response['id']));
                            if ($UpdateClient) {
                                $Info['miseAJourOk']=true;
                                $Info['newSolde']=$newSolde;
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
                        
                        //calcule de la difference entre la domme a verser t la somme verser 
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
                                $Info['miseAJourOk']=TRUE;
                                $Info['newSolde']=$newSoldeUser;
                                } 

                        }
                    }
                    
                    if($resVerifTab['etat_prise']=='1'){
                        //dans le cas ou on a dejat saisie une somme a verser 
                        //Retablison le compte du client 
                        $lastSolde =$response['solde'];
                        $lastSommeVerser=$resVerifTab['somme_verser'];
                        $newSoldeUser = $lastSolde - $lastSommeVerser;
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
                            $newSoldeUser =$lastSoldeUser - $Somme;
                            $MiseAjoutComptClient =$db->prepare('UPDATE  user SET solde =?  WHERE id = ?');
                            $MiseAjoutComptClient->execute(array($newSoldeUser,$response['id']));
                            if($MiseAjoutComptClient){
                                $Info['miseAJourOk']=TRUE;
                                $Info['newSolde']=$newSoldeUser;
                                } 
                        }

                    }
                }
                else{
                    //si il n'y a pas d'enregistrement dans la table vente 
                    //calcule de la difference entre la domme a verser t la somme verser 
                    $diffSomme = $Somme - $SomAverser;
                    //insertion des information 
                    $InsertVente = $db->prepare('INSERT INTO vente (date,id_user,prise_client,somme_a_verser,somme_verser,rest) VALUES (?,?,?,?,?,?)');
                    $InsertVente->execute(array($date,$response['id'],$priseClient,$SomAverser,$Somme,$diffSomme));
                    if($InsertVente){
                        //Insertion dans la table vente ok 
                        //Mise a jour du solde du client 
                        $newSolde =$response['solde'] + $diffSomme ;
                        $UpdateClient =$db->prepare('UPDATE TABLE user SET selde =? WHERE id_user = ?');
                        $UpdateClient->execute(array($nweSolde,$response['id']));
                            if($UpdateClient){
                            $Info['miseAJourOk']=TRUE;
                            $Info['newSolde']=$newSolde;
                            }   
                        }
                }

                
            }
            echo json_encode($Info);
            break;
    }
}