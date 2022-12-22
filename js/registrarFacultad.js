/*!
 * Se comunica con el archivo registrarAusen.php donde se realiza la busqueda o query MySQL
 */

$(function()
{
    //get_funcionario();
    $("#incapacidadINPUTS").hide();
    $("#agregar_func").hide();

    //se necesita hacer algo cuando se utilice la búsqueda de cedula y nombre
    $(document).on('keyup', '#nombre1', function() 
    {
        var valor = $('#nombre1').val();

        if(valor != "" && isNaN(valor) ){
            get_funcionario();
        }else if(valor == ""){

            document.getElementById("form_register").reset();
            document.getElementById("fecha_inicio").valueAsDate = new Date();
            document.getElementById("fecha_fin").valueAsDate = new Date();

            //let the user write in the inputs
            document.getElementById("nombre").disabled = false ;
            document.getElementById("cedula").disabled = false;
            document.getElementById("cargo").disabled = false;
            document.getElementById("departamento").disabled = false;
            document.getElementById("facultad").disabled = false;
        }
        //get_funcionario();
    });

    $(document).on('keyup', '#cedula1', function()  //para el cuadro de busqueda de cedula
    {
        var valor = $('#cedula1').val();
        
        if( valor != "" && !isNaN(valor) ){ //valor != "" && !isNaN(valor)
            get_funcionario();
            //$("#input_decor").html("");
            //document.getElementById("nombre").value = "aqui";
        }else if(valor == ""){

            document.getElementById("form_register").reset();
            document.getElementById("fecha_inicio").valueAsDate = new Date();
            document.getElementById("fecha_fin").valueAsDate = new Date();

            //let the user write in the inputs
            document.getElementById("nombre").disabled = false ;
            document.getElementById("cedula").disabled = false;
            document.getElementById("cargo").disabled = false;
            document.getElementById("departamento").disabled = false;
            document.getElementById("facultad").disabled = false;
        }
        //get_funcionario();
    });

    // Slider de tipos de ausentismo
    document.querySelector('#tipo_ausen').onchange = e => {
        const {
            value: number,
            text: label
        } = e.target.selectedOptions[0]
        //console.log(number, label)

        if(number==1){

            $("#incapacidadINPUTS").show();
        }else{
            $("#incapacidadINPUTS").hide();
        }

    }

    // Colocar fechas de inicio y fin de ausentismo en el mismo dia
    DateNow();

});

function get_funcionario()
{
    let form = $("#auto_llenar");  //el id del formulario HTML es "auto-llenar"

    $.ajax(
        {
            type:"POST",
            url:"../logic/registrarAusenFacultad.php",  //es necesario especificar exactamente la ruta
            data:form.serialize(), //aqui se pasa información de los inputs que están en el formulario HTML. serialize pasa los datos en arrays a PHP
            success: function (data)
            {

                //$("#filters-result").html(""); //limpiar la tabla que se muestra en HTML para borrar las busqeudas anteriores
                //$(document).getElementById(".cedula").html("");
                

                $.each(JSON.parse(data), function(key,funcionario)
                {


                    //if funcionario is equal to N/A, then show a button to add a new funcionario 
                    if(funcionario == "N/A"){
                        //clean the form form-register, set the date picker to today 
                        document.getElementById("form_register").reset();
                        document.getElementById("fecha_inicio").valueAsDate = new Date();
                        document.getElementById("fecha_fin").valueAsDate = new Date();

                        //let the user write in the inputs
                        document.getElementById("nombre").disabled = false ;
                        document.getElementById("cedula").disabled = false;
                        document.getElementById("cargo").disabled = false;
                        document.getElementById("departamento").disabled = false;
                        document.getElementById("facultad").disabled = false;
                    }else{
                        
                        document.getElementById("nombre").value = funcionario.Nombre; 
                        document.getElementById("cedula").value = funcionario.Cedula; 
                        document.getElementById("cedula_f").value = funcionario.Cedula; 
                        document.getElementById("cargo").value = funcionario.Cargo; 
                        document.getElementById("departamento").value = funcionario.Departamento; 
                        document.getElementById("facultad").value = funcionario.Facultad;
                        //document.getElementById("ID_depen").value = funcionario.Dependencia;  

                        //dont let the user write in the inputs
                        document.getElementById("nombre").disabled = true ;
                        document.getElementById("cedula").disabled = true;
                        document.getElementById("cargo").disabled = true;
                        document.getElementById("departamento").disabled = true;
                        document.getElementById("facultad").disabled = true;
                    }
                });

            }
        }
    )
}

//Funcion para colocar en fecha inicial, la fecha con mes actual
function DateNow()
{        
    var date = new Date();

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;
    //var today = year + "-" + month + "-0" + 1 ;  
    //var today = "2019-07-22";
    document.getElementById("fecha_inicio").value = today; 
    document.getElementById("fecha_fin").value = today; 
    //return today;
}

//enviar el formulario por ajax a ../logic/registrarAusen_form_Facultad.php, para registrar el ausentismo, cuando se presione el boton de registrar
$(document).ready(function(){
    $("#form_register").submit(function(e){
        e.preventDefault();
        var datos = $(this).serialize();
        //console.log(datos);
        $.ajax({
            type: "POST",
            url: "../logic/registrarAusen_form_Facultad.php",
            data: datos,
            success: function(r){
                //parse r to json
                r = JSON.parse(r);
                //console.log(r);

                //if r is success then show a success alert
                if(r == "success"){
                    show_alert('success', 'El ausentismo se ha registrado correctamente');

                    //reset the form after submit
                    document.getElementById("auto_llenar").reset();
                    document.getElementById("form_register").reset();

                    //permitir al usuario escribir en los inputs
                    document.getElementById("nombre").disabled = false ;
                    document.getElementById("cedula").disabled = false;
                    document.getElementById("cargo").disabled = false;
                    document.getElementById("departamento").disabled = false;
                    document.getElementById("facultad").disabled = false;

                }else if(r == "error1"){
                    show_alert('error', 'No existe la cedula del usuario en su dependencia');

                }else if(r == "error2"){
                    show_alert('error', 'Seleccione un tipo de ausentismo');

                }else if(r == "error3"){
                    show_alert('error', 'El tiempo no puede ser mayor a 24 horas.');

                }else if(r == "error4"){
                    show_alert('error', 'El tiempo de las fechas no es igual al tiempo de la ausencia');

                }else if(r == "error5"){
                    show_alert('error', 'Las horas deben estar en el mismo día');

                }else if(r == "error6"){
                    show_alert('error', 'Si escoge Unidad: horas, el tipo de ausentismo debe ser permiso por horas');

                }else {
                    show_alert('error', 'Error en el registro del ausentismo|');
                }

            }
        });
    });
});

//evitar que el usuario abra el inspeccionar elemento
document.addEventListener('contextmenu', function(e) {
    //e.preventDefault();
});