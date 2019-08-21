<?php
    require 'static/Admin/DataBase.php';

        extract($_POST);
        $db=DB::connect();
        $selectInfo=$db->prepare('SELECT *  FROM user GROUP BY (nom) ORDER BY solde  DESC ');
        $selectInfo->execute(array());
        $resultSelectInfo=$selectInfo->fetchAll();
        
        
        
        //SELECTION DES VENTE CORRESPONDANT A AU DIFFERENTE DATE SELECTIONNE 
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
    <!--DATA TABLE LINK-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="static/css/vente.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <!-- Material Design Bootstrap -->
        <link href="static/css/mdb.min.css" rel="stylesheet">
	    <link rel="stylesheet" href="static/bmn/bmn.css" />
        <!-- Material Design Bootstrap -->
        <link href="static/css/mdb.min.css" rel="stylesheet">
</head>
<body  onload=" loadingPage() " >
	<div class="chargementPage">
		
		<div class="preloader-wrapper active">
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
<section id="bodySection" style="display:none">
    <header>
        <?php include("views/include/navBar.php") ?>
    </header>
<!--SECTION TABLEAU-->
<div class="sectionTab container">
    <h1>Liste des client </h1>
    <table class="table col-lg-7 col-md-6 mb-lg-0  col-md-8 tableau table-responsive-md table-striped" id="myTable" >
    <thead>
        <tr>
        <th scope="col">Plus </th>
        <th scope="col">Nom</th>
        <th scope="col">Adresse</th>
        <th scope="col">Numero</th>
        <th scope="col">prix unitaire</th>
        <th scope="col">Type clien</th>
        <th scope="col">Solde</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        foreach ($resultSelectInfo as $inforUser ) :
            $id=$inforUser['id'];
            $nom=$inforUser['nom'];
            $adresse=$inforUser['adresse'];
            $numero=$inforUser['numero'];
            $prix_unitaire=$inforUser['unitary_price'];
            $type=$inforUser['type_client'];
            $solde=$inforUser['solde'];
       
    ?>
        <tr>
            <td scope="row"><a href="client.php?id=<?=$id?>"><i class="fas fa-plus"></i></a></td>
            <td><?=$nom?></td>
            <td><?=$adresse?></td>
            <td><?=$numero?></td>
            <td><?=$prix_unitaire?></td>
            <td><?=$type?></td>
            <td><?=$solde?></td>
            
        </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
        <tr>
            <th scope="col">Plus info</th>
            <th scope="col">Nom</th>
            <th scope="col">Adresse</th>
            <th scope="col">numero</th>
            <th scope="col">prix unitaire</th>
            <th scope="col">type client</th>
            <th scope="col">Solde</th>
        </tr>
    </tfoot>
    </table>
</div>
<!--FIN DE LA SECTION TABLEAU -->
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

</section>

   
    <!--FIN DE LA PAGE -->

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
	<!-- MI OWN SRCIPT JS -->
	<script src="static/js/allUser.js"></script>
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
	    <!-- BMN JS -->
		<script src="static/bmn/bmn.min.js"></script>
    	<script src="static/js/demo.js"></script>
    	<script type="text/javascript">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-36251023-1']);
			_gaq.push(['_setDomainName', 'jqueryscript.net']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>

        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	
	
	<!-- SCRIPTS -->
	<script>
		function loadingPage(){
			document.querySelector("#bodySection").style.display="block";
			document.querySelector(".chargementPage").style.display="none";
		}
	</script>
	
	<script>
		function reloadPage() {
		return "Write something clever here...";
		}
		
	</script>

</body>

</html>