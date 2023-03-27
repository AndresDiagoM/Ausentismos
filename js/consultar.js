/*!
 * Se comunica con el archivo consultarAusen.php donde se realiza la busqueda o query MySQL
 * Se realiza un filtrado dinámico mediante checkboxes
 */

$(function()
{
    fechas();
    get_ausentismos();

    //se reliaza la busqueda cuando se de click en el boton del paginador
    $(document).on('click', '#myPager input', function() 
    {
        var valor = $(this).val();
        get_ausentismos(valor);
        //$("#filters-result").html("");
        //$("#total_resultados").append(valor);
    });

    //se realiza la busqueda cuando se de click en el boton de la cedula
    $(document).on('keyup', '#cedula', function()  //para el cuadro de busqueda de cedula
    {
        var valor = $(this).val();

        if(valor != "" && !isNaN(valor) ){
            //add to the th class list the atribute table-warning to change the color of the th
            document.getElementById("th_cedula").classList.add("table-warning");
            get_ausentismos();
        }else{
            get_ausentismos();

            //remove the atribute table-warning to change the color of the th
            document.getElementById("th_cedula").classList.remove("table-warning");
        }

        //get_ausentismos();
    });

    //se realiza la busqueda cuando se de click en el boton del nombre
    $(document).on('keyup', '#nombre', function()  //para el cuadro de busqueda de cedula. #nombre es el id del input en el HTML
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            //add to the th class list the atribute table-warning to change the color of the th
            document.getElementById("th_nombre").classList.add("table-warning");
            get_ausentismos();

        } else if( valor == "" ){
            get_ausentismos();

        } else{
            //get_ausentismos();
            //remove the atribute table-warning to change the color of the th
            document.getElementById("th_nombre").classList.remove("table-warning");
        }
        //get_ausentismos();
    });

    //se realiza la busqueda cuando se de click y cuando se escribe en el boton de fecha_inicio
    $(document).on('keyup'&&'click'&&'change', '#fecha_inicio', function()  //#fecha_inicio es el id del input en el HTML
    {
        var valor = $(this).val();
        //console.log(valor);

        if(valor != ""){
            //add to the th class list the atribute table-warning to change the color of the th
            document.getElementById("th_fecha_inicio").classList.add("table-warning");
            get_ausentismos();
        }else{
            //get_ausentismos();

            //remove the atribute table-warning to change the color of the th
            document.getElementById("th_fecha_inicio").classList.remove("table-warning");
        }
        //get_ausentismos();
    });

    //se realiza la busqueda cuando se de click y cuando se escribe en el boton de fecha_fin
    $(document).on('keyup'&&'click'&&'change', '#fecha_fin', function()  //#fecha_fin es el id del input en el HTML
    {
        var valor = $(this).val();
        //console.log(valor);

        if(valor != ""){
            //add to the th class list the atribute table-warning to change the color of the th
            document.getElementById("th_fecha_fin").classList.add("table-warning");
            get_ausentismos();
        }else{
            //get_ausentismos();

            //remove the atribute table-warning to change the color of the th
            document.getElementById("th_fecha_fin").classList.remove("table-warning");
        }
        //get_ausentismos();
    });

    $(document).on('keyup', '#tiempo', function()  //para el cuadro de busqueda de cedula. #nombre es el id del input en el HTML
    {
        var valor = $(this).val();

        if(valor != "" && !isNaN(valor) ){
            //add to the th class list the atribute table-warning to change the color of the th
            document.getElementById("th_tiempo").classList.add("table-warning");
            get_ausentismos();
        }else{
            get_ausentismos();

            //remove the atribute table-warning to change the color of the th
            document.getElementById("th_tiempo").classList.remove("table-warning");
        }
        //get_ausentismos();
    });

    $(document).on('click', '#unidad', function()  //para el cuadro de busqueda de cedula. #unidad es el id del input en el HTML
    {
        get_ausentismos(); //cuando se de click en el checkbox que se ejecute get_ausentismos();

        //add to the th class list the atribute table-warning to change the color of the th. if it is already there, then it will be removed
        if(document.getElementById("th_unidad").classList.contains("table-warning")){
            //document.getElementById("th_tipo").classList.remove("table-warning");
        }else{
            document.getElementById("th_unidad").classList.add("table-warning");
        }

        //if the checkbox is unchecked, then remove the class table-warning to the th
        if(!$(this).is(':checked')){
            document.getElementById("th_unidad").classList.remove("table-warning");
        }
    });

    //OBSERVACION
    $(document).on('keyup', '#observacion', function() 
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            //add to the th class list the atribute table-warning to change the color of the th
            document.getElementById("th_observacion").classList.add("table-warning");
            get_ausentismos();
        }else{
            get_ausentismos();

            //remove the atribute table-warning to change the color of the th
            document.getElementById("th_observacion").classList.remove("table-warning");
        }
        //get_ausentismos();
    });

    //se necesita hacer algo cuando se utilice los checkboxes de TIPO AUSENTISMOS
    $(".tipo_ausen").on("click", function ()  //la funcion onClick de JQUERY, todos los checkbox inputs en el HTML tienen la clase "form-check-input"
    {
        get_ausentismos(); //cuando se de click en el checkbox que se ejecute get_ausentismos();

        //add to the th class list the atribute table-warning to change the color of the th. if it is already there, then it will be removed
        if(document.getElementById("th_tipo").classList.contains("table-warning")){
            //document.getElementById("th_tipo").classList.remove("table-warning");
        }else{
            document.getElementById("th_tipo").classList.add("table-warning");
        }

        //if the checkbox is unchecked, then remove the class table-warning to the th
        if(!$(this).is(':checked')){
            document.getElementById("th_tipo").classList.remove("table-warning");
        }
    }); 

    $(document).on('keyup', '#codigo', function()  // #codigo es el id del input
    {
        var valor = $(this).val();

        if(valor != "" ){
            //add to the th class list the atribute table-warning to change the color of the th
            document.getElementById("th_codigo").classList.add("table-warning");
            get_ausentismos();
        }else{
            get_ausentismos();

            //remove the atribute table-warning to change the color of the th
            document.getElementById("th_codigo").classList.remove("table-warning");
        }
        //get_ausentismos();
    });

    $(document).on('keyup', '#diagnostico', function()  // #diagnostico es el id del input
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            //add to the th class list the atribute table-warning to change the color of the th
            document.getElementById("th_diagnostico").classList.add("table-warning");
            get_ausentismos();
        }else{
            //get_ausentismos();

            //remove the atribute table-warning to change the color of the th
            document.getElementById("th_diagnostico").classList.remove("table-warning");
        }
        //get_ausentismos();
    });

    $(document).on('keyup', '#entidad', function()  // #entidad es el id del input en el HTML
    {
        var valor = $(this).val();

        if(valor != "" && isNaN(valor) ){
            //add to the th class list the atribute table-warning to change the color of the th
            document.getElementById("th_entidad").classList.add("table-warning");
            get_ausentismos();
        }else{
            //get_ausentismos();

            //remove the atribute table-warning to change the color of the th
            document.getElementById("th_entidad").classList.remove("table-warning");
        }
        //get_ausentismos();
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
                //parse the data to JSON
                //data = JSON.parse(data);

                $("#filters-result").html(""); //limpiar la tabla que se muestra en HTML para borrar las busqeudas anteriores
                $("#total_resultados").html("");
                $("#myPager").html("");
                //var tabla = data.tabla;
                //console.table(data.tabla);
                
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
                
                //SI EL TIPO DE USUARIO (data.tipo_user) ES IGUAL A "ADMIN", SE AÑADE EL EVENTO A LAS FILAS DE LA TABLA
                //console.log(data.tipo_usuario);
                if(data.tipo_usuario == "ADMIN" || data.tipo_usuario == "ROOT"){
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
        }
    )
}

/**
 * Función que configura las fechas de inicio y fin de año para mostrarlas en los inputs de fechas
 */
function fechas(){
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;
    var tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    var tomorrow_string = tomorrow.toISOString().slice(0,10);
    //var today =  +year + "-" + month + "-" + (day+1-day) ;  
    var inicio_año = year + "-" + "01" + "-" + "01";
    document.getElementById("fecha_inicio").value = inicio_año; 
    document.getElementById("fecha_fin").value = tomorrow_string;

    //console.log(tomorrow);
    //convertir fecha tomorrow a string
    //console.log(tomorrow_string);
}