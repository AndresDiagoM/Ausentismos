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
            get_ausentismos();
        }
        //get_ausentismos();
    });

    $(document).on('keyup', '#nombre', function()  //para el cuadro de busqueda de cedula. #nombre es el id del input en el HTML
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            get_ausentismos();
        }else{
            get_ausentismos();
        }
        //get_ausentismos();
    });

    $(document).on('keyup', '#tiempo', function()  //para el cuadro de busqueda de cedula. #nombre es el id del input en el HTML
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            get_ausentismos();
        }else{
            get_ausentismos();
        }
        //get_ausentismos();
    });

    $(".form-date").on("change",function(){  //.form date es la clase de los inputs de fecha
        //var selected = $(this).val();
        get_ausentismos(); 
        //alert(selected);
    });

    $(document).on('keyup', '#codigo', function()  //para el cuadro de busqueda de cedula. #diagnostico es el id del input
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            get_ausentismos();
        }else{
            get_ausentismos();
        }
        //get_ausentismos();
    });

    $(document).on('keyup', '#diagnostico', function()  //para el cuadro de busqueda de cedula. #diagnostico es el id del input
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            get_ausentismos();
        }else{
            get_ausentismos();
        }
        //get_ausentismos();
    });

    $(document).on('keyup', '#entidad', function()  //para el cuadro de busqueda de cedula. #entidad es el id del input en el HTML
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            get_ausentismos();
        }else{
            get_ausentismos();
        }
        //get_ausentismos();
    });

    $(".fila_tabla").on("click",function(){  //.FILA_TABLA, es la clase de las filas de la tabla
        //var selected = $(this).val();
        //get_ausentismos(); 
        //alert(selected);
        console.log("hhhh");
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
            url:"../logic/consultarAusen.php",  //es necesario especificar exactamente la ruta
            data:$.param(form2),//form.serialize(), //aqui se pasa información de los inputs que están en el formulario HTML. serialize pasa los datos en arrays a PHP
            success: function (data)
            {
                $("#filters-result").html(""); //limpiar la tabla que se muestra en HTML para borrar las busqeudas anteriores
                $("#total_resultados").html("");
                $("#myPager").html("");
                //var tabla = data.tabla;
                
                $.each(data.tabla, function(key,Ausen)
                {

                    //create a var id, if Ausen.ID_Ausentismo is equal to N/A then id=Ausen.ID, else id=Ausen.ID_Ausentismo
                    var id = Ausen.ID_Ausentismo;
                    if(id == "N/A"){
                        id = Ausen.ID;
                    }

                    let row = ""+
                    "<tr class='fila_tabla' id="+ id +">"+
                    //"<td>"+key+"</td>"+
                    "<td>"+Ausen.Cedula_F+"</td>"+
                    "<td>"+Ausen.Nombre+"</td>"+
                    "<td>"+Ausen.Fecha_Inicio+"</td>"+
                    "<td>"+Ausen.Fecha_Fin+"</td>"+
                    "<td>"+Ausen.Tiempo+"</td>"+
                    "<td>"+Ausen.Unidad+"</td>"+
                    "<td>"+Ausen.Observacion+"</td>"+ 
                    //imprimir unidad en formato de moneda con 2 decimales y el símbolo de $ 
                    "<td>"+new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Ausen.Seguridad_Trabajo)+"</td>"+
                    //"<td>"+Ausen.Seguridad_Trabajo+"</td>"+

                    "<td>"+Ausen.Login+"</td>"+
                    "<td>"+Ausen.Tipo_Ausentismo+"</td>";

                    //if there is not index Ausen.Codigo in the array, then do not show the button
                    if(Ausen.Codigo != undefined || Ausen.Codigo != null){
                        row = row + "<td>"+Ausen.Codigo+"</td>";
                        row = row + (Ausen.Diagnostico ? "<td>"+Ausen.Diagnostico+"</td>" : "");
                        row = row + (Ausen.Entidad ? "<td>"+Ausen.Entidad+"</td>" : "");
                    }

                    row = row +"</tr>";

                    //se hace el append de cada fila al body de la tabla en admin_consultar.php
                    $("#filters-result").append(row);
                    //clear row variable
                    row = "";
                });
                
                //$("#myPager").append(data.botones);
                $("#myPager").append(data.slider);
                $("#total_resultados").append(data.total);
                
                //evento click para cada fila de la tabla
                $('.fila_tabla').click(function(){
                    //console.log(e);

                    //get the id of the tr that was clicked
                    var id = $(this).attr('id');
                    //console.log(id);

                    //redirect to the page that shows the ausentismo
                    window.location.href = "admin_edit_ausen.php?ID="+id;

                    /*var cedula = $(this).find('td').eq(0).text();
                    var nombre = $(this).find('td').eq(1).text();
                    */
                    //console.log(cedula);

                    //alert("I've been clicked!")
                });
            }
        }
    )
}