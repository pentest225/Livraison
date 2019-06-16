<?php 
    require 'static/admin/DataBase.php';
    //requette pour recupere la liste des boulangerie
    $db=DB::connect();
    $selectBoul=$db->prepare('SELECT * FROM liste_boulangerie ');
    $selectBoul->execute(array());
    $InfoBoul=$selectBoul->fetchAll();
    if($InfoBoul){

    }else{
        //si la liste est vide reflechire a une solution
    }

    DB::Deconexte();