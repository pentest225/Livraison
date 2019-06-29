$(function()
{
    var ListeClient=0;
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
    var linesNumber = 50;
    var soldeClient=0;
    var retourClient=0;
    var varsementClient=0;
    var SommeAverserClient=0;
    var inputRetourClient="";
    var inputRestPrise=document.querySelector('#restPrise');
    var btnValidBoul=document.querySelector(".valideBoul");
    var restPrise=0;
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
    var dateBoul = document.querySelector(".inputDateBoulangerie").value;
    var dateVente =document.querySelector(".dateVente").value;
    var arrayTableau=document.getElementById('dtBasicExample').rows;
    var nombreLignesTab=arrayTableau.length;
    var totalSommeRecu =0;
    //div pour les alert lor de l'inscription du client 
    if(!box_danger.classList.contains('hideDiv')){
        box_danger.classList.add('hideDiv');
    }
    if(!box_warning.classList.contains('hideDiv')){
        box_warning.classList.add('hideDiv');
    }
    if(!box_success.classList.contains('hideDiv')){
        box_success.classList.add('hideDiv');
    }
    
    //creation des Ligne du tableau 
    for (var i= 0 ;i <linesNumber ;i++){
        arrayTab=document.getElementById('tbody');
            var ligne=arrayTab.insertRow();
            ligne.className="ligne";
            celNom=ligne.insertCell(0);
            celNom.innerHTML+=(i+1);
            celNom=ligne.insertCell(1);
            celNom.innerHTML+="<input type='text' placeholder='' class='tableInput NomClient"+i+"'> ";
            celPrise=ligne.insertCell(2);
            celPrise.innerHTML+="<input type='number' placeholder='' class=' tableInput priseClient"+i+"'> ";
            celPrise=ligne.insertCell(3);
            celPrise.innerHTML+="<input type='number' placeholder='' class=' tableInput retourClient"+i+"' value='0' > ";
            celSommeAVerser=ligne.insertCell(4);
            celSommeAVerser.innerHTML+="<input type='number' readonly class='tableInput SommeAverser"+i+"' value='' >";
            celSommeVerser=ligne.insertCell(5);
            celSommeVerser.innerHTML+="<input type='number' placeholder='' class='tableInput SommeVerser"+i+"'> ";
            celEtatSolde=ligne.insertCell(6);
            celEtatSolde.innerHTML+="<input type='text' readonly class='tableInput  EtatSolde"+i+"'>";
            celSolde=ligne.insertCell(7);
            celSolde.innerHTML+="<input type='number' readonly class='tableInput  valSolde"+i+"'>";
    }
    var allInput =document.querySelectorAll('.tableInput');

//INSERTION DE MISE A JOUR DU FORMULAIRE DES PRISE ET VERSEMENT 
        //desactivation des input par defaut ;
        if(dateBoul=== ""){
            selectBoul.disabled=true;
        };
        inputDateBoul.onchange=function(){
            dateBoul=this.value;
            selectBoul.disabled=false;
        }
       
        if((PrixUnitaireBoul===0) || (idBoulagerie === 0)){
            inputPrise.disabled=true;
            inputRetour.disabled=true;
            inputversement.disabled=true;
        }
        if(dateVente ===""){
            for(var i = 0 ;i<allInput.length;i++){
                allInput[i].disabled=true;
            }
        }
        inputDateVente.onchange=function(){
            dateVente=this.value;
            //On desactive tous les input
            for(var i = 0 ;i<allInput.length;i++){
                allInput[i].disabled=false;
            }
            //On selectionne la prise de cette date 
            $.ajax({
                type:'POST',
                url:'static/php/livraison.php',
                data:{Action:'selectPrise',date:dateVente},
                dataType:'JSON',
                success:function(result){
                    if(result.dateOk){
                        restPrise=parseInt(result.Prise);
                        inputRestPrise.innerHTML=restPrise;
                    }
                    else{
                        alert('veillez selectionne une date valide ');
                        inputDateVente.click();
                    }
                }
            })
        }
        
selectBoul.addEventListener("change",function(){
    //si il chage de boulangerie on efface toute les donne qui a precedenment saisie 
    PrixUnitaireBoul=0;
    inputPrise.value=0;
    inputRetour.value=0;
    inputversement.value=0;
    inputMaquantDuJour.innerHTML=0;
    inputSommeAVerser.innerHTML=0;
    idBoulagerie=this.value;
    if(idBoulagerie==''){
        alert('Veillez celectionne la boulagerie');
        inputPrise.disabled=true;
        inputRetour.disabled=true;
        inputversement.disabled=true;
    }
    else{
         //FAIRE UNE REQUETE POUR LA RECUPERATION DE TOUTE LES INFORMATION PAR RAPPORT AU SOLDE 
        $.ajax({
            type:'POST',
            url:'static/php/livraison.php',
            data:{Action:'recupInfoBoul',idBoul:idBoulagerie},
            dataType:'JSON',
            success:function(result){
                //une fois les informations recupere on les affiche a la vue 
                    //1=>on actualise le prix unitaire 

                    PrixUnitaireBoul=result.prixUniBoul;
                    inputPrise.disabled=false;
                    inputRetour.disabled=false;
                    inputversement.disabled=false;
                    totalManquant=parseInt(result.totalManquant);
                    inputTotalManquant.innerHTML="<strong>"+totalManquant+"</strong>"
            }
        })
    }
   
   
})
//L'EVENEMENT DECLANCHREUR C'EST DANS CE EVENEMENT QU'EST DEFFINI LA PORTER DE TOUTE LE VARAIBLE 
    //TETEMENT LORS DU CHANGEMENT DE LA PRISE 
    inputPrise.addEventListener("keyup",function(){
        /*verifDate();
        Retour=parseInt(Retour);
        console.log(Retour);
        this.value==''? Prise=0:Prise=parseInt(this.value);
        SommeAVerse=(Prise - Retour )*parseInt(PrixUnitaireBoul);
        Manquant=parseInt(SommeAVerse-Versement);
        inputSommeAVerser.innerHTML="<strong>"+SommeAVerse+"</strong>";
        inputMaquantDuJour.innerHTML="<strong>"+Manquant+"</strong>";
        totalManquant+=Manquant;
         
         $.ajax({
            type:'POST',
            url:'static/php/livraison.php',
            data:{Action:'enregistrementBoulangerie',idBoul:idBoulagerie,date:dateDuJour, prise:Prise,sommeDu:SommeAVerse,rest:Manquant},
            dataType:'JSON',
            success:function(result){
                //une fois les informations recupere on les affiche a la vue 
                    //1=>on actualise le prix unitaire 
                    totalManquant=parseInt(result.totalManquant);
                    inputTotalManquant.innerHTML="<strong>"+totalManquant+"</strong>"
            }*/
            Retour=parseInt(Retour);
            this.value==''? Prise=0:Prise=parseInt(this.value);
            if(Prise < Retour){
                alert("La valleur du retour est trop grande");
                Retour=0;
            }
            else
            {
                
                SommeAVerse=(Prise - Retour )*parseInt(PrixUnitaireBoul);
                Manquant=parseInt(SommeAVerse-Versement);
                inputSommeAVerser.innerHTML="<strong>"+SommeAVerse+"</strong>";
                inputMaquantDuJour.innerHTML="<strong>"+Manquant+"</strong>";
                newTotal=totalManquant+ Manquant;
                inputTotalManquant.innerHTML="<strong>"+newTotal+"</strong>";
                restPrise-=Prise;
                inputRestPrise.innerHTML=restPrise;
            }
            

            /*$.ajax({
                type:'POST',
                url:'static/php/livraison.php',
                data:{Action:'enregistrementBoulangerie',idBoul:idBoulagerie,date:dateBoul, prise:Prise,sommeDu:SommeAVerse,rest:Manquant},
                dataType:'JSON',
                success:function(result){
                    //une fois les informations recupere on les affiche a la vue 
                        //1=>on actualise le prix unitaire 
                        totalManquant=parseInt(result.totalManquant);
                        
                }
            })*/
    })
    //TRAITEMENT AU CHAGEMENT DU RETOUR 
    inputRetour.addEventListener('keyup',function(){
        
        this.value==''? Retour=0:Retour=parseInt(this.value);
        if(Retour > Prise){
            alert("Retour trop grand");
            this.value=0;
            this.onfocus=true;
            
        }else{
            SommeAVerse=(Prise - Retour )*PrixUnitaireBoul;
            Manquant=parseInt(SommeAVerse-Versement);
            inputSommeAVerser.innerHTML="<strong>"+SommeAVerse+"</strong>";
            inputMaquantDuJour.innerHTML="<strong>"+Manquant+"</strong>";
            newTotal =totalManquant + Manquant;
            inputTotalManquant.innerHTML="<strong>"+(newTotal)+"</strong>";
            /*$.ajax({
                type:"POST",
                url:'static/php/livraison.php',
                data:{Action:'MiseAjourRetour',idBoul:idBoulagerie,date:dateBoul, prise:Prise,retour:Retour,sommeDu:SommeAVerse,rest:Manquant},
                dataType:'JSON',
                success:function(result){
                    if(result.error){
                        alert(result.Message);
                    }
                    else{
                        
                    }
 
            }
        })*/
        }
    })
    //TRAITEMENT DU VERSEMENT 
    inputversement.addEventListener('keyup',function(){
        this.value==''? Versement=0:Versement=parseInt(this.value);
        if(Versement < 0){
            alert("valleur du versement est negative !");
            this.value=0;
        }
        else{
            SommeAVerse=(Prise - Retour )*PrixUnitaireBoul;
            Manquant=parseInt(SommeAVerse-Versement);
            newTotal =totalManquant + Manquant;
            inputTotalManquant.innerHTML="<strong>"+( newTotal )+"</strong>";
           /* $.ajax({
                type:"POST",
                url:'static/php/livraison.php',
                data:{Action:'MiseAjourVersement',idBoul:idBoulagerie,date:dateBoul, prise:Prise,retour:Retour,sommeDu:SommeAVerse,versement:Versement,rest:Manquant},
                dataType:'JSON',
                success:function(result){
                    if(result.error){
                        alert(result.Message);
                    }else{
                        
                    }
                }
            })*/
        }
    })

    btnValidBoul.addEventListener("click",function(){
        console.log("DATE ="+dateBoul+"PRISE = "+Prise+" RETOUR ="+Retour+" SOMME A VERSER ="+SommeAVerse+"  VERESEMENT ="+Versement+"TOTAL MANQUANT = "+newTotal);
         $.ajax({
                type:"POST",
                url:'static/php/livraison.php',
                data:{Action:'InsertionBoulagerie',idBoul:idBoulagerie,date:dateBoul, prise:Prise,retour:Retour,sommeDu:SommeAVerse,versement:Versement,rest:Manquant,totalSolde:newTotal},
                dataType:'JSON',
                success:function(result){
                    if(result.insertionOk){
                        alert("INSERTION OK ");
                    }
                }
            })

    })
 
    //Verification du client dans la base de donnee 
    for(var i =0 ;i< linesNumber;i++){
        var NomClient =document.querySelector(".NomClient"+i+"");
            NomClient.addEventListener('change',function(){
                var nom = this.value.toLowerCase();
                var inputRetourClient=this.parentElement.parentElement.children[3].children[0];
                var etatSolde =this.parentElement.parentElement.children[6];
                var montantSolde =this.parentElement.parentElement.children[7];
                var clientExit=false;
                    $.ajax({
                        type: "Post",
                        url: 'static/php/livraison.php',
                        data:{Action:'VerifClient',Nom:nom} ,
                        dataType: "json",
                        success: function (response) {
                            if(response.NameExist){
                                etatSolde.innerText=verifEtatSolde(response.newSolde);
                                soldeClient=response.newSolde;
                                prixUnitaireClient=response.prixUnitaireClient;
                                montantSolde.innerText=response.newSolde;
                                console.log("ok mane exist");
                                    //si le client est dans la base de bonne 
                                    if(response.typeClient == "d"){
                                        inputRetourClient.value=00;
                                        inputRetourClient.disabled=true;
                                    }
                            }
                            else{

                                clientExitpas(nom);
                                NomClient.value="";
                                
                            }
                        }
                    });
                
            });
    }
        //Traitement pour les modifiaction des prise 
        for(var i =0 ;i< linesNumber;i++){
                    var priseClient =document.querySelector(".priseClient"+i+"");
                    priseClient.onkeyup=function(){
                    var prise = this.value;
                    var retourClient =this.parentElement.parentElement.children[3].children[0].value;
                    var SommeAVerse =this.parentElement.parentElement.children[4];
                    var etatSolde =this.parentElement.parentElement.children[6];
                    var montantSolde =this.parentElement.parentElement.children[7];
                    
                    SommeAverserClient=(parseInt(prise)-parseInt(retourClient)) * parseInt(prixUnitaireClient); 
                    SommeAVerse.value=SommeAverserClient;
                    SommeAVerse.innerHTML="<input type='number' readonly class='tableInput SommeAverser"+i+"' value='"+SommeAverserClient+"' >";
                    console.log(SommeAVerse.value);
                    inputRestPrise.value=restPrise - prise;
                    inputRestPrise.innerHTML=restPrise - prise;
                    newSoldeClient =soldeClient+SommeAverserClient;

                    console.log(newSoldeClient);
                    etatSolde.value=verifEtatSolde(newSoldeClient);
                    etatSolde.innerText=verifEtatSolde(newSoldeClient);
                    montantSolde.value=newSoldeClient;
                    montantSolde.innerHTML="<input type='text' readonly class='tableInput  EtatSolde"+i+"' value='"+newSoldeClient+"'>";
                      
                    
                };
            }
            //Traitement pour les modifiaction des Retour 
            for(var i =0 ;i< linesNumber;i++){
                var inputRetourClient =document.querySelector(".retourClient"+i+"");
                inputRetourClient.onkeyup=function(){
                var retourClient = this.value;
                var prise =this.parentElement.parentElement.children[2].children[0].value;
                var SommeAVerse =this.parentElement.parentElement.children[4];
                var etatSolde =this.parentElement.parentElement.children[6];
                var montantSolde =this.parentElement.parentElement.children[7];
                if(retourClient > prise){
                    alert("Valleur Retour Incorect !!");
                    retourClient=0;
                    inputRetourClient.value=0;
                }
                SommeAverserClient=(parseInt(prise)-parseInt(retourClient)) * parseInt(prixUnitaireClient); 
                SommeAVerse.innerHTML="<input type='number' readonly class='tableInput SommeAverser"+i+"' value='"+SommeAverserClient+"' >";
                inputRestPrise.innerText=restPrise - prise;

                newSoldeClient=soldeClient+SommeAverserClient;

                etatSolde.innerText=verifEtatSolde(newSoldeClient);

                montantSolde.innerHTML="<input type='text' readonly class='tableInput  EtatSolde"+i+"' value='"+newSoldeClient+"'>";
                
            };
        }
                //Traitement pour les modifiaction des Sommme Verser  
                for(var i =0 ;i< linesNumber;i++){
                    var SommeVerser =document.querySelector(".SommeVerser"+i+"");
                            SommeVerser.addEventListener('keyup',function(){
                            var Somme = parseInt(this.value);
                            console.log(this.className);    
                            var prise =parseInt(this.parentElement.parentElement.children[2].children[0].value);
                            var SommeAVerse =parseInt(this.parentElement.parentElement.children[4].innerText);
                            var etatSolde =this.parentElement.parentElement.children[6];
                            
                            var montantSolde =this.parentElement.parentElement.children[7];
                            var differance =SommeAVerse - Somme ;
                            etatSolde.innerText=verifEtatSolde(soldeClient - differance);
                            montantSolde.innerHTML="<input type='text' readonly class='tableInput  EtatSolde"+i+"' value='"+(soldeClient - differance)+"'>";


                            
                        });
                }
                btnSaveVente.addEventListener("click",function(){
                    for(var i = 0; i <linesNumber ;i++){
                        var tabNomClient=document.querySelector(".NomClient"+i+"").value;
                        var tabPriseClient =document.querySelector(".priseClient"+i+"").value;
                        var tabRetourClient =document.querySelector(".retourClient"+i+"").value;
                        var tabSommeAverserClient =document.querySelector(".SommeAverser"+i+"").value;
                        var tabSommeVerser =document.querySelector(".SommeVerser"+i+"").value;
                        var tabTotalSoldeClient=document.querySelector(".valSolde"+i+"").value;
                        if(tabNomClient ===""){
                            console.log("Nom client "+i+"vide");
    
                        }
                        else{
                            console.log(tabNomClient ,tabPriseClient ,tabRetourClient ,tabSommeAverserClient ,tabSommeVerser ,tabTotalSoldeClient);
                        }
                    }
                })
                
    //Ajouter une boullangerie
    //Ajout d'un utilisateur 
    $('#formAddBoullangerie').submit(function(e){
        e.preventDefault();
        var nomBoul =document.querySelector('#nomBoul').value;
        var Prix =document.querySelector('#prixBoul').value;
        nomBoul.toLowerCase();

            $.ajax({
            type:'Post',
            url:'static/php/livraison.php',
            data:{Action:'CreationCompteBoul',Nom:nomBoul,PrixAchat:Prix},
            dataType:'json',
            success:function (response){
                if(response.NameExist){
                    box_info.querySelector('h4').innerHTML="<strong>Erreur Boublon </strong>";
                    box_info.querySelector('p').innerHTML= "Désolé il existe dejat client nommé  <strong>"+nomBoul+" </strong> dans la liste de vos client " ;
                }
                if(response.InsertionOk){
                    box_info.querySelector('h4').innerHTML="<strong>COMPTE CREE </strong>";
                    box_info.querySelector('p').innerHTML= "Felicitation le client <strong>"+nomBoul+" </strong> a été ajouté avec succes  " ;
                }
            }
         })
    })
  	
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
            if(box_danger.classList.contains('hideDiv')){
                box_danger.classList.remove('hideDiv');
            }
            else{
            box_danger.style.display="block";
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
                    else{
                        box_warning.style.display="block";
                        }
                    box_warning.querySelector('p').innerHTML= "Désolé il existe dejat client nommé  <strong>"+nomClient+" </strong> dans la liste de vos client " ;
                }
                if(response.InsertionOk){
                    if(box_success.classList.contains('hideDiv')){
                        box_success.classList.remove('hideDiv');
                    }
                    else{
                        box_success.style.display="block";
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

// ---------------------------SECTION DES FUNCTION --------------------------------  //
    function activeSelectBoul(){
        console.log("Activation du select ");
        dateBoul=inputDateBoul.value;
        selectBoul.disabled=false;
    }
 
    function verifPrixUnitaire(valleur){
        if ( valleur===0){
            alert("Veillez selectionne la boulangerie");
            return 0
        }
        return 1
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
    function parcourPrise(){
        for(var i =0;i < linesNumber;i++){
            var inputprise=document.querySelector(".priseClient"+i+"");
            var inputRestPrise=document.querySelector("#restPrise");
            var priseVal=0;
            console.log('prise avent modif'+priseVal+'');
            inputprise.addEventListener('change',function(){
                priseVal =parseInt(this.value);
                var priseLocal=0;
                console.log('prise apres modif '+priseVal);
                priseLocal +=priseVal;
                return priseLocal;
            })
            return 0;
        }
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


        /*DATA TABLE 
        $(document).ready( function () {
            $('#dtBasicExample').DataTable();
        } );*/ 
})