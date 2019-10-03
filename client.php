<?php
    require 'static/Admin/DataBase.php';

        extract($_POST);
        $db=DB::connect();
        if(isset($_GET)){
            extract($_GET);
            //SELECTIO DE TOUTE LES INFORMATIONS SUR L'UTILISATEUR 
            $selectAll=$db->prepare('SELECT * FROM user WHERE id = ?');
            $selectAll->execute(array($_GET['id']));
            $resultSelectAll=$selectAll->fetch();
            if($resultSelectAll){
                $selectAllvente=$db->prepare('SELECT V.* , E.montant as user_encaissement FROM vente AS V left join encaissement as E on (E.date=V.date and E.id_user =V.id_client) WHERE V.id_client =? ORDER BY V.date DESC  ');
                $selectAllvente->execute(array($_GET['id']));
                $resultSelecAllvente=$selectAllvente->fetchAll();

            }
        }
        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <!-- ME OWN FONT AWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
        crossorigin="anonymous">
    <!-- ME OWN CSS -->
    <!--<link rel="stylesheet" href="static/css/style.css">-->
    <link rel="stylesheet" href="static/css/client.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    
    <!-- Material Design Bootstrap -->
    <link href="static/css/mdb.min.css" rel="stylesheet">
</head>

<body>
    <header>
    <?php include("views/include/navBar.php") ?>
    </header>
    <!-- Section: Team v.1 -->
<section class="team-section   ">
        <!-- Section heading -->
        <!-- Section description -->
        <div class="row">
            <div class="col-lg-3 col-md-4 mb-lg-0 text-center tab_profil">
                <div class="avatar mx-auto">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(20).jpg" class="rounded-circle z-depth-1" alt="Sample avatar">
                </div>
                <h5 class="font-weight-bold mt-4 mb-3"><?=$resultSelectAll['nom']?></h5>
                <p class="text-uppercase blue-text"><strong>Graphic designer</strong></p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>N Villa :</strong><span><?=$resultSelectAll['adresse']?></span></li>
                    <li class="list-group-item"><strong>Contact :</strong><span><?=$resultSelectAll['numero']?></span></li>
                    <li class="list-group-item"><strong>Type Client :</strong><span><?=($resultSelectAll['type_client']=='r')?'Revendeur':'domicile'  ?></span></li>
                    <li class="list-group-item"><strong>Prix unitaire :</strong><span><?=$resultSelectAll['unitary_price']?></span></li>
                    <li class="list-group-item"><strong>Solde Actuel :</strong><span><?=$resultSelectAll['solde']?></span></li>
                </ul>

                <ul class="list-unstyled mb-0">
                    <!-- Facebook -->
                    <a class="p-2 fa-lg fb-ic " id="btnModif" data-toggle="modal" data-target="#modifUser" style="diplay:none">
                    </a>
                    <!-- Twitter -->
                    <a class="p-2 fa-lg tw-ic" id='' data-toggle="modal" data-target="#passwordAdmin">
                        <i class="far fa-edit"></i>
                    </a>
                    <!-- Instagram -->
                    <a class="p-2 fa-lg ins-ic">
                        <i class="fab fa-instagram blue-text"> </i>
                    </a>
                </ul>
            </div>
        <!-- Grid column -->
                <div class="col-lg-7 col-md-6 mb-lg-0  col-md-8 tableau table-responsive-md table-striped">
                    <h2 class="h1-responsive font-weight-bold   text-center">Informations client </h2>

                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Prise</th>
                            <th scope="col">Retour</th>
                            <th scope="col">Somme a verser</th>
                            <th scope="col">Somme  verser</th>
                            <th scope="col">+ Encaissement</th>
                            <th scope="col">solde </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultSelecAllvente as $vente) :
                                $date=$vente['date'];
                                $prise=$vente['prise_client'];
                                $retour=$vente['retour_client'];
                                $sommeAverser=$vente['somme_a_verser'];
                                $sommeVerser=$vente['somme_verser'];
                                $encaissement=$vente['user_encaissement'];
                                $solde=$vente['solde_actuel'];
                                ?>
                            <tr>
                                <th scope="row"><?=$date?> </th>
                                <td><?=$prise?> </td>
                                <td><?=$retour?> </td>
                                <td><?=$sommeAverser?> </td>
                                <td><?=$sommeVerser?> </td>
                                <td><?=$encaissement?> </td>
                                <td><?=$solde?> </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    
                    </table>
                </div>
        </div> 
        <!-- Grid row -->


        <!-- section modal -->
        <div class="modal fade" id="modifUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header text-center">
							<h4 class="modal-title w-100 font-weight-bold">Modifier compet client </h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<!-- Div loader -->
					<form action="" id="modifUser" class="" methode="POST">
						<div class="modal-body mx-3">
							<div class="md-form mb-5">
								<i class="fas fa-user prefix grey-text"></i>
								<input type="text" id="NomClient" class="form-control validate" name="NomClient" value="<?=$resultSelectAll['nom']?>">
								<label data-error="wrong" data-success="right" for="NomClient">Nom Client(te)</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fas fa-phone-volume prefix grey-text"></i>
								<input type="number" id="numero" class="form-control validate" name="PrixClient" value="<?=$resultSelectAll['numero']?>">
								<label data-error="wrong" data-success="right" for="Prix">Numero</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fas fa-map-marked prefix grey-text"></i>
								<input type="text" id="adresse" class="form-control validate" name="PrixClient" value="<?=$resultSelectAll['adresse']?>">
								<label data-error="wrong" data-success="right" for="Prix">Adresse</label>
                            </div>
							<div class="md-form mb-5">
                                <i class="fas fa-tags prefix grey-text"></i>
								<select class="browser-default mdb-select  form-control validate" name="typeClient" id="Type" value="<?=$resultSelectAll['type_client']?>">
									<option value="" disabled selected>Type Client</option>
									<option value="r">Revendeur</option>
									<option value="d">Domicile</option>
								</select>
                            </div>
                            
                            <div class="md-form mb-4">
                            <i class="far fa-money-bill-alt  prefix grey-text"></i>
								<input type="number" id="Prix" class="form-control validate" name="PrixClient" value="<?=$resultSelectAll['unitary_price']?>">
								<label data-error="wrong" data-success="right" for="Prix">Prix unitaire</label>
							</div>
							
                            <div class="md-form mb-4">
                                <i class="fas fa-cash-register prefix grey-text"></i>
								<input type="number" id="solde" class="form-control validate" name="PrixClient"  value="<?=$resultSelectAll['solde']?>">
								<label data-error="wrong" data-success="right" for="Prix">Solde</label>
                                <input type="hidden" name="idClient" id="idClient" value="<?=$resultSelectAll['id']?>">
							</div>
                            

						</div>
						<div class="modal-footer d-flex justify-content-center">
							<button class="btn btn-indigo" id="btnModifUser">Modifier <i class="fas fa-paper-plane-o ml-1"></i></button>
                            <button class="btn btn-danger" id="modifClose" data-dismiss="modal">Fermer <i class="fas fa-paper-plane-o ml-1"></i></button>

						</div>
					</div>
				</form>
			</div>
        </div>
        <!-- Modal passwort admin -->
        <!-- Modal -->
            <div class="modal fade" id="passwordAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">

            <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
            <div class="modal-dialog modal-dialog-centered" role="document">


                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Mot de passe Admin </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="md-form mb-4">
                        <i class="far fa-address-card prefix grey-text"></i>
                        <input type="text" id="nameAdmin" class="form-control validate" name="nameAdmin">
                        <label data-error="wrong" data-success="right" for="Prix">Nom Admin</label>
                    </div>
                    <div class="md-form mb-4">
                        <i class="fas fa-unlock-alt prefix grey-text"></i>
                        <input type="password" id="passAdmin" class="form-control validate" name="nameAdmin">
                        <label data-error="wrong" data-success="right" for="Prix">Passwor Admin</label>
                    </div>
                </div>
                <div class="modal-footer " style="text-align:center">
                    <button type="button" class="btn btn-primary" id="btnAdmin">Verifier</button>
                    <button type="button" class="btn btn-danger"  data-dismiss="modal" id="btnClose">Close</button>

                </div>
                </div>
            </div>
            </div>
        <!-- fin modal password admin  -->
        <!-- fin section moda; -->

</section>

<!-- Section: Team v.1 -->
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
	<!-- MI OWN SRCIPT JS -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- Tooltips -->
    <!-- <script type="text/javascript" src="https://mdbootstrap.com/previews/docs/latest/js/popper.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

    <!-- Bootstrap core JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
        crossorigin="anonymous"></script>
    <!-- MDB core JavaScript -->
    <!-- <script type="text/javascript" src="https://mdbootstrap.com/previews/docs/latest/js/mdb.min.js"></script> -->
    <script type="text/javascript" src="static/js/mdb.min.js"></script>
	<!-- <script type="text/javascript" src="https://mdbootstrap.com/previews/docs/latest/js/mdb.min.js"></script> -->
	<script type="text/javascript" src="https://mdbootstrap.com/previews/docs/latest/js/mdb.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="static/js/client.js"></script>
    <script src="static/js/script.js"></script>
</body>

</html>