<?php
    require 'static/Admin/DataBase.php';

        extract($_POST);
        $db=DB::connect();
        $lastDate=$db->prepare('SELECT id , date FROM vente GROUP BY (date) ORDER BY date DESC LIMIT 7 ');
        $lastDate->execute(array());
        $resultLatDate=$lastDate->fetchAll();
        
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
    <!--<link rel="stylesheet" href="static/css/style.css">-->
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
        

        <div class="container mt-3">
            
            <!-- Tab panes -->
            <div class="tab-content sectionDynamique">
                <?php for($i=0 ;$i<sizeof($resultLatDate);$i++)  :?>
                    <div id="lien<?=trim($resultLatDate[$i]['id'])?>" class="container tab-pane fade"><br>
                        <h3>Vente du <?=$resultLatDate[$i]['date']?></h3>
                        <!-- selection des information correspondant a la date en coure -->
                        <?php $db=DB::connect();
                            $selectAll=$db->prepare('SELECT * FROM vente WHERE date =?');
                            $selectAll->execute(array($resultLatDate[$i]['date']));
                            $resultSelectAll=$selectAll->fetchAll();
                            $selectAllPrise=$db->prepare('SELECT * FROM boulangerie WHERE date =?');
                            $selectAllPrise->execute(array($resultLatDate[$i]['date']));
                            $resultSelectAllPise=$selectAllPrise->fetchAll();
                        ?>

                        <!-- SECTION PRISE -->
                        <div id="SectionPrise">
                            <!--ICI -->
                            <div class="row grandeRow">
                                    <div class="row venteDuJourRow">
                                        <div class="col-xs-4">
                                            <div class="card w-10 cadre ">
                                                <div class="card-body">
                                                    <div class="divUl">
                                                        <h5>Prise</h5>
                                                        <p class="prise"><?=$resultSelectAllPise[0]['prise']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-4">
                                            <div class="card w-10 cadre">
                                                <div class="card-body">
                                                <div class="divUl">
                                                    <div class="divUl">
                                                        <h5>Somme a verser</h5>
                                                        <p class="sommeAVerser"><?=$resultSelectAllPise[0]['somme_a_verser']?></p>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row venteDuJourRow">
                                        
                                        
                                        <div class="col-xs-4">
                                            <div class="card w-10 cadre">
                                                <div class="card-body">
                                                <div class="divUl">
                                                    <div class="divUl">
                                                        <h5>Retour</h5>
                                                        <p class="retour"><?=$resultSelectAllPise[0]['retour']?></p>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">
                                            <div class="card w-10 cadre">
                                                <div class="card-body">
                                                <div class="divUl">
                                                    <div class="divUl">
                                                        <h5>Manquant du jours</h5>
                                                        <p class="manquantJour"><?=$resultSelectAllPise[0]['manquant_du_jour']?></p>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            <!--ICI 2 -->
                           
                                    <div class="row venteDuJourRow">
                                        <div class="col-xs-4">
                                            <div class="card w-10 cadre">
                                                <div class="card-body">
                                                    <div class="divUl">
                                                        <h5>Somme Verser</h5>
                                                        <p class="sommeVerser"><?=$resultSelectAllPise[0]['somme_verser']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                       
                                        <div class="col-xs-4">
                                            <div class="card w-10 cadre">
                                                <div class="card-body">
                                                <div class="divUl">
                                                    <div class="divUl">
                                                        <h5>Solde</h5>
                                                        <p class="manquant"><?=$resultSelectAllPise[0]['total_manquant']?></p>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <!--FIN ICI -->
                           
                        </div>

                        <!--section tableau -->
                        <div id="sectionTableau">
                            <table id="tableauVente" class="table table-striped table-responsive-md  table-sm" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="th-sm">Nom
                                        </th>
                                        <th class="th-sm">Prise
                                        </th>
                                        <th class="th-sm">Retour
                                        </th>
                                        <th class="th-sm">Somme a verser
                                        </th>
                                        <th class="th-sm">Somme verser
                                        </th>
                                        <th class="th-sm">Etat Solde
                                        </th>
                                        <th class="th-sm">Solde
                                        </th>
                                        <th class="th-sm">plus d'info
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="tableBody">
                                    <?php foreach($resultSelectAll as $info): 
                                        $id=$info['id_client'];
                                        $nom=$info['nom_client'];
                                        $prise=$info['prise_client'];
                                        $retour=$info['retour_client'];
                                        $sommeAVerse=$info['somme_a_verser'];
                                        $sommeVerse=$info['somme_verser'];
                                        $solde=$info['solde_actuel'];

                                        ?>
                                    <a href="index.php" >
                                        <tr>
                                            <td> <?=$nom?>
                                            </td>
                                            <td><?=$prise?>
                                            </td>
                                            <td><?=$retour?>
                                            </td>
                                            <td><?=$sommeAVerse?>
                                            </td>
                                            <td><?=$sommeVerse?>
                                            </td>
                                            <td>Etat Solde
                                            </td>
                                            <td><?=$solde ?>
                                            </td>
                                            <td>
                                                <ul class="list-unstyled mb-0">
                                                    <!-- Facebook -->
                                                    <a class="p-2 fa-lg fb-ic" href="client.php?id=<?=$id?>">
                                                        <i class="glyphicon glyphicon-eye-open">voir</i>
                                                    </a>
                                                    
                                                </ul>
                                            </td>

                                        </tr>
                                    </a>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th>Nom
                                    </th>
                                    <th>Prsie
                                    </th>
                                    <th>Retour
                                    </th>
                                    <th>Somme a verser
                                    </th>
                                    <th>Somme verser
                                    </th>
                                    <th>Etat Solde
                                    </th>
                                    <th>Solde
                                    </th>
                                    <th class="th-sm">plus d'info
                                    </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- fin de la section tableau -->
                    </div>
                    
                <?php endfor ?>
                    <div id="autre" class="container tab-pane fade " ><br>
                        <div class="md-form ">
                            <input placeholder="Selected date" type="text" id="date-picker-example" class="form-control datepicker dateVente">
                            <label for="date-picker-example">Try me...</label>
                        </div>
                        <!--SECTION PRISE -->
                            <!-- SECTIN PRISE -->
                        <div id="SectionPrise">
                            <div class="row ">
                                <div class="col ">
                                    <p>prise</p>
                                    <p id="prise"></p>
                                </div>
                                <div class="col  ">
                                    <p>Retour</p>
                                    <p id="retour"></p>
                                </div>
                                <div class="col ">
                                    <p>Somme a verser </p>
                                    <p id="sommeAVerser"></p>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col ">
                                    <p>Somme verser </p>
                                    <p id="sommeVerser"></p>
                                </div>
                                <div class="col ">
                                    <p>Manquant du jour</p>
                                    <p id="manquantJour"></p>
                                </div>
                                <div class="col ">
                                    <p>Total Manquant</p>
                                    <p id="manquant"></p>
                                </div>
                            </div>
                        </div>
                        <!--FIN SECTION PRISE -->
                        <!--section tableau -->
                        <div id="sectionTableau">
                            <table id="tableauVente" class="table table-striped table-responsive-md  table-sm" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="th-sm">Nom
                                        </th>
                                        <th class="th-sm">Prise
                                        </th>
                                        <th class="th-sm">Retour
                                        </th>
                                        <th class="th-sm">Somme a verser
                                        </th>
                                        <th class="th-sm">Somme verser
                                        </th>
                                        <th class="th-sm">Etat Solde
                                        </th>
                                        <th class="th-sm">Solde
                                        </th>
                                        <th class="th-sm">Plus d' info
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th>Nom
                                    </th>
                                    <th>Prsie
                                    </th>
                                    <th>Retour
                                    </th>
                                    <th>Somme a verser
                                    </th>
                                    <th>Somme verser
                                    </th>
                                    <th>Etat Solde
                                    </th>
                                    <th>Solde
                                    </th>
                                    <th>plus d'info
                                    </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- fin de la section tableau -->
                        
                    </div>
            </div>
            <!-- Nav tabs -->
            
        </div>
        <div class="nav_buttom">
            <ul class="nav nav-tabs ">
                <?php for($i=0 ;$i<sizeof($resultLatDate);$i++)  :?>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#lien<?=trim($resultLatDate[$i]['id'])?>">lien<?=trim($resultLatDate[$i]['date'])?></a>
                    </li>
                <?php endfor ?>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#autre">Une Autre date </a>
                </li>
            </ul>
        </div>
    

    </section>
    <!--FIN DE LA PAGE -->

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
	<!-- MI OWN SRCIPT JS -->
	<script src="static/js/vente.js"></script>

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