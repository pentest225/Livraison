$(function()
{
    var ListeClient=0;
    var Prise=0;
    var PrixUnitaire=85;
    var Retour=0;
    var Versement=0;
    var SommeAVerse=0;
    var Manquant=0;
    var linesNumber = 50;
    var dateDuJour = document.querySelector(".dateDuJour").value;
    var arrayTableau=document.getElementById('dtBasicExample').rows;
    var nombreLignesTab=arrayTableau.length;
    console.log('bonjour le monde ');
    console.log(dateDuJour); 
    //creation des Ligne du tableau 
    for (var i= 0 ;i <linesNumber ;i++){
        arrayTab=document.getElementById('tbody');
            var ligne=arrayTab.insertRow();
            ligne.className="ligne";
            celNom=ligne.insertCell(0);
            celNom.innerHTML+=(i+1);
            celNom=ligne.insertCell(1);
            celNom.innerHTML+="<input type='text' placeholder='Non client' class='tableInput NomClient"+i+"'> ";
            celPrise=ligne.insertCell(2);
            celPrise.innerHTML+="<input type='number' placeholder='prise' class=' tableInput priseClient"+i+"'> ";
            celSommeAVerser=ligne.insertCell(3);
            celSommeAVerser.innerHTML+="<p class='SommeAverser"+i+"'>SommeAVerse <i> fr</i></p> ";
            celSommeVerser=ligne.insertCell(4);
            celSommeVerser.innerHTML+="<input type='number' placeholder='Somme Verse ' class='tableInput SommeVerser"+i+"'> ";
            celEtatSolde=ligne.insertCell(5);
            celEtatSolde.innerHTML+="<p class='EtatSolde"+i+"'>Etat soled</p>";
            celSolde=ligne.insertCell(6);
            celSolde.innerHTML+="<p class='valSolde"+i+"'>soled <i> fr</i></p> ";
    }
//L'EVENEMENT DECLANCHREUR C'EST DANS CE EVENEMENT QU'EST DEFFINI LA PORTER DE TOUTE LE VARAIBLE 
    $('#Prise').on('change',function () { 
        verifDate();
        Prise =$('#Prise').val();
        SommeAVerse=(Prise - Retour )*PrixUnitaire;
        Manquant=SommeAVerse-Versement;
        $('#SommeAVerser').html(SommeAVerse);
        $('#ManquantDuJour').html(Manquant);
    });
    $('#Retour').on('change',function(){
        verifDate();
        Retour =$('#Retour').val();
        SommeAVerse=(Prise - Retour )*PrixUnitaire;
        Manquant=SommeAVerse-Versement;
        $('#SommeAVerser').html(SommeAVerse);
        $('#ManquantDuJour').html(Manquant);
    })

    $('#Versement').on('change',function () { 
        verifDate();
        Versement =$('#Versement').val();
        SommeAVerse=(Prise - Retour )*PrixUnitaire;
        Manquant=SommeAVerse-Versement;
        $('#Versement').html(SommeAVerse);
        $('#ManquantDuJour').html(Manquant);
    });
    $('.dateDuJour').on('change',function () { 
        dateDuJour=this.value;
    });
    //Verification du client dans la base de donnee 
    for(var i =0 ;i< linesNumber;i++){
        var NomClient =document.querySelector(".NomClient"+i+"");
            NomClient.addEventListener('change',function(){
                verifDate();
                var nom = this.value.toLowerCase();
                var etatSolde =this.parentElement.parentElement.children[5];
                var montantSolde =this.parentElement.parentElement.children[6];
                console.log(etatSolde);
                var clientExit=false;
                    $.ajax({
                        type: "Post",
                        url: 'static/php/livraison.php',
                        data:{Action:'VerifClient',Nom:nom} ,
                        dataType: "json",
                        success: function (response) {
                            if(response.NameExist){
                                etatSolde.innerText=verifEtatSolde(response.newSolde);
                                montantSolde.innerText=response.newSolde;
                            }
                            else{
                                clientExitpas(nom);
                            }
                        }
                    });
                
            });
    }
        //Traitement pour les modifiaction des prise 
        for(var i =0 ;i< linesNumber;i++){
            var priseClient =document.querySelector(".priseClient"+i+"");
            priseClient.addEventListener('change',function(){
                verifDate();
                    var prise = this.value;
                    var nom =this.parentElement.parentElement.children[1].children[0].value;
                    var SommeAVerse =this.parentElement.parentElement.children[3];
                    var etatSolde =this.parentElement.parentElement.children[5];
                    var montantSolde =this.parentElement.parentElement.children[6];
                    console.log(prise);
                    var clientExit=false;
                        $.ajax({
                            type: "Post",
                            url: 'static/php/livraison.php',
                            data:{Action:'actualisationPrise',Nom:nom,date:dateDuJour,prise:prise} ,
                            dataType: "json",
                            success: function (response) {
                                if(response.NameExist){
                                    SommeAVerse.innerText=parseInt(prise) * parseInt(response.prixUnitaire) ;
                                    etatSolde.innerText=verifEtatSolde(response.newSolde);
                                    montantSolde.innerText=response.newSolde;
                                    //si le client est dans la base de bonne 
                                   
                                }
                                else{
                                    clientExitpas(nom);
                                }
                            }
                        });
                    
                });
        }

                //Traitement pour les modifiaction des Sommme Verser  
                for(var i =0 ;i< linesNumber;i++){
                    var SommeVerser =document.querySelector(".SommeVerser"+i+"");
                    SommeVerser.addEventListener('change',function(){
                        verifDate();
                            var Somme = parseInt(this.value);
                            var nom =this.parentElement.parentElement.children[1].children[0].value;
                            var prise =parseInt(this.parentElement.parentElement.children[2].children[0].value);
                            var SommeAVerse =parseInt(this.parentElement.parentElement.children[3].innerText);
                            var etatSolde =this.parentElement.parentElement.children[5];
                            var montantSolde =this.parentElement.parentElement.children[6];
                            console.log(SommeAVerse);
                            var differance =Somme - SommeAVerse;
                            console.log(prise);
                            var clientExit=false;
                                $.ajax({
                                    type: "Post",
                                    url: 'static/php/livraison.php',
                                    data:{Action:'actualisation',Nom:nom,priseClient:prise,SomAverser:SommeAVerse,Somme:Somme,date:dateDuJour} ,
                                    dataType: "json",
                                    success: function (response) {
                                        if(response.NameExist){
                                            etatSolde.innerText=verifEtatSolde(response.valSolde);
                                            montantSolde.innerText=response.newSolde+" fr";
                                            //si le client est dans la base de bonne 
                                        }
                                        else{
                                            clientExitpas(nom);
                                        }
                                    }
                                });
                            
                        });
                }


    //Ajout d'un utilisateur 
    $('#formAddUser').submit(function(e){
        e.preventDefault();

        var nomClient =$('#NomClient').val();
        var divLoader =document.querySelector("#divLoader");
        var form =document.querySelector("#formAddUser");
        var box_success =document.querySelector("#box-success");
        var box_warning =document.querySelector("#box-warning");
        var box_danger =document.querySelector("#box-danger");
        var Prix =$('#Prix').val();
        var type =$('#Type').val();
        var ErrorInput =false;
        var textError=[];
        if(!box_danger.classList.contains('hideDiv')){
            box_danger.classList.add('hideDiv');
        }
        if(!box_warning.classList.contains('hideDiv')){
            box_warning.classList.add('hideDiv');
        }
        if(!box_success.classList.contains('hideDiv')){
            box_success.classList.add('hideDiv');
        }
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
            if(box_danger.classList.contains('hideDiv')){
                box_danger.classList.remove('hideDiv');
            }
            for(var i =0 ; i<textError.length ;i++){
                box_danger.querySelector('p').innerHTML="<p>"+textError[i]+"</p>" ;
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
                    if(box_warning.classList.contains('hideDiv')){
                        box_warning.classList.remove('hideDiv');
                    }
                    box_warning.querySelector('p').innerHTML= "Désolé il existe dejat client nommé  <strong>"+nomClient+" </strong> dans la liste de vos client " ;
                }
                if(response.InsertionOk){
                    if(box_success.classList.contains('hideDiv')){
                        box_success.classList.remove('hideDiv');
                    }
                    box_success.classList.remove('hideDiv');
                    box_success.querySelector('p').innerHTML= "Felicitation le client <strong>"+nomClient+" </strong> a été ajouté avec succes  " ;
                
                }
            }
         })
        }
        
    })
  	
        
    //CODE JS  POUR AFFICHER OU CACHEZ LES ENTETE 

    var showHideEntete =document.querySelector("#showHideEntete");
    showHideEntete.addEventListener('click',function(){
      var Entete= document.querySelector(".entete");
      Entete.classList.toggle("showHide");
      this.hidden;
    })

// ---------------------------SECTION DES FUNCTIO --------------------------------  //
    function verifDate(){
        if (document.querySelector(".dateDuJour").value ===""){
            alert("Commencez par saisir la date du jour ");
            return 1
        }
        return 0
    }
    //FUNCTION POUR VERIFIER L'ETAT DU SOLDE DE L'UTILISATEUR 
   
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
        return ";-(";
 
    }
    function clientExitpas(nomDuClient){
        var creationCompt=confirm('Desole Ce Client '+nomDuClient+' Existe pas dans la liste des client\nvoulez vous cree un compt pour ce client');
            if(creationCompt)
            {
                $('#creationCompt').click();
            }
    }
    // Data Picker Initialization
    $('.datepicker').pickadate();
    // Extend the default picker options for all instances.
    $.extend($.fn.pickadate.defaults, {
        monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre',
        'Novembre', 'Décembre'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        today: 'aujourd\'hui',
        clear: 'effacer',
        formatSubmit: 'yyyy/mm/dd'
        })
        
        // Or, pass the months and weekdays as an array for each invocation.
        $('.datepicker').pickadate({
        monthsFull: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre',
        'Novembre', 'Décembre'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        today: 'aujourd\'hui',
        clear: 'effacer',
        formatSubmit: 'yyyy/mm/dd'
        })


        //DATA TABLE 
        $(document).ready( function () {
            $('#dtBasicExample').DataTable();
        } );
})