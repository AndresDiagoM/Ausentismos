/*!
 * Se comunica con el archivo consultarAusen.php donde se realiza la busqueda o query MySQL
 * Se realiza un filtrado dináico mediante checkboxes
 */

$(function()
{
    get_ausentismos();

    //se necesita hacer algo cuando se utilice los checkboxes, la búsqueda de cedula y la fecha
    $(".form-check-input").on("click", function ()  //la funcion onClick de JQUERY, todos los checkbox inputs en el HTML tienen la clase "form-check-input"
    {
        get_ausentismos(); //cuando se de click en el checkbox que se ejecute get_ausentismos();
    }); 

    $(document).on('keyup', '#cedula', function()  //para el cuadro de busqueda de cedula
    {
        var valor = $(this).val();

        if(valor != "" && !isNaN(valor) ){
            get_ausentismos();
        }else{
            //get_ausentismos();
        }
        //get_ausentismos();
    });
});

function get_ausentismos()
{
    let form = $("#multi-filters");  //el id del formulario HTML es "multi-filters"

    $.ajax(
        {
            type:"POST",
            url:"../logic/consultarAusen.php",  //es necesario especificar exactamente la ruta
            data:form.serialize(), //aqui se pasa información de los inputs que están en el formulario HTML. serialize pasa los datos en arrays a PHP
            success: function (data)
            {

                $("#filters-result").html(""); //limpiar la tabla que se muestra en HTML para borrar las busqeudas anteriores

                $.each(JSON.parse(data), function(key,Ausen)
                {
                    let row = ""+
                    "<tr>"+
                    "<td>"+key+"</td>"+
                    "<td>"+Ausen.Cedula_F+"</td>"+
                    "<td>"+Ausen.Fecha_Inicio+"</td>"+
                    "<td>"+Ausen.Fecha_Fin+"</td>"+
                    "<td>"+Ausen.Tiempo+"</td>"+
                    "<td>"+Ausen.Observacion+"</td>"+ 
                    "<td>"+Ausen.Seguridad_Trabajo+"</td>"+
                    "<td>"+Ausen.ID_Usuario+"</td>"+
                    "<td>"+Ausen.Tipo_Ausentismo+"</td>"+
                    "</tr>";

                    //se hace el append de cada fila al body de la tabla en admin_consultar.php
                    $("#filters-result").append(row);
                });

            }
        }
    )
}