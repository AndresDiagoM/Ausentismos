$(busqueda());

function busqueda(consulta){

    $.ajax({
        url:        '../logic/searchClientLogic.php',
        type:       'POST',
        dataType:   'html',
        data:       {consulta: consulta},

    })
    .done(function(respuesta){
        $("#datos").html(respuesta);
    })
    .fail(function(){
        console.log("Fail");
    })

}


$(document).on('keyup', '#caja_busqueda', function(){

    var valor = $(this).val();

    if(valor != ""){
        busqueda(valor);

    }else{
        busqueda();
    }
});