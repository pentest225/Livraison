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
    var dateDuJour =document.querySelector("#dateDuJour").value;
    var arrayTableau=document.getElementById('Tableau').rows;
    var nombreLignesTab=arrayTableau.length;
    console.log(dateDuJour);
    //creation des Ligne du tableau 
    for (var i= 0 ;i <linesNumber ;i++){
        arrayTab=document.getElementById('Tableau');
            var ligne=arrayTab.insertRow();
            ligne.className="ligne";
            celNom=ligne.insertCell(0);
            celNom.innerHTML+=(i+1);
            celNom=ligne.insertCell(1);
            celNom.innerHTML+="<input type='text' placeholder='Non client' class='NomClient"+i+"'> ";
            celPrise=ligne.insertCell(2);
            celPrise.innerHTML+="<input type='number' placeholder='prise' class='priseClient"+i+"'> ";
            celSommeAVerser=ligne.insertCell(3);
            celSommeAVerser.innerHTML+="<p class='SommeAverser"+i+"'>SommeAVerse <i> fr</i></p> ";
            celSommeVerser=ligne.insertCell(4);
            celSommeVerser.innerHTML+="<input type='number' placeholder='Somme Verse ' class='SommeVerser"+i+"'> ";
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
    $('#dateDuJour').on('change',function () { 
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
                        url: "Livraison.php",
                        data:{Action:'VerifClient',Nom:nom} ,
                        dataType: "json",
                        success: function (response) {
                            if(response.NameExist){
                                if(parseInt(parseInt(response.valSolde)) > 0){
                                    etatSolde.innerText="cediteur";
                                }
                                else{
                                    etatSolde.innerText="debiteur";
                                }
                                if(parseInt(parseInt(response.valSolde)) == 0){
                                    etatSolde.innerText="null";
                                }
                                
                                montantSolde.innerText=parseInt(parseInt(response.valSolde))+" fr";
                                //si le client est dans la base de bonne 
                                if(response.typeClient =="r"){
                                    //Afficher la cellule des retoure 
                                }
                               
                            }
                            else{
                                var creationCompt=confirm('Desole Ce Client '+nom+' Existe pas dans la liste des client\nvoulez vous cree un compt pour ce client');
                                if(creationCompt)
                                {
                                    $('#creationCompt').click();
                                }
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
                            url: "Livraison.php",
                            data:{Action:'VerifClient',Nom:nom} ,
                            dataType: "json",
                            success: function (response) {
                                if(response.NameExist){
                                    SommeAVerse.innerText=parseInt(prise) * parseInt(response.prixUnitaire) ;
                                    etatSolde.innerText=response.etatSolde;
                                    montantSolde.innerText=response.valSolde;
                                    //si le client est dans la base de bonne 
                                   
                                }
                                else{
                                    var creationCompt=confirm('Desole Ce Client '+nom+' Existe pas dans la liste des client\nvoulez vous cree un compt pour ce client');
                                    if(creationCompt)
                                    {
                                        $('#creationCompt').click();
                                    }
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
                                    url: "Livraison.php",
                                    data:{Action:'actualisation',Nom:nom,priseClient:prise,SomAverser:SommeAVerse,Somme:Somme,date:dateDuJour} ,
                                    dataType: "json",
                                    success: function (response) {
                                        if(response.NameExist){
                                            etatSolde.innerText=response.etatSolde;
                                            montantSolde.innerText=response.valSolde+" fr";
                                            //si le client est dans la base de bonne 
                                            if(response.typeClient =="r"){
                                                //Afficher la cellule des retoure 
                                            }
                                           
                                        }
                                        else{
                                            var creationCompt=confirm('Desole Ce Client '+nom+' Existe pas dans la liste des client\nvoulez vous cree un compt pour ce client');
                                            if(creationCompt)
                                            {
                                                $('#creationCompt').click();
                                            }
                                        }
                                    }
                                });
                            
                        });
                }

        
   
    //Actualisation du compte de l'utilisateur 
    for(var i =0 ;i <linesNumber;i++)
    {
        $('#priseClient'+(i+1)+'').on('change',function(){
            console.log('ok prise');
           //SI L'UTILISATEUR SAISI LA PRISE DU CLIENT 
           //ON FAIT UNE ACTUALISATION DE SON COMPTE
           var nameClient =$('#client'+(i+1)+'').val();
           priseClient=$(this).val();
           $.ajax({
            type:'POST' ,
            url:'Livraison.php',
            data:{Action:"actualisation",name:nameClient,prise:priseClient},
            typedata:'json',
            success:function(result){

            }         
           })
        })
       
    }
    //Ajout d'un utilisateur 
    $('#formAddUser').submit(function(e){
        e.preventDefault();
        var nomClient =$('#NomClient').val();
        var Prix =$('#Prix').val();
        var type =$('#Type').val();
        nomClient=nomClient.toLowerCase();
        if(nomClient==undefined || nomClient=="")
        {
            alert('Veillez saisir le nom du client')
        }
        else if((Prix < 100)||(Prix >150))
        {
            alert('Le prix unitire dois etre compris entre 100 et 150')
        }
        else if(type =="")
        {
            alert('Veillez selectionne le type de client ')
        }
        else
        {
            $.ajax({
            type:'Post',
            url:'Livraison.php',
            data:{Action:'CreationCompte',Nom:nomClient,PrixAchat:Prix,typeClient:type},
            typedata:'json',
            success:function(response){
                if(response.NameExist===true)
                {
                   alert('Desole le client'+nomClient+'est deja enregistre');
                }
                if(response.InsertionOk===true)
                {
                    alert('client'+nomClient+'enregistre avec succes ;)')
                }
            }
         })
        }
        
    })
  	
        
    //CODE JS  POUR AFFICHER OU CHACHEZ LES ENTETE 

    var showHideEntete =document.querySelector("#showHideEntete");
    showHideEntete.addEventListener('click',function(){
      var Entete= document.querySelector(".entete");
      Entete.classList.toggle("showHide");
      this.hidden;
    })


    function verifDate(){
        if (dateDuJour ===""){
            alert("Commencez par saisir la date du jour ");
            return 1
        }
        return 0
    }
})