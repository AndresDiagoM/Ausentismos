/*
    * Este archivo se encarga de realizar la busqueda de funcionarios en la base de datos
    * Se comunica con el archivo registrarAusen.php donde se realiza la busqueda o query MySQL
    * Se crea el evento del boton de registrar ausentismo
    * Tambien se encarga de mostrar los inputs de incapacidad cuando se selecciona incapacidad en el slider de tipos de ausentismo
 */

$(function()
{
    //get_funcionario();
    $("#incapacidadINPUTS").hide();
    $("#agregar_func").hide();

    //Evento de buscar funcionario por nombre
    $(document).on('keyup', '#nombre1', function() //para el cuadro de busqueda de nombre
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

    //Evento de buscar funcionario por cedula
    $(document).on('keyup', '#cedula1', function()  //para el cuadro de busqueda de cedula
    {
        var valor = $('#cedula1').val();
        
        if( valor != "" && !isNaN(valor) ){ //valor != "" && !isNaN(valor)
            get_funcionario();
            //$("#input_decor").html("");
            //document.getElementById("nombre").value = "aqui";
        }else if(valor == ""){

            //clean the form auto-llenar
            document.getElementById("form_register").reset();
            //console.log("no es numero");
            document.getElementById("fecha_inicio").valueAsDate = new Date();
            document.getElementById("fecha_fin").valueAsDate = new Date();

            //let the user write in the inputs
            document.getElementById("nombre").disabled = false ;
            document.getElementById("cedula").disabled = false;
            document.getElementById("cargo").disabled = false;
            document.getElementById("departamento").disabled = false;
            document.getElementById("facultad").disabled = false;

            //get_funcionario();
            //$("#form_register").reset();
        }
        //get_funcionario();
    });

    //Evento para verificar fechas y tiempo
    $(document).on('change', '#tiempo', function() 
    {
        let tiempo = document.getElementById("tiempo").value;
        let unidad = document.getElementById("Unidad").value;
        //console.log( unidad);

        if(unidad == "dias"){
            let fecha_inicio = document.getElementById("fecha_inicio").value;
            let fecha_fin = document.getElementById("fecha_fin").value;

            let date1 = new Date(fecha_inicio);
            let date2 = new Date(fecha_fin);

            let diffTime = Math.abs(date2 - date1);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))+1; 

            //si el tiempo es mayor al rango de fechas entonces mostrar alerta
            if(tiempo > diffDays){
                document.getElementById("tiempo").value = diffDays;
                show_alert('error', 'El tiempo de las fechas es MAYOR al tiempo digitado!');
            }
        }
    });

    // Evento para mostrar inputs de incapacidad cuando se selecciona incapacidad en Slider de tipos de ausentismo
    document.querySelector('#tipo_ausen').onchange = e => {
        const {
            value: number,
            text: label
        } = e.target.selectedOptions[0]
        //console.log(number, label)

        if(number==1){
            //console.log("IFFF")
            //let form = $("#form_register"); 
            //form.serialize()
            //console.log(form)
            //CreateFormInput("Codigo[]", "codigo","Escriba el código", "CODIGO");
            //CreateFormInput("Diagnostico[]", "diagnostico","Escriba el diagnóstico", "DIAGNOSTICO");
            //CreateFormInput("Entidad[]", "entidad","Escriba la entidad", "ENTIDAD");

            $("#incapacidadINPUTS").show();
        }else{
            $("#incapacidadINPUTS").hide();
        }

    }

    // Colocar fechas de inicio y fin de ausentismo en el mismo dia
    DateNow();
});

//funcion para buscar el funcionario
function get_funcionario()
{
    let form = $("#auto_llenar");  //el id del formulario HTML es "auto-llenar"

    $.ajax(
        {
            type:"POST",
            url:"../logic/searchFunc.php",  //es necesario especificar exactamente la ruta
            data:form.serialize(), //aqui se pasa información de los inputs que están en el formulario HTML. serialize pasa los datos en arrays a PHP
            success: function (data)
            {

                //$("#filters-result").html(""); //limpiar la tabla que se muestra en HTML para borrar las busqeudas anteriores
                //$(document).getElementById(".cedula").html("");
                

                $.each(JSON.parse(data), function(key,funcionario)
                {
                    
                    //$("#filters-result").append(row);
                    //$("cargo").value(funcionario.Cedula);
                    

                    //if funcionario is equal to N/A, then show a button to add a new funcionario 
                    if(funcionario == "N/A"){
                        $("#agregar_func").show();

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
                        $("#agregar_func").hide();
                        document.getElementById("nombre").value = funcionario.Nombre; 
                        document.getElementById("cedula").value = funcionario.Cedula; 
                        document.getElementById("cedula_f").value = funcionario.Cedula; 
                        document.getElementById("cargo").value = funcionario.Cargo; 
                        document.getElementById("departamento").value = funcionario.Departamento; 
                        document.getElementById("facultad").value = funcionario.Facultad; 

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

//enviar datos del form a ../logic/registrarAusen_form.php con peticion ajax cuando se presion el boton de registrar
$(document).ready(function(){
    $("#form_register").submit(function(e){
        e.preventDefault();
        var datos = $(this).serialize();
        //console.log(datos);
        $.ajax({
            type: "POST",
            url: "../logic/registrarAusen_form.php",
            data: datos,
            success: function(r){
                var obj = JSON.parse(r);
                //console.log(obj);

                if(obj=="success"){
                    show_alert_reset_form('success', 'Registro exitoso!', "form_register");

                    //reset the form after submit
                    document.getElementById("auto_llenar").reset();

                    //permitir al usuario escribir en los inputs
                    document.getElementById("nombre").disabled = false ;
                    document.getElementById("cedula").disabled = false;
                    document.getElementById("cargo").disabled = false;
                    document.getElementById("departamento").disabled = false;
                    document.getElementById("facultad").disabled = false;

                }else if(obj=="error1"){
                    show_alert_reset_form('error', 'No existe la cedula del funcionario!', "form_register");

                }else if(obj=="errorTiempo"){
                    show_alert('error', 'El tiempo de las fechas no es igual al tiempo de la ausencia!');

                }else if(obj=="error2"){
                    show_alert('error', 'Debe seleccionar el tipo de ausentismo!');
                    
                }else if(obj=="error3"){
                    show_alert('error', 'Las horas deben estar en el mismo día!');

                }else if(obj=="error4"){
                    show_alert('error', 'Si escoge Unidad: horas, el tipo de ausentismo debe ser permiso por horas.');

                }else if(obj=="error5"){
                    show_alert('error', 'Si escoge el tipo de ausentismo: incapacidad, debe ingresar el codigo de incapacidad.');

                }else if(obj=="error6"){
                    show_alert('error', 'El codigo de incapacidad no existe.');

                }else if(obj=="error7"){
                    show_alert('error', 'Error al registrar incapacidad.');

                }else if(obj=="error8"){
                    show_alert('error', 'El registro ya existe.');

                }else{
                    show_alert('error', 'Error al registrar ausentismo.');
                }

            }
        });
    });
});