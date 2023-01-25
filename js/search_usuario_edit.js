/**
 * Funcion para añadir un evento al input de busqueda
 */
$(function()
{
    busqueda()
    
    $(document).on('keyup', '#caja_busqueda', function(){

        var valor = $(this).val();
    
        if(valor != "" && !isNaN(valor)){
            busqueda(valor);
    
        }else{
            busqueda();
        }
    });
});

/**
 * Funcion para realizar la busqueda de usuarios
 * @param {*} consulta 
 */
function busqueda(consulta){

    $.ajax({
        url:        '../logic/searchUsuarioLogic.php',
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


/**
 * funcion para eliminar usuario, se envia el id del usuario a eliminar por ajax a la pagina confirmationDeleteLogic.php
 * @param {*} id 
 */
function eliminarUsuario(id) {  //href='../logic/confirmationDeleteLogic.php?ID=$Id_fila'
    Swal.fire({
        title: '¿Está seguro de eliminar el usuario?',
        text: "¡No podrá revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../logic/confirmationDeleteLogic.php",
                type: "GET",
                data: {ID: id},
                success: function (data) {
                    //parse json data
                    data = JSON.parse(data);

                    if (data == "success") {
                        show_alert_reload('success', '¡Usuario eliminado!');

                    } else {
                        show_alert_reload('error', '¡No se pudo eliminar el usuario!');
                    }
                }
            });
        }
    })
}