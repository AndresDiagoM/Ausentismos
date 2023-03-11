/**
 * Script para que solo se puedan subir archivos de excel .xlsx y .xls
 */
$(document).ready(function(){
    $("#excelFile").change(function(){
        var file = this.files[0];
        var fileType = file.type;
        var match = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        if(!(fileType == match[0] || fileType == match[1])){
            
            show_alert('error', 'Por favor seleccione un archivo de excel válido.');
            $("#excelFile").val('');
            return false;
        }
    });
});

/**
 * Script para cargar el archivo de excel cuando se presiona el boton "Cargar"
 */
$(document).ready(function(){
    //alert("Hola");
    //$("#formulario").submit(function(e){
    $("form[name=formulario]").submit(function(e){
        e.preventDefault(); //para que el formulario no se envie

        //obtener el archivo cargado en el formulario
        var file = $("#excelFile")[0].files[0];

        //enviar el archivo al servidor con una peticion ajax
        var formData = new FormData();
        formData.append("excelFile", file);

        //ajax call
        $.ajax({
            url: "../logic/cargarFuncionarios.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){ //si la peticion es exitosa, se ejecuta esta funcion
                //alert(response);

                //convertir el objeto de respuesta a un objeto JSON
                var obj = JSON.parse(response);
                //console.log(obj);
                //console.log(obj.alert);
                

                //if obj has the property alert, then show the alert
                if(obj.alert=="success_aux"){

                    show_alert_reload('success', 'Archivo cargado correctamente.');

                    //add to the div id="table_func_aux" the table with the data
                    //$("#table_func_aux").html(obj.table);

                    //add to the div id=cargar_conte the section obj.button
                    //$("#cargar_conte").html(obj.button);

                }else if(obj == "error1"){
                    show_alert('error', 'El archivo no es de excel.');
                    $("form[name=formulario]").trigger("reset");

                }else if(obj == "error2"){
                    show_alert('error', 'El archivo no tiene el formato correcto.');

                    //clean the form
                    $("form[name=formulario]").trigger("reset");

                }
                else{
                    show_alert('error', 'Error al cargar el archivo.');
                    $("form[name=formulario]").trigger("reset");
                }
            }
        });
        
    });
});

/**
 * Funcion para aceptar los cambios cuando se presiona el boton "Aceptar"
 */
function Aceptar(){
    //alert("Hola");
    $.ajax({
        url: "../logic/cargarFuncionarios.php",
        type: "POST",
        data: {aceptar: "aceptar"},
        success: function(response){
            //alert(response);

            //convert the response from json to an object
            var obj = JSON.parse(response);
            console.log(obj);
            //console.log(obj.alert);

            if(obj == "success1"){

                show_alert_reload('success', 'Funcionarios actualizados correctamente!');

                //clean the form
                $("form[name=formulario]").trigger("reset");

                //reload the page
                //location.reload();
            
            }
        }
    });
}

//evitar que el usuario abra el inspeccionar elemento
document.addEventListener('contextmenu', function(e) {
    //e.preventDefault();
});