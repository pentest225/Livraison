$(function()
{
    /*
    //DECLARATION DE NOS VARIABLES 
    //    
    //
    */
    var ListeClient=0;
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
    var linesNumber = 50;
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
    var dateBoul = document.querySelector(".inputDateBoulangerie").value;
    var dateVente =document.querySelector(".dateVente").value;
    var arrayTableau=document.getElementById('dtBasicExample').rows;
    var sommeLivreur=0;
    var mqt
    var total=0;

    var nombreLignesTab=arrayTableau.length;
    var totalSommeRecu =0;
    //creation des Ligne du tableau 
    for (var i= 0 ;i <linesNumber ;i++){
        arrayTab=document.getElementById('tbody');
            var ligne=arrayTab.insertRow();
            ligne.className="ligne";
            celNom=ligne.insertCell(0);
            celNom.innerHTML+=(i+1);
            celNom=ligne.insertCell(1);
            celNom.innerHTML+="<input type='text' placeholder=''  class='tableInput NomClient"+i+"' id='NomClient"+i+"' name='NomClient"+i+"' autocomplete='off' data-provide='typeahead'><div class='sugestion"+i+" liste '></div>";
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
            console.log(inputDateBoul);
            console.log(dateBoul);
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
            //On selectionne la prise de cette date 
            $.ajax({
                type:'POST',
                url:'static/php/livraison.php',
                data:{Action:'selectPrise',date:dateVente},
                dataType:'JSON',
                success:function(result){
                    if(result.dateOk){
                        restPriseVente=parseInt(result.Prise);
                        inputRestPrise.innerHTML=restPriseVente;
                        //on stocke la liste de tous les client dans un tableau 
                        for(var i=0 ;i <result.listeClient.length;i++){
                            AllClient.push(result.listeClient[i].name)
                        }
                        //
                        // console.log(result.listeClient[0].name);
                        //On desactive tous les input
                        for(var i = 0 ;i<allInput.length;i++){
                            allInput[i].disabled=false;
                        }
                    }
                    else{
                        alert('Erreur ,cette date ne correspond a aucune prise ');
                        for(var i = 0 ;i<allInput.length;i++){
                            allInput[i].disabled=true;
                        }
                        
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
        alertError('Villez selectionne une boullangerie...');
        inputPrise.disabled=true;
        inputRetour.disabled=true;
        inputversement.disabled=true;
    }
    else{
         //FAIRE UNE REQUETE POUR LA RECUPERATION DE TOUTE LES INFORMATION PAR RAPPORT AU SOLDE 
        $.ajax({
            type:'POST',
            url:'static/php/livraison.php',
            data:{Action:'recupInfoBoul',idBoul:idBoulagerie,date:dateBoul},
            dataType:'JSON',
            success:function(result){
                //une fois les informations recupere on les affiche a la vue 
                    //1=>on actualise le prix unitaire 
                    if(result.ErrorVersementExiste){
                        let textError ="Desole un versement a deja ete effectue le "+dateBoul+" ";
                        alertError('Erreur',textError);
                    }
                    else if(result.dateExiste){
                        inputPrise.disabled=false;
                        inputRetour.disabled=false;
                        inputversement.disabled=false;
                        totalManquant=parseInt(result.totalManquant);
                        inputTotalManquant.innerHTML="<strong>"+totalManquant+"</strong>"

                        inputPrise.value=result.prise;
                        inputRetour.value=result.retour;
                        inputSommeAVerser.value=result.sommeAVerse;

                    }
                    else{
                    PrixUnitaireBoul=result.prixUniBoul;
                    inputPrise.disabled=false;
                    inputRetour.disabled=false;
                    inputversement.disabled=false;
                    totalManquant=parseInt(result.totalManquant);
                    inputTotalManquant.innerHTML="<strong>"+totalManquant+"</strong>"
            }
                    
            }
        })
    }
   
   
})
//L'EVENEMENT DECLANCHREUR C'EST DANS CE EVENEMENT QU'EST DEFFINI LA PORTER DE TOUTE LE VARAIBLE 
    //TETEMENT LORS DU CHANGEMENT DE LA PRISE 
    inputPrise.addEventListener("input",function(){
        
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
        
    })
    //TRAITEMENT AU CHAGEMENT DU RETOUR 
    inputRetour.addEventListener('input',function(){
        
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
    inputversement.addEventListener('input',function(){
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
                        
        }
    })
    //ENREGITREMENT DES INFO BOULAGERIE 
    btnValidBoul.addEventListener("click",function(){
        console.log("DATE ="+dateBoul+"PRISE = "+Prise+" RETOUR ="+Retour+" SOMME A VERSER ="+SommeAVerse+"  VERESEMENT ="+Versement+"TOTAL MANQUANT = "+newTotal);
         $.ajax({
                type:"POST",
                url:'static/php/livraison.php',
                data:{Action:'InsertionBoulagerie',idBoul:idBoulagerie,date:dateBoul, prise:Prise,retour:Retour,sommeDu:SommeAVerse,versement:Versement,rest:Manquant,totalSolde:newTotal},
                dataType:'JSON',
                success:function(result){
                    if(result.insertionOk){
                        btnCloseBoule.click();
                        alertSusess('Enregistrement effectif ; )');

                    }
                    if(result.insertoExiste){
                        alertError('Enregistrement ','Desole un enregistrement')
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
                var etatSolde =this.parentElement.parentElement.children[6].children[0];
                var montantSolde =this.parentElement.parentElement.children[7].children[0];
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
                                    //si le client est dans la base de bonne 
                                    if(response.typeClient == "d"){
                                        inputRetourClient.value=00;
                                        inputRetourClient.disabled=true;
                                    }
                            }
                            else{

                                clientExitpas(nom);
                                NomClient.value=''
                                
                            }
                        }
                    });
            });
    }

    //Traitement pour les modifiaction des prise 
    for(var i =0 ;i< linesNumber;i++){
                var priseClient =document.querySelector(".priseClient"+i+"");
                priseClient.onkeyup=function(){
                var prise =0;                   
                this.value==''?prise=0:prise=prise=parseInt(this.value);
                var nom=this.parentElement.parentElement.children[1].children[0].value;
                var retourClient =this.parentElement.parentElement.children[3].children[0].value;
                var SommeAVerse =this.parentElement.parentElement.children[4].children[0];
                var SommeRandu =this.parentElement.parentElement.children[5].children[0].value;
                var etatSolde =this.parentElement.parentElement.children[6].children[0];
                var montantSolde =this.parentElement.parentElement.children[7].children[0];
                $.ajax({
                    type: "Post",
                    url: 'static/php/livraison.php',
                    data:{Action:'VerifClient',Nom:nom} ,
                    dataType: "json",
                    success: function (response) {
                        if(response.NameExist){
                            SommeAverserClient=(parseInt(prise)-parseInt(retourClient)) * parseInt(response.prixUnitaireClient); 
                            SommeAVerse.value=SommeAverserClient;
                            parcourPrise(restPriseVente);
                            newSoldeClient =(parseInt(response.newSolde)+SommeAverserClient) - SommeRandu;
                            montantSolde.value=parseInt(newSoldeClient  );
                            montantSolde.disabled=true;
                            etatSolde.value=verifEtatSolde(parseInt(newSoldeClient));
                            etatSolde.disabled=true;

                        }else{
                            clientExitpas(nom);
                        }
                        
                    }
                });
                
                    
                
            };
        }
    //Traitement pour les modifiaction des Retour 
    for(var i =0 ;i< linesNumber;i++){
        var inputRetourClient =document.querySelector(".retourClient"+i+"");
        inputRetourClient.addEventListener('keyup',function(){
        var retourClient =0;
        this.value==''?retourClient=0:retourClient=parseInt(this.value);
        var nom=this.parentElement.parentElement.children[1].children[0].value;
        var prise =this.parentElement.parentElement.children[2].children[0].value;
        var SommeRandu =this.parentElement.parentElement.children[5].children[0].value;
        var SommeAVerse =this.parentElement.parentElement.children[4].children[0];
        var etatSolde =this.parentElement.parentElement.children[6].children[0];
        var montantSolde =this.parentElement.parentElement.children[7].children[0];
        if(retourClient > prise){
            alert("Valleur Retour Incorect !!");
            retourClient=0;
            inputRetourClient.value=0;
        }
        $.ajax({
            type: "Post",
            url: 'static/php/livraison.php',
            data:{Action:'VerifClient',Nom:nom} ,
            dataType: "json",
            success: function (response) {
                if(response.NameExist){
                    SommeAverserClient=(parseInt(prise)-parseInt(retourClient)) * parseInt(response.prixUnitaireClient); 
                    SommeAVerse.value=SommeAverserClient;
                    newSoldeClient =(parseInt(response.newSolde)+SommeAverserClient) - SommeRandu;
                    montantSolde.value=parseInt(newSoldeClient);
                    montantSolde.disabled=true;
                    etatSolde.value=verifEtatSolde(parseInt(newSoldeClient));
                    etatSolde.disabled=true;

                }else{
                    clientExitpas(nom);
                }
                
            }
        });
        
    })
    }
    //Traitement pour les modifiaction des Sommme Verser  
    for(var i =0 ;i< linesNumber;i++){
        var SommeVerser =document.querySelector(".SommeVerser"+i+"");
                SommeVerser.addEventListener('input',function(){
                var Somme = 0;
                this.value ==''?Somme=0:Somme=parseInt(this.value);
                parcourSommeRecu();
                var nom=this.parentElement.parentElement.children[1].children[0].value;
                var prise =parseInt(this.parentElement.parentElement.children[2].children[0].value);
                var retourClient =this.parentElement.parentElement.children[3].children[0].value;
                var SommeAVerse =parseInt(this.parentElement.parentElement.children[4].value);
                var etatSolde =this.parentElement.parentElement.children[6];
                var montantSolde =this.parentElement.parentElement.children[7].children[0];

                $.ajax({
                    type: "Post",
                    url: 'static/php/livraison.php',
                    data:{Action:'VerifClient',Nom:nom} ,
                    dataType: "json",
                    success: function (response) {
                        if(response.NameExist){
                            SommeAverserClient=(parseInt(prise)-parseInt(retourClient)) * parseInt(response.prixUnitaireClient);
                            newSoldeClient =(parseInt(response.newSolde)+SommeAverserClient) - Somme;
                            montantSolde.value=parseInt(newSoldeClient);
                            montantSolde.disabled=true;
                            etatSolde.value=verifEtatSolde(parseInt(newSoldeClient));
                            etatSolde.disabled=true;

                        }else{
                            clientExitpas(nom);
                        }
                        
                    }
                });
                
                
                // etatSolde.value=verifEtatSolde(parseInt(newSoldeClient) - Somme);
                // montantSolde.value=(parseInt(newSoldeClient) - Somme);
            });
    }
    //TAITEMENT LORS DE LA SAISIE DE LA SOMME RECU DU LIVREUR 
    inputSommeRecuLivreur.addEventListener('input',function(){
        this.value==''?sommeLivreur=0:sommeLivreur=parseInt(this.value);
        mqt=parseInt(inputTotalSommeRecue.value) - sommeLivreur;
        inputManquantLivreur.value=mqt;

    })
    //ENREGISTREMENT DE LA VENTE DU JOURS 
    btnSaveVente.addEventListener("click",function(){
        var tableauVente=[];
        for(var i = 0; i <linesNumber ;i++){
            var tabNomClient=document.querySelector(".NomClient"+i+"").value;
            var tabPriseClient =document.querySelector(".priseClient"+i+"").value;
            var tabRetourClient =document.querySelector(".retourClient"+i+"").value;
            var tabSommeAverserClient =document.querySelector(".SommeAverser"+i+"").value;
            var tabSommeVerser =document.querySelector(".SommeVerser"+i+"").value;
            var tabTotalSoldeClient=document.querySelector(".valSolde"+i+"").value;
            if(tabNomClient ===""){
                break;
            }
            else{
                var objClient ={
                    nom:tabNomClient,
                    prise:parseInt(tabPriseClient),
                    retour:parseInt(tabRetourClient),
                    sommeAVerse:parseInt(tabSommeAverserClient),
                    sommeVerser:parseInt(tabSommeVerser),
                    solde:parseInt(tabTotalSoldeClient)
                }
            }
            tableauVente.push(objClient);
        }
        $.ajax({
            type: "Post",
            url: 'static/php/livraison.php',
            data:{Action:'InsertionVente',date:dateVente,tab:tableauVente,restVente:restPrise,sommeRecuVente:total,SommeVerseLivreur:sommeLivreur,manquantLivreur:mqt} ,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if(response.InsertionOk){
                    var text ='Enregistrement effectuer ';
                    console.log("Enregistrement effectue ");
                    alertSusess(text); 
                }
                if(response.dateExiste){
                    alertError('Erreur date','Desole une insertion a dejat ete faite a cette date ');
            }
            }
        });
    })
                
    //Ajouter une boullangerie
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
                    var textError= "Désolé il existe dejat une boulagerie nommée  "+nomBoul+"  dans la liste de vos client " ;
                    alertError('Erreur Boublon',textError);
                }
                if(response.InsertionOk){
                    var textMessage= "Felicitation une compte "+nomBoul+"  a vien d'ere ajouter   " ;
                    selectBoul.innerHTML+="<option value="+parseInt(response.idBoul)+">"+nomBoul+"</option> ";
                    alertSusess(textMessage);
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
        return "VALLEUR NON NUMERIQUE";
 
    }
    //FONTION POUR LE CALCULE DE RESTE DES PRISE 
    function parcourPrise(priseTotal){
        var inputRestPrise=document.querySelector("#restPrise");
        var restPrise=0;
        for(var i =0;i < linesNumber;i++){
            var inputPrise=document.querySelector(".priseClient"+i+"").value;
            inputPrise ==''?inputPrise=0:inputPrise=inputPrise;
            restPrise +=parseInt(inputPrise);
           
        }
        inputRestPrise.innerHTML=(priseTotal -restPrise);
    }
    //FONCTION POUR LA SOMME RECU TOTAL 
    function parcourSommeRecu(){
        total=0;
        for(var i =0;i < linesNumber;i++){
            var valeurRecue=document.querySelector(".SommeVerser"+i+"").value;
            valeurRecue ==''?valeurRecue=0:valeurRecue=valeurRecue;
            total +=parseInt(valeurRecue);
        }
        inputTotalSommeRecue.value=(total);
        inputTotalSommeRecue.innerHTML="<strong>"+total+"</strong>"
    }
    //FONTION POUR SIGNALE SI LE CLIENT EXISTE PAS EN BD
    function clientExitpas(nomDuClient){
        var creationCompt=confirm('Desole Ce Client '+nomDuClient+' Existe pas dans la liste des client\nvoulez vous cree un compt pour ce client');
            if(creationCompt)
            {
                $('#creationCompt').click();
            }
            return creationCompt;
    }

    //FUNCTION POUR LES ALERTS 
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

    //FONCTION POUR LA RECUPERATION DU PRIX UNITAIRE ET DU SOLDE DU CLENT EN BD
    function recupPrixUnitaireAndSolde(nom){
        $.ajax({
            type: "Post",
            url: 'static/php/livraison.php',
            data:{Action:'VerifClient',Nom:nom} ,
            dataType: "json",
            success: function (response) {
                return response.InsertionOk;
            }
        });
        
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
        
        /*DATA TABLE 
        $(document).ready( function () {
            $('#dtBasicExample').DataTable();
        } );*/ 
})