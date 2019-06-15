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

<body>
<header>
			<?php include("views/include/menu.php") ?>

		</header>
	<div class="container mt-4">
	

		<form action="# " method="post">
			<div class="row entete">
					<div class="col-md-4 Tab_left">
						<!-- Tableau d'entete -->
							<table class="table table-striped" >
								<thead>
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
					<div class="col-md-4 date">
						<h4>Date du jour </h4>
 						<div class="md-form">
						<input placeholder="Selected date" type="text" id="date-picker-exampleb" class="form-control datepicker dateDuJour">
						<label for="date-picker-example">Try me...</label>
						</div>
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
									<th scope="col">Valleur</th>
								</tr>
							</thead>
						</table>
					</div>
					
				<!-- TABLEAU DROIT -->
				
			</div>
<!-- ________________________________FIN DE LA SECTION DES ENTETE___________________________________________________ -->
		<!--SECTION VENTE-->
			<div class="containeur">
				<div class="vente_du_jour">
					<h4>Vente du jour </h4>
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
		<!-- SECTION MODAL MDB -->
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
						<div class="alert alert-success box-info hideDiv" role="alert" id="box-success">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="alert-heading box-infoHeding">:) INSCRIPTION VALIDÉ :)</h4>
							<p class="box-infoHeding"></p>
						</div>
						<!-- FIN DIV SUCCESS -->
						<!--DIV WARNING -->
						<div class="alert alert-warning  hideDiv" role="alert" id="box-warning" >
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="alert-heading box-infoHeding">;{( Erreur Doublon ;{(</h4>
							<p class="box-infoHeding"></p>
						</div>
						<!-- FIN DIV WARNING -->
						<!--DIV DANGER -->
						<div class="alert alert-danger box-info hideDiv" role="alert" id="box-danger">
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
								<i class="fas fa-user prefix grey-text"></i>
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

</body>

</html>