/*!
 * Se comunica con el archivo consultarAusen.php donde se realiza la busqueda o query MySQL
 * Se realiza un filtrado dinámico mediante checkboxes
 */

$(function()
{
    get_ausentismos();

    /*const botones = document.querySelectorAll("#myPager input");
    //const botones = document.getElementById("myPager a");
    for(let i = 0; i < botones.length; i++){
        botones[i].addEventListener("click", function(e){
            const num = e.target.dataset.pagina;
            alert(num);
            $("#filters-result").html("");
            e.preventDefault(); //Evita que se recargue la página con el href
        });
    }*/
    $(document).on('click', '#myPager input', function() 
    {
        var valor = $(this).val();
        get_ausentismos(valor);
        //$("#filters-result").html("");
        //$("#total_resultados").append(valor);
    });


    $(document).on('keyup', '#cedula', function()  //para el cuadro de busqueda de cedula
    {
        var valor = $(this).val();

        if(valor != "" && !isNaN(valor) ){
            get_ausentismos();
        }else{
            get_ausentismos();
        }
        //get_ausentismos();
    });

    $(document).on('keyup', '#nombre', function()  //para el cuadro de busqueda de cedula
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            get_ausentismos();
        }else{
            get_ausentismos();
        }
        //get_ausentismos();
    });

    $(document).on('keyup', '#diagnostico', function()  //para el cuadro de busqueda de cedula
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            get_ausentismos();
        }else{
            get_ausentismos();
        }
        //get_ausentismos();
    });

    $(".form-date").on("change",function(){
        //var selected = $(this).val();
        get_ausentismos(); 
        //alert(selected);
    });

});

function get_ausentismos(pagina)
{
    let form = $("#multi-filters");  //el id del formulario HTML es "multi-filters"
    let form2=form.serializeArray();
    form2.push({name: "Pagina", value: pagina});
    //$("#total_resultados").append($.param(form2));
    

    $.ajax(
        {
            type:"POST",
            url:"../logic/consultarAusen2.php",  //es necesario especificar exactamente la ruta
            data:$.param(form2),//form.serialize(), //aqui se pasa información de los inputs que están en el formulario HTML. serialize pasa los datos en arrays a PHP
            success: function (data)
            {
                $("#filters-result").html(""); //limpiar la tabla que se muestra en HTML para borrar las busqeudas anteriores
                $("#total_resultados").html("");
                $("#myPager").html("");
                //var tabla = data.tabla;
                
                $.each(data.tabla, function(key,Ausen)
                {
                    let row = ""+
                    "<tr>"+
                    //"<td>"+key+"</td>"+
                    "<td>"+Ausen.Cedula_F+"</td>"+
                    "<td>"+Ausen.Nombre+"</td>"+
                    "<td>"+Ausen.Fecha_Inicio+"</td>"+
                    "<td>"+Ausen.Fecha_Fin+"</td>"+
                    "<td>"+Ausen.Tiempo+"</td>"+
                    "<td>"+Ausen.Unidad+"</td>"+
                    //imprimir unidad en formato de moneda con 2 decimales y el símbolo de $ 
                    "<td>"+new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Ausen.Seguridad_Trabajo)+"</td>"+
                    //"<td>"+Ausen.Seguridad_Trabajo+"</td>"+
                    
                    "<td>"+Ausen.Codigo+"</td>"+
                    "<td>"+Ausen.Diagnostico+"</td>"+
                    "<td>"+Ausen.Entidad+"</td>"+
                    "</tr>";

                    //se hace el append de cada fila al body de la tabla en admin_consultar.php
                    $("#filters-result").append(row);
                });
                //$("#myPager").append(data.botones);
                $("#myPager").append(data.slider);
                $("#total_resultados").append(data.total);
                
            }
        }
    )
}