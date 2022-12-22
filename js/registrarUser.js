// When the user type the cedula, the ajax request is sent to the server. Fill the inputs with the response
$("#cedula").keyup(function(){
    //alert("Hola");
    var cedula = $(this).val();

    //if cedula is not empty, send the ajax request
    $.ajax({
        type: "POST",
        url: "../logic/admin_create_userLogic.php",
        data: {cedula:cedula},
        success: function (response) {
            //console.log(response);
            var datos = JSON.parse(response);
            //console.log(datos);

            //if the datos is not empty, fill the inputs with the response
            if(datos != "error"){
                $("#nombre").val(datos.nombre);
                $("#nombreB").val(datos.nombre);
                //$("#cedula").val(datos.cedula);
                $("#correo").val(datos.correo);
                $("#correoB").val(datos.correo);
                //$("#dependencia").val(datos.dependencia);

                //disable the inputs of cedula, correo, nombre and dependencia, but allow the form to collect data
                //$("#cedula").prop("disabled", true);
                $("#correo").prop("disabled", true);
                $("#nombre").prop("disabled", true);
                //$("#dependencia").prop("disabled", true);


            }else{
                $("#nombre").val("");
                //$("#cedula").val("");
                $("#correo").val("");
                //$("#dependencia").val("");

                //enable the inputs of cedula, correo, nombre and dependencia
                //$("#cedula").prop("disabled", false);
                $("#correo").prop("disabled", false);
                $("#nombre").prop("disabled", false);
                //$("#dependencia").prop("disabled", false);
            }

        }
    });

});

//enviar datos del formulario por ajax a ../logic/admin_create_userLogic.php, cuando se envie el formulario
$(document).ready(function(){
    $("form[name=formulario]").submit(function(e){
        e.preventDefault();

        //get the form data and then serialize that
        dataString = $(this).serialize();
        //console.log(dataString);

        $.ajax({
            type: "POST",
            url: "../logic/admin_create_userLogic.php",
            data: dataString,
            success: function (response) {
                //console.log(response);
                //parse response to json
                response = JSON.parse(response);

                if(response == "success"){
                    show_alert('success', 'Usuario registrado con exito!');

                    //limpiar formulario
                    $("form[name=formulario]").trigger("reset");

                    $("#correo").prop("disabled", false);
                    $("#nombre").prop("disabled", false);

                }else if(response == "error1"){
                    show_alert('error', 'Error al registrar el usuario!');

                }else if(response == "error2"){
                    show_alert('error', 'El usuario ya existe!');

                }else if(response == "error3"){
                    show_alert('error', 'El correo ya se encuentra registrado');

                }else if(response == "error4"){
                    show_alert('error', 'El login ya se encuentra registrado');

                }else if(response == "error5"){
                    show_alert('error', 'Registro incorrecto');
                }else if(response == "error6"){
                    show_alert('error', 'El ID no se encuentra registrado en la tabla funcionarios');
                }else{
                    show_alert('error', 'Error en registro de usuario');
                }

            }
        });
    });
});

//evitar que el usuario abra el inspeccionar elemento
document.addEventListener('contextmenu', function(e) {
    //e.preventDefault();
});