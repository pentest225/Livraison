<?php 
    require '../Admin/DataBase.php';
    $Info=array();
    $retour=[];
    if(isset($_POST)){
        switch($_POST['Action']){
            case "verifAdmin":
                extract($_POST);
                $db=db::connect();
                $verif=$db->prepare('SELECT pass FROM livreur where nom=? and pass=?');
                $verif->execute(array($login,$pass));
                $resultVrif=$verif->fetchAll();
                if($resultVrif){
                    $retour['okAdmin']=true;

                }else{
                    $retour['okAdmin']=false;
                }
                echo json_encode($retour);
            break;
            case"miseAjourUser":
                extract($_POST);
                $db=db::connect();
                $miseAjour=$db->prepare('UPDATE user set nom=?,adresse=?,numero=?,type_client=?,unitary_price=?,solde=? WHERE id = ?');
                $miseAjour->execute(array($nom,$add,$num,$type,$prix,$solde,$id));
                if($miseAjour){
                    $retour['MiseAjourUserOK']=true; 
                }else{
                    $retour['MiseAjourUserOK']=false;
                }
                echo json_encode($retour);
            break;
        } 
    }


?>