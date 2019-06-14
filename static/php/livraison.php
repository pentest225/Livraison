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
            $reponse=$query->fetch();
            if($response){
                $Info['NameExist']=TRUE; 
                $InsertVente = $db->prepare('INSERT INTO vente (date,id_user,prise_client,somme_a_verser,rest) VALUES (?,?,?,?,?)');
                $InsertVente->execute(array($date,$response['id'],$prise,$SomAverser,$Somme,$diffSomme));
                
            }
        case 'actualisation':
            //selection des information du client array(5) { ["Action"]=> string(13) "actualisation" ["Nom"]=> string(7) "patrick" ["priseClient"]=> string(1) "3" ["SomAverser"]=> string(3) "375" ["Somme"]=> string(3) "300" }
            extract($_POST);
            //calcule de la difference entre la domme a verser t la somme verser 
            $diffSomme = $Somme - $SomAverser;
            //prise des information sur l'utilisateur 
            $db=DB::connect();
            $query =$db->prepare('SELECT * FROM user WHERE name =?');
            $query->execute(array($_POST['Nom']));
            $reponse=$query->fetch();
            if($response){
                $Info['NameExist']=TRUE;  
                //insertion des information 
                $InsertVente = $db->prepare('INSERT INTO vente (date,id_user,prise_client,somme_a_verser,rest) VALUES (?,?,?,?,?)');
                $InsertVente->execute(array($date,$response['id'],$prise,$SomAverser,$Somme,$diffSomme));
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
            echo json_encode($Info);
            break;
    }
}