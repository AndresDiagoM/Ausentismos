/*!
 * Se comunica con el archivo consultarAusen.php donde se realiza la busqueda o query MySQL
 * Se realiza un filtrado dináico mediante checkboxes
 */

$(function()
{
    get_ausentismos();
});

function get_ausentismos()
{
    $.ajax(
        {
            type:"POST",
            url:"../logic/consultarAusen.php",  //es necesario especificar exactamente la ruta
            data:"",
            success: function (data)
            {
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