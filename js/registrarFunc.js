/**
 * Cuando el usuario utiliza el cuadro de busqueda por cedula, se realiza una busqueda por ajax
 */
$("#cedula").keyup(function(){
    //alert("Hola");
    var cedula = $(this).val();

    //if cedula is not empty, send the ajax request
    $.ajax({
        type: "POST",
        url: "../logic/admin_create_funcLogic.php",
        data: {cedula:cedula},
        success: function (response) {
            //console.log(response);
            var datos = JSON.parse(response);
            //if the datos.nombre is defined, show an alert saying that the cedula is already registered
            if(datos.nombre != undefined){
                //use sweetalert2
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Cedula ya registrada!',
                    showConfirmButton: true,
                    //timer: 1500
                });
                //alert("Cedula ya registrada!");
                //clean the form
                $("form[name=formulario]").trigger("reset");
            }

        }
    });

});

/**
 * Cuando el usuario da click en el boton de registrar funcionario, se realiza una petición por ajax
 */ 
$(document).ready(function(){
    //alert("Hola");
    //$("#formulario").submit(function(e){
    $("form[name=formulario]").submit(function(e){
        e.preventDefault();
        var datos = $(this).serialize();
        //alert(datos);
        $.ajax({
            type: "POST",
            url: "../logic/admin_create_funcLogic.php",
            data: datos,
            success: function (response) {

                //parse response to json
                response = JSON.parse(response);

                //alert(response);
                if(response == "success"){
                    //use sweetalert2
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Funcionario registrado correctamente',
                        showConfirmButton: true,
                        //timer: 1500
                    });
                    //alert("Funcionario registrado correctamente");
                    //window.location.href = "admin_create_func.php";

                    //clean the form
                    $("form[name=formulario]").trigger("reset");
                }else if(response == "error1"){
                    //use sweetalert2
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Error al registrar funcionario',
                        showConfirmButton: true,
                        //timer: 1500
                    });

                }else if(response == "error2"){
                    //use sweetalert2
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Cedula ya registrada!',
                        showConfirmButton: true,
                        //timer: 1500
                    });

                }else if(response == "error3"){
                    //use sweetalert2
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Error al registrar funcionario',
                        showConfirmButton: true,
                        //timer: 1500
                    });

                }
                else{
                    //use sweetalert2
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Error al registrar funcionario',
                        showConfirmButton: true,
                        //timer: 1500
                    });
                }
            }
        });
    });
});