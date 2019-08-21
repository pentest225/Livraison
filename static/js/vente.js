$(document).ready( function () {
        var inputDateVente=document.querySelector(".dateVente");
        var tableBody =document.querySelector("#tableBody");
        var prise=document.querySelector("#prise");
        var retour=document.querySelector("#retour");
        var sommeAVerser=document.querySelector("#sommeAVerser");
        var sommeVerser=document.querySelector("#sommeVerser");
        var manquant=document.querySelector("#manquant");
        // $('#tableauVente').DataTable();

        $('.datepicker').pickadate({
            labelMonthNext: 'Go to the next month',
            labelMonthPrev: 'Go to the previous month',
            labelMonthSelect: 'Pick a month from the dropdown',
            labelYearSelect: 'Pick a year from the dropdown',
            selectMonths: true,
            selectYears: true
            });

           inputDateVente.onchange=function(){
               date=this.value;
               //faire un requete dans la base de donne pour selectinne toute les information 
               $.ajax({
                type:'POST',
                url:'static/php/vente.php',
                data:{Action:'RecupAll',date:date},
                dataType:'JSON',
                success:function(result){
                    if(result.tableVide){
                        alertError('Table vide ',"Desole il n'y a aucun enregistrement correspondant a la date "+date+"")
                    }
                    else{
                        alertSusess(":)")
                        prise.innerHTML="<strong>"+result.AllPrise[0].prise+"</strong>";
                        retour.innerHTML="<strong>"+result.AllPrise[0].retour+"</strong>";
                        sommeAVerser.innerHTML="<strong>"+result.AllPrise[0].somme_a_verser+"</strong>";
                        sommeVerser.innerHTML="<strong>"+result.AllPrise[0].somme_verser+"</strong>";
                        manquant.innerHTML="<strong>"+result.AllPrise[0].total_manquant+"</strong>";
                        for(var i=0;i<result.AllVente.length;i++){
                            tableBody.innerHTML+="<tr><td>"+result.AllVente[i].nom_client+"</td><td>"+result.AllVente[i].prise_client+"</td><td>"+result.AllVente[i].retour_client+"</td><td>"+result.AllVente[i].somme_a_verser+"</td><td>"+result.AllVente[0].somme_verser+"</td><td>Etat Solde </td><td>"+result.AllVente[0].solde_actuel+"</td> <td><ul class='list-unstyled mb-0'><a class='p-2 fa-lg fb-ic' href='client.php?nom="+result.AllVente[i].nom_client+"'><i class='glyphicon glyphicon-eye-open'></i></a></ul></td></tr>"
                            
                                
                                    
                                
                                
                            
                        
                        }
                    }
                    
                }
            })
           };
          
      
           
            function alertSusess(text){
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: text,
                    //showConfirmButton: tre,
                    //timer: 3000
                })
            }

            function alertError(title,text){
                Swal.fire({
                    position:'top',
                    type: 'error',
                    title: title,
                    text: text,
                    footer: '<a href>Why do I have this issue?</a>'
                })
            }
    } );