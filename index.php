<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
        crossorigin="anonymous">
    <!-- ME OWN CSS -->
    <link rel="stylesheet" href="static/css/style.css">
    <!-- Material Design Bootstrap -->
    <link href="static/css/mdb.min.css" rel="stylesheet">
</head>

<body>
<header>
			<?php include("views/include/menu.php") ?>
		</header>
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
						<h4>Date du jour </h4><input type="date" name="" id="dateDuJour">
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
				</div>
			</div>
			<!--SECTION TABLEAUX  CLIENTS -->
			<div class="row navigation">
				<div class="col-md-4">
					<input type="button" name="" class="btn btn-success " id="addLine" onclick="ajouterLigne();" value="Ajouter une ligne">
				</div>
				<div class="col-md-4 col-md-offset-8 restPrise">
					<h4>Rest prise :</h4><h4 class="restVal">125</h4>
				</div>
				
			</div>
		
			<table class="table table-striped" id="Tableau" >
			  <thead>
			    <tr>
				<th scope="col">N°</th>
			      <th scope="col">Nom</th>
			      <th scope="col">Prise</th>
			      <th scope="col">Somme A verser </th>
			      <th scope="col">Somme verser </th>
			      <th scope="col">Etat Solde</th>
			      <th scope="col">Montant Solde</th>
			    </tr>
			  </thead>
			</table>
			<a type="submit" name="Soumetre" class="btn btn-success  "> SOUMETRE LE FORMULAIRE </a>
		</form>
	<!-- section modal  -->
		<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h2 class="modal-title" style="text-align: center;">Creation de compt Client</h2>
	        </div>
	        <div class="modal-body">
	                <form action="#" method="post" id='formAddUser' style='margin:0 80px' >
	                <div class="row">
	                    <div class="form-group ">
	                        <label for="NomClient">Nom Client</label>
	                        <input id="NomClient" class="form-control" type="text" name="NomClient">
	                    </div>
	                    <div class="form-group ">
	                        <label for="Prix">Prix D'Achat</label>
	                        <input id="Prix" class="form-control" type="number" name="PrixClient">
	                    </div>
	                    <div class="form-group ">
	                        <label for="NomClient">Type Client</label>
	                        <select name="typeClient" id="Type" class="form-control">
	                            <option value="" >...</option>
	                            <option value="r" >Revendeur(se)</option>
	                            <option value="d" >Domicile</option>
	                        </select> 
	                    </div> 
	                    <button id="Validation" class="btn btn-success">Enregistre </button>
	                </div>
	            </form>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	      </div>
			<!--  fin de la section modal-->    
		</div>
  </div>
  <!-- MI OWN SRCIPT JS -->
  <script src="static/js/script.js"></script>

    <!-- SCRIPTS -->

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

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

</body>

</html>