$(document).ready( function () {
    $('#myTable').DataTable();
    var formModifUser=document.querySelector('#modifUser');
    var saveModif=document.querySelector('#btnModifUser');
    var btnClose=document.querySelector('#btnClose');
    var btnModif=document.querySelector("#btnModif");
    var btnAdmin=document.querySelector("#btnAdmin");
    var closeModif=document.querySelector('#modifClose');
    btnAdmin.addEventListener('click',(e)=>{
        valPass=document.querySelector("#passAdmin").value;
        nameAdmin=document.querySelector("#nameAdmin").value;
        $.ajax({
            type:'post',
            url:'static/php/traitementClient.php',
            data:{Action:'verifAdmin',login:nameAdmin,pass:valPass},
            dataType:"json",
            success:function(response){
                if(response.okAdmin){
                    btnClose.click();
                    btnModif.click();
                }
                else{
                    alertError('Error Login','Veillez contacter l\'administrateur ')
                }
            }

        })
    })
    saveModif.addEventListener('click',(e)=>{
        e.preventDefault();
        console.log("btn click ")
        // data=formModifUser.serialize();
        id=document.querySelector('#idClient').value;
        nomUser=document.querySelector('#NomClient').value;
        numero=document.querySelector('#numero').value;
        address=document.querySelector('#adresse').value;
        typeClient=document.querySelector('#Type').value;
        prix=document.querySelector('#Prix').value;
        solde=document.querySelector("#solde").value;
        if(typeClient==''){
            alertError('Veille Selectionne le type de client ');
        }else if(prix>150 || prix<100){
            alertError('Veillez revoir le prix unitaire ');
        }
        else{
            $.ajax({
                type:'post',
                url:'static/php/traitementClient.php',
                data:{Action:'miseAjourUser',id:id,nom:nomUser,num:numero,add:address,type:typeClient,prix:prix,solde:solde},
                dataType:'json',
                success:function(response){
                    if(response.MiseAjourUserOK){
                        closeModif.click();
                        alertSusess('Mise a jour ok ;)');
                    }
                }
            })
        }
    })

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

} );
