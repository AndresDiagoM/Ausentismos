/**
 * Funcion que añade un evento a la caja de busqueda de cedula y a los botones del paginador
 */
$(function()
{
    busqueda()
    
    $(document).on('keyup', '#caja_busqueda', function(){ //añadir el evento keyup a la caja de busqueda de cedula

        var valor = $(this).val();
    
        if(valor != "" && !isNaN(valor)){
            busqueda(valor, "cedula");
    
        }else{
            busqueda();
        }
    });

    $(document).on('click', '#myPager input', function() //añadir el evento click a los botones del paginador
    {
        var valor = $(this).val();
        busqueda(valor, "pagina");
    });
});

/**
 * Funcion que realiza la busqueda de los funcionarios
 * @param {*} consulta 
 * @param {*} param 
 */
function busqueda(consulta, param){
    let enviar = Array();
    //let form2=enviar.serializeArray();
    //enviar.push({name: "Pagina", value: pagina});

    //si param es "cedula", entonces se realiza una busqueda por cedula. Si es "pagina", se realiza una busqueda por pagina
    if(param=="cedula"){
        enviar.push({name: "Cedula", value: consulta});
    }else if(param=="pagina"){
        enviar.push({name: "Pagina", value: consulta});
    }
    //console.log(enviar);

    $("#myPager").html(""); //se limpia el paginador
    $("#total_resultados").html("");

    //se realiza la busqueda por ajax
    $.ajax({
        url:        '../logic/searchFuncLogic.php',
        type:       'POST',
        dataType:   'html',
        data:       enviar, //{consulta:consulta},

    })
    .done(function(respuesta){
        const obj = JSON.parse(respuesta);
        //console.log(obj.tabla);
        $("#datos").html(obj.tabla); //se muestra la tabla con los datos de la busqueda
        $("#myPager").append(obj.slider); //se muestra el paginador
        $("#total_resultados").append(obj.total);

    })
    .fail(function(){
        console.log("Fail");
    })

}