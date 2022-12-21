// When the user type the cedula, the ajax request is sent to the server. Fill the inputs with the response
$("#cedula").keyup(function(){
    //alert("Hola");
    var cedula = $(this).val();

    //if cedula is empty, clear the inputs
    if(cedula == ""){
        $("#nomb_func").val("");
        $("#cargo").val("");
        $("#dependencia").val("");
        $("#genero").val("");
        $("#salario").val("");
    }else{
        //if cedula is not empty, send the ajax request
        $.ajax({
            type: "POST",
            url: "../logic/admin_create_funcLogic.php",
            data: {cedula:cedula},
            success: function (response) {
                //console.log(response);
                //if the response is not empty, fill the inputs with the response
                if(response != "error"){
                    var datos = JSON.parse(response);
                    //console.log(datos);
                    $("#nomb_func").val(datos.nombre);
                    $("#cargo").val(datos.cargo);
                    $("#dependencia").val(datos.dependencia);
                    $("#genero").val(datos.genero);
                    $("#salario").val(datos.salario);
                }else{
                    $("#nomb_func").val("");
                    $("#cargo").val("");
                    $("#dependencia").val("");
                    $("#genero").val("");
                    $("#salario").val("");
                }
            }
        });
    }
});

//1. when the document is ready, the function is executed
//2. when the form is submitted, the function is executed   
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
                //alert(response);
                if(response == "success1"){
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

//evitar que el usuario abra el inspeccionar elemento
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
});