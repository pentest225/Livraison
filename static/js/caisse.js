$(function(){
    var linesNumber = 50;
    var AllClient=[];
    var idBoulagerie=0;
    var btnSaveVente=document.querySelector("#saveVente");
    var Prise=0;
    var newSoldeClient=0;
    var newTotal=0;
    var PrixUnitaireBoul=0;
    var prixUnitaireClient=0;
    var Retour=0;
    var Versement=0;
    var SommeAVerse=0;
    var Manquant=0;
    var totalManquant=0;
    var soldeClient=0;
    var retourClient=0;
    var varsementClient=0;
    var SommeAverserClient=0;
    var inputRetourClient="";
    var inputSommeRecuLivreur=document.querySelector('#SommeVerseLivreur');
    var inputManquantLivreur =document.querySelector('#manquantLivreur');
    var inputRestPrise=document.querySelector('#restPrise');
    var btnValidBoul=document.querySelector(".valideBoul");
    var btnCloseBoule=document.querySelector(".closeSectionBoul")
    var restPrise=0;
    var restPriseVente=0;
    var inputMaquantDuJour=document.querySelector('#ManquantDuJour');
    var inputSommeAVerser=document.querySelector('#SommeAVerser');
    var inputTotalManquant=document.querySelector('#totalManquant');
    var inputPrise=document.querySelector('#Prise');
    var inputRetour=document.querySelector('#Retour');
    var inputversement=document.querySelector('#Versement');
    var inputDateBoul=document.querySelector(".inputDateBoulangerie");
    var inputTotalSommeRecue=document.querySelector("#totalSomme");
    var selectBoul=document.querySelector("#selectBoulangerie");
    var inputDateVente=document.querySelector(".dateVente");
    var box_info=document.querySelector(".box_info");
    var box_success =document.querySelector("#box-success");
    var box_warning =document.querySelector("#box-warning");
    var box_danger =document.querySelector("#box-danger");
    var dateVente =document.querySelector(".dateVente").value;
    var arrayTableau=document.getElementById('dtBasicExample').rows;
    for (var i= 0 ;i <linesNumber ;i++){
        arrayTab=document.getElementById('tbody');
            var ligne=arrayTab.insertRow();
            ligne.className="ligne";
            celNom=ligne.insertCell(0);
            celNom.innerHTML+=(i+1);
            celNom=ligne.insertCell(1);
            celNom.innerHTML+="<input type='text' placeholder=''  class='tableInput NomClient"+i+"' id='NomClient"+i+"' name='NomClient"+i+"' autocomplete='off' data-provide='typeahead'><div class='sugestion"+i+" liste '></div>";
            celSommeVerser=ligne.insertCell(2);
            celSommeVerser.innerHTML+="<input type='number' placeholder='' class='tableInput SommeVerser"+i+"'> ";
            celEtatSolde=ligne.insertCell(3);
            celEtatSolde.innerHTML+="<input type='text' readonly class='tableInput  EtatSolde"+i+"'>";
            celSolde=ligne.insertCell(4);
            celSolde.innerHTML+="<input type='number' readonly class='tableInput  valSolde"+i+"'>";
    }
    var allInput =document.querySelectorAll('.tableInput');

    //ON DESACTIVE TOUS LES INPUT SI LA DATE EST VIDE 
    if(dateVente ===""){
        console.log("Les chat doivente etre desactive ");
        console.log(allInput);
        for(var i = 0 ;i<allInput.length;i++){
            allInput[i].disabled=true;
        }
    }

    //ON ACTIVE LES INPUT SI LA DATE EST SELECTIONNE 
    inputDateVente.onchange=function(){
        dateVente=this.value;
        if(dateVente !=""){
            console.log(dateVente)
            for(var i = 0 ;i<allInput.length;i++){
                allInput[i].disabled=false;
            }
        }else{
            
            for(var i = 0 ;i<allInput.length;i++){
                allInput[i].disabled=true;
            }
            alertError("Veille selectionnee une date valide ");
        }
        
    }

    //VERIFICATION DU CLIENT EN BASE DE DONNE 
    for(var i =0 ;i< linesNumber;i++){
        var NomClient =document.querySelector(".NomClient"+i+"");
            NomClient.addEventListener('change',function(){
                var nom = this.value.toLowerCase();
                var etatSolde =this.parentElement.parentElement.children[3].children[0];
                var montantSolde =this.parentElement.parentElement.children[4].children[0];
                var clientExit=false;
                    $.ajax({
                        type: "Post",
                        url: 'static/php/livraison.php',
                        data:{Action:'VerifClient',Nom:nom} ,
                        dataType: "json",
                        success: function (response) {
                            if(response.NameExist){
                                etatSolde.value=verifEtatSolde(response.newSolde);
                                soldeClient=parseInt(response.newSolde);
                                prixUnitaireClient=response.prixUnitaireClient;
                                montantSolde.value=parseInt(response.newSolde);
                            }
                            else{

                                clientExitpas(nom);
                                NomClient.value=''
                                
                            }
                        }
                    });
            });
    }

    //Traitement pour les modifiaction des Sommme Verser  
    for(var i =0 ;i< linesNumber;i++){
        var SommeVerser =document.querySelector(".SommeVerser"+i+"");
                SommeVerser.addEventListener('input',function(){
                var Somme = 0;
                this.value ==''?Somme=0:Somme=parseInt(this.value);
                parcourSommeRecu();
                var nom=this.parentElement.parentElement.children[1].children[0].value;
                var etatSolde =this.parentElement.parentElement.children[3];
                var montantSolde =this.parentElement.parentElement.children[4].children[0];
                $.ajax({
                    type: "Post",
                    url: 'static/php/livraison.php',
                    data:{Action:'VerifClient',Nom:nom} ,
                    dataType: "json",
                    success: function (response) {
                        if(response.NameExist){
                            newSoldeClient =parseInt(response.newSolde) - Somme;
                            montantSolde.value=parseInt(newSoldeClient);
                            montantSolde.disabled=true;
                            etatSolde.value=verifEtatSolde(parseInt(newSoldeClient));
                            etatSolde.disabled=true;
                        }else{
                            clientExitpas(nom);
                        }
                    }
                });
                
                
                etatSolde.value=verifEtatSolde(parseInt(newSoldeClient) - Somme);
                montantSolde.value=(parseInt(newSoldeClient) - Somme);
            });
    }
    //Ajout d'un utilisateur 
    $('#formAddUser').submit(function(e){
        e.preventDefault();

        var nomClient =$('#NomClient').val();
        var divLoader =document.querySelector("#divLoader");
        var form =document.querySelector("#formAddUser");
        
        var Prix =$('#Prix').val();
        var type =$('#Type').val();
        var ErrorInput =false;
        var textError=[];
        
        nomClient=nomClient.toLowerCase();

        if(nomClient==undefined || nomClient=="")
            {
                ErrorInput=true;
                textError[0]='Veillez saisir le nom du client';
            }
        if((Prix < 100)||(Prix >150))
            {
                ErrorInput=true;
                textError[1]='Le prix unitire dois etre compris entre 100 et 150';
            }
        if(type =="")
            {
                ErrorInput=true;
                textError='Veillez selectionne le type de client';
            }
        if(ErrorInput){
            for(var i =0 ; i<textError.length ;i++){
                alertError('erreur',textError[i]);
            }
            
        }
        else
        {
            
            $.ajax({
            type:'Post',
            url:'static/php/livraison.php',
            data:{Action:'CreationCompte',Nom:nomClient,PrixAchat:Prix,typeClient:type},
            dataType:'json',
            success:function (response){
                if(response.NameExist){
                    textError= "Désolé il existe dejat client nommé  "+nomClient+" dans la liste de vos client " ;
                    alertError('Boublon',textError);
                }
                if(response.InsertionOk){
                    AllClient.push(nomClient);
                   
                    text= "Felicitation le client "+nomClient+"  a été ajouté avec succes  " ;
                    alertSusess(text);
                
                }
            }
         })
        }
        
    })
    //ENREGISTREMENT DE LA VENTE DU JOURS 
    btnSaveVente.addEventListener("click",function(){
        var tableauVente=[];
        for(var i = 0; i <linesNumber ;i++){
            var tabNomClient=document.querySelector(".NomClient"+i+"").value;
            var tabSommeVerser =document.querySelector(".SommeVerser"+i+"").value;
            var tabTotalSoldeClient=document.querySelector(".valSolde"+i+"").value;
            if(tabNomClient ===""){
                break;
            }
            else{
                var objClient ={
                    nom:tabNomClient,
                    sommeVerser:parseInt(tabSommeVerser),
                    solde:parseInt(tabTotalSoldeClient)
                }
            }
            tableauVente.push(objClient);
        }
        $.ajax({    
            type: "Post",
            url: 'static/php/livraison.php',
            data:{Action:'InsertionEncaissement',date:dateVente,tab:tableauVente} ,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if(response.InsertionOk){
                    var text ='Enregistrement effectuer ';
                    console.log("Enregistrement effectue ");
                    alertSusess(text); 
                }
                if(response.dateExiste){
                    alertError('Desole une insertion a dejat ete faite a cette date ');
            }
            }
        });
    })
           

    //SECTION DES FUNCTIONS 
    //FONTION POUR SIGNALE SI LE CLIENT EXISTE PAS EN BD
    function clientExitpas(nomDuClient){
        var creationCompt=confirm('Desole Ce Client '+nomDuClient+' Existe pas dans la liste des client\nvoulez vous cree un compt pour ce client');
            if(creationCompt)
            {
                $('#creationCompt').click();
            }
            return creationCompt;
    }
    //FONCTION POUR LA SOMME RECU TOTAL 
    function parcourSommeRecu(){
        var total=0;
        for(var i =0;i < linesNumber;i++){
            var valeurRecue=document.querySelector(".SommeVerser"+i+"").value;
            valeurRecue ==''?valeurRecue=0:valeurRecue=valeurRecue;
            total +=parseInt(valeurRecue);
        }
        console.log(total);
        inputTotalSommeRecue.value=(total);
        inputTotalSommeRecue.innerHTML="<strong>"+total+"</strong>"
    }
    function verifEtatSolde( solde){
        if(parseInt(solde) > 0){
           return "cediteur";
        }
        if(parseInt(solde) < 0){
            return "debiteur";
        }
        if(parseInt(solde) == 0){
            return "null";
        }
        return "VALLEUR NON NUMERIQUE";
 
    }
    //FONCION ALERTE 
    function alertSusess(text) {
        const Toast = Swal.mixin({
             toast: true,
             position: 'top-end',
             showConfirmButton: false,
             timer: 3000
           });
  
           Toast.fire({
             type: 'success',
             title: text
           })
     }
    function alertError(text){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
 
          Toast.fire({
            type: 'error',
            title: text
          })
    }


    // Data Picker Initialization
    // $('.datepicker').pickadate();
    // Extend the default picker options for all instances.
    $.extend($.fn.pickadate.defaults, {
        monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre',
        'Novembre', 'Décembre'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        today: 'aujourd\'hui',
        format: 'yyyy/mm/dd',
        clear: 'effacer',
        formatSubmit: 'yyyy/mm/dd'
        })
        
        //Or, pass the months and weekdays as an array for each invocation.
        $('.datepicker').pickadate({
        monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre',
        'Novembre', 'Décembre'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        today: 'aujourd\'hui',
        clear: 'effacer',
        format: 'yyyy/mm/dd',
        formatSubmit: 'yyyy/mm/dd'
        })
})