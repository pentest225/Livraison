<?php 
	include 'static/php/request.php';
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
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="static/css/style.css">
    <!-- Material Design Bootstrap -->
    <link href="static/css/mdb.min.css" rel="stylesheet">
</head>

<body onbeforeunload="return myFunction()">
<header>
			<?php include("views/include/menu.php") ?>

		</header>
	<div class="container mt-4">
	

		<form action="# " method="post">
			<div class="bontonHeader">
				<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#fullHeightModalRight" id="">
					Add Prise et versement <span class="badge badge-warning ml-2">+</span>
				</button>
				<button type="button" class="btn btn-success "  id="saveVente">
					Enregistre  <span class="badge badge-warning ml-2"></span>
				</button>
			</div>
			
			<!-- Full Height Modal Right -->
			<div class="modal fade top" id="fullHeightModalRight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">

			<!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
			<div class="modal-dialog modal-full-height  modal-top " role="document">

				<div class="modal-content">
				<div class="modal-header">
							<div class="col-md-4 date">
								<h5>Prise du ...</h5>
								<div class="md-form ">
								<input placeholder="date de la prise" type="text" id="date-picker-exampleb" class="form-control datepicker inputDateBoulangerie">
								<label for="date-picker-example">Try me...</label>
								</div>
							</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					...<!-- SECTION ENTRTR DU TABLEAUX --->
					<div class="row entete">
			
							<div class="col-md-4 Tab_left">
								<!-- Tableau d'entete -->
									<table class="table table-striped" >
										<thead>
											<tr>
												<th scope="col">Boulangerie</th>
												<th scope="col">
												<select class="browser-default mdb-select  form-control validate" id="selectBoulangerie" id="Type">
													<option value=""  selected>...</option>
													<?php 
													foreach($InfoBoul as $Boulangerie) :
															$id=$Boulangerie['id'];
															$nom=$Boulangerie['nom'];
													?>
														<option value="<?=$id?>">
														<?=$nom?>	
														</option>
														<?php endforeach ?>
													
												</select>
												</th>
											</tr>
											<tr>
												<th scope="col">Prise du jour</th>
												<th scope="col"><input type="number" name="Prise" placeholder="prise" id="Prise" value='0'></th>
											</tr>
											<tr>
												<th scope="col">Retour</th>
												<th scope="col"><input type="number" name="Retour" placeholder="Retour" id="Retour" value='0'></th>
											</tr>
											<tr>
												<th scope="col">Somme A verser</th>
												<th scope="col" id="SommeAVerser">Valleur</th>
											</tr>
										</thead>
									</table>
								</div>
							<div class="col-md-4 ">
								<!--<h4>Prise du ...</h4>
								<div class="md-form">
								<input placeholder="date de la prise" type="text" id="date-picker-exampleb" class="form-control datepicker dateDuJour">
								<label for="date-picker-example">Try me...</label>
								</div> -->
							</div>
						<!-- FIN TABLEAU GAUCHE -->
							<div class="col-md-4  Tab_right">
								<table class="table table-striped">
									<thead>
										<tr>
											<th scope="col">VERSEMENT</th>
											<th scope="col"><input type="number" name="Versement" placeholder="Versement" id="Versement"></th>
										</tr>
										<tr>
											<th scope="col">Manquant Du jour </th>
											<th scope="col" id='ManquantDuJour'>Valleur</th>
										</tr>
										<tr>
											<th scope="col">Total  Manquant</th>
											<th scope="col" id="totalManquant">Valleur</th>
										</tr>
									</thead>
								</table>
							</div>
			
							<!-- TABLEAU DROIT -->
						</div>
	<!-- FIN DE LA SECTION ENTETE -->
					</div>
				<div class="modal-footer justify-content-center">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary valideBoul" id="saveChangeFormBoul">Save changes</button>
				</div>
				</div>
			</div>
			</div>
			<!-- Full Height Modal Right -->

<!-- ________________________________FIN DE LA SECTION DES ENTETE___________________________________________________ -->
		<!--SECTION VENTE-->
			<div class="containeur">

				<div class="vente_du_jour">
					<h4>Vente du jour </h4>
					<div class="row venteDuJourRow">
						<div class="col-xs-6">
							<div class="card w-10">
								<div class="card-body">
									<div class="divUl">
										<h5>Rest Prise</h5>
										<p id="restPrise">Valleur<p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 date">
							<div class="md-form">
								<input placeholder="Date de vente" type="text" id="date-picker-exampleb" class="form-control datepicker dateVente " >
								<label for="date-picker-example">Try me...</label>
							</div>
						
						</div>
						<div class="col-xs-6">
							<div class="card w-10">
								<div class="card-body">
								<div class="divUl">
									<div class="divUl">
										<h5>Total Somme</h5>
										<p id="totalSomme">Valleur<p>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
					<!--Big blue-->
				</div>
			</div>
			<!--SECTION TABLEAUX  CLIENTS -->

			<!-- section table mdn -->
		<table id="dtBasicExample" class="table  table-sm table-hover table-responsive-md " cellspacing="0" width="100%">
			<thead>
				<tr>
				<th class="th-sm-6">N°
				</th>
				<th class="th-sm">Name
				</th>
				<th class="th-sm">Prise
				</th>
				<th class="th-sm">Retour
				</th>
				<th class="th-sm">total S
				</th>
				<th class="th-sm">somme recu
				</th>
				<th class="th-sm">etat solde 
				</th>
				<th class="th-sm">valleur solde 
				</th>
				</tr>
			</thead>
			<tbody id="tbody">
			</tbody>
			<tfoot>
				<tr>
				<th>N°
				</th>
				<th>Name
				</th>
				<th>Prise
				</th>
				<th>Retour
				</th>
				<th>total S
				</th>
				<th>somme recu
				</th>
				<th>etat solde 
				</th>
				<th>Solde
				</th>
				</tr>
			</tfoot>
		</table>
		</form>
	</div>
		<!-- SECTION MODAL CREATION COMPTE CLIENT MDB -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header text-center">
							<h4 class="modal-title w-100 font-weight-bold">Creation de compte Client</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<!-- Div loader -->
						<div class="text-center mt-5 hideDiv" id="divLoader">
							<div class="preloader-wrapper small active " >
								<div class="spinner-layer spinner-blue-only">
									<div class="circle-clipper left">
									<div class="circle"></div>
									</div>
									<div class="gap-patch">
									<div class="circle"></div>
									</div>
									<div class="circle-clipper right">
									<div class="circle"></div>
									</div>
								</div>
							</div>
						</div>
						<!-- Fin div loader -->
						<!--DIV SUCCESS -->
						<div class="alert alert-success box-info " role="alert" id="box-success">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="alert-heading box-infoHeding">:) INSCRIPTION VALIDÉ :)</h4>
							<p class="box-infoHeding"></p>
						</div>
						<!-- FIN DIV SUCCESS -->
						<!--DIV WARNING -->
						<div class="alert alert-warning  " role="alert" id="box-warning" >
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="alert-heading box-infoHeding">;{( Erreur Doublon ;{(</h4>
							<p class="box-infoHeding"></p>
						</div>
						<!-- FIN DIV WARNING -->
						<!--DIV DANGER -->
						<div class="alert alert-danger box-info " role="alert" id="box-danger">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="alert-heading box-infoHeding">;{( Erreur Saisie ;{(</h4>
							<p class="box-infoHeding"></p>
						</div>
						<!-- FIN DIV DANGER -->
					<form action="" id="formAddUser" class="">
						<div class="modal-body mx-3">
							<div class="md-form mb-5">
								<i class="fas fa-user prefix grey-text"></i>
								<input type="text" id="NomClient" class="form-control validate" name="NomClient">
								<label data-error="wrong" data-success="right" for="NomClient">Nom Client(te)</label>
							</div>
							<div class="md-form mb-5">
								
								<select class="browser-default mdb-select  form-control validate" name="typeClient" id="Type">
									<option value="" disabled selected>Type Client</option>
									<option value="r">Revendeur</option>
									<option value="d">Domicile</option>
								</select>
							</div>
							<div class="md-form mb-4">
								<i class="fas fa-envelope prefix grey-text"></i>
								<input type="number" id="Prix" class="form-control validate" name="PrixClient">
								<label data-error="wrong" data-success="right" for="Prix">Prix D'Achat</label>
							</div>

						</div>
						<div class="modal-footer d-flex justify-content-center">
							<button class="btn btn-indigo" id="Validation" >Enregistre <i class="fas fa-paper-plane-o ml-1"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>

<!-- FIN DE LA SECTION MODAL MDB -->

<!-- SECTION MODAL CREATION COMPTE BOULANGERIE MDB -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header text-center">
							<h4 class="modal-title w-100 font-weight-bold">Creation de compte Boulangerie</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="box_info">
							<h4></h4>
							<p></p>
						</div>
					<form action="" id="formAddBoullangerie" class="">
						<div class="modal-body mx-3">
							<div class="md-form mb-5">
								<i class="fas fa-user prefix grey-text"></i>
								<input type="text" id="nomBoul" class="form-control validate" name="nomBoul">
								<label data-error="wrong" data-success="right" for="NomClient">Nom Boulangerie</label>
							</div>
							<div class="md-form mb-4">
								<i class="fas fa-envelope prefix grey-text"></i>
								<input type="number" id="prixBoul" class="form-control validate" name="prixBoul">
								<label data-error="wrong" data-success="right" for="Prix">Prix D'Achat</label>
							</div>

						</div>
						<div class="modal-footer d-flex justify-content-center">
							<button class="btn btn-indigo" id="Validation" >Enregistre <i class="fas fa-paper-plane-o ml-1"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>

<!-- FIN DE LA SECTION MODAL COMPTE BOULANGERIE MDB -->
  	</div>

    <!-- SCRIPTS -->

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
	<!-- MI OWN SRCIPT JS -->
	<script src="static/js/script.js"></script>

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
	<script>
		function myFunction() {
		return "Write something clever here...";
		}
	</script>

</body>

</html>