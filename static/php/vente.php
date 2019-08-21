<?php
    require '../Admin/DataBase.php';
    $Info=array();
    if(isset($_POST)){
        extract($_POST);
        $db=DB::connect();
        $lastDate=$db->prepare('SELECT date FROM vente LIMIT 7');
        $lastDate->execute(array());
        $resultLatDate=$lastDate->fetchAll();
    switch($_POST['Action'])
    {
        case "RecupAll":
            extract($_POST);
            $db=DB::connect();
            $selectAll=$db->prepare('SELECT * FROM vente WHERE date =?');
            $selectAll->execute(array($date));
            $resultSelectAll=$selectAll->fetchAll();
            if($resultSelectAll){
                
                $selectAllPrise=$db->prepare('SELECT * FROM boulangerie WHERE date =?');
                $selectAllPrise->execute(array($date));
                $resultSelectAllPise=$selectAllPrise->fetchAll();
                if($resultSelectAllPise){
                    $Info['AllVente']=$resultSelectAll;
                    $Info['AllPrise']=$resultSelectAllPise;
                }
                
            }
            else {
                $Info['tableVide']=true;
            }
            echo json_encode($Info);
        break;

    }
}
?>
