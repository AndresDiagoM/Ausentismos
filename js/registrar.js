/*!
 * Se comunica con el archivo registrarAusen.php donde se realiza la busqueda o query MySQL
 */

$(function()
{
    //get_funcionario();

    //se necesita hacer algo cuando se utilice la búsqueda de cedula y nombre
    $(document).on('keyup', '#nombre1', function() 
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            //get_funcionarios();
        }else{
            //get_funcionario();
        }
        get_funcionario();
    });

    $(document).on('keyup', '#cedula1', function()  //para el cuadro de busqueda de cedula
    {
        var valor = $('#cedula1').val();
        
        if( valor != "" && !isNaN(valor) ){ //valor != "" && !isNaN(valor)
            get_funcionario();
            //$("#input_decor").html("");
            //document.getElementById("nombre").value = "aqui";
        }else{
            //get_funcionario();
            //$("#form_register").reset();

            /*document.getElementById("form_register").reset();
            document.getElementById("nombre").disabled = false ;
            document.getElementById("cedula").disabled = false;
            document.getElementById("cargo").disabled = false;
            document.getElementById("departamento").disabled = false;
            document.getElementById("facultad").disabled = false; */
        }
        //get_funcionario();
        
    });

});

function get_funcionario()
{
    let form = $("#auto_llenar");  //el id del formulario HTML es "auto-llenar"

    $.ajax(
        {
            type:"POST",
            url:"../logic/registrarAusen.php",  //es necesario especificar exactamente la ruta
            data:form.serialize(), //aqui se pasa información de los inputs que están en el formulario HTML. serialize pasa los datos en arrays a PHP
            success: function (data)
            {

                //$("#filters-result").html(""); //limpiar la tabla que se muestra en HTML para borrar las busqeudas anteriores
                //$(document).getElementById(".cedula").html("");
                

                $.each(JSON.parse(data), function(key,funcionario)
                {
                    
                    //$("#filters-result").append(row);
                    //$("cargo").value(funcionario.Cedula);
                    document.getElementById("nombre").value = funcionario.Nombre; 
                    document.getElementById("cedula").value = funcionario.Cedula; 
                    document.getElementById("cargo").value = funcionario.Cargo; 
                    document.getElementById("departamento").value = funcionario.Departamento; 
                    document.getElementById("facultad").value = funcionario.Facultad; 

                    /*document.getElementById("nombre").disabled = true ;
                    document.getElementById("cedula").disabled = true;
                    document.getElementById("cargo").disabled = true;
                    document.getElementById("departamento").disabled = true;
                    document.getElementById("facultad").disabled = true;*/
                });

            }
        }
    )
}