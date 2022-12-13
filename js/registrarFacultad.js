/*!
 * Se comunica con el archivo registrarAusen.php donde se realiza la busqueda o query MySQL
 */

$(function()
{
    //get_funcionario();
    $("#incapacidadINPUTS").hide();
    $("#agregar_func").hide();

    //se necesita hacer algo cuando se utilice la búsqueda de cedula y nombre
    $(document).on('keyup', '#nombre1', function() 
    {
        var valor = $('#nombre1').val();

        if(valor != "" && isNaN(valor) ){
            get_funcionario();
        }else if(valor == ""){

            document.getElementById("form_register").reset();
        }
        //get_funcionario();
    });

    $(document).on('keyup', '#cedula1', function()  //para el cuadro de busqueda de cedula
    {
        var valor = $('#cedula1').val();
        
        if( valor != "" && !isNaN(valor) ){ //valor != "" && !isNaN(valor)
            get_funcionario();
            //$("#input_decor").html("");
            //document.getElementById("nombre").value = "aqui";
        }else if(valor == ""){

            //clean the form auto-llenar
            document.getElementById("form_register").reset();
            //console.log("no es numero");

            //get_funcionario();
            //$("#form_register").reset();

            /*document.getElementById("form_register").reset();
            document.getElementById("nombre").disabled = false ;*/
        }
        //get_funcionario();
    });

    // Slider de tipos de ausentismo
    document.querySelector('#tipo_ausen').onchange = e => {
        const {
            value: number,
            text: label
        } = e.target.selectedOptions[0]
        //console.log(number, label)

        if(number==1){
            //console.log("IFFF")
            //let form = $("#form_register"); 
            //form.serialize()
            //console.log(form)
            //CreateFormInput("Codigo[]", "codigo","Escriba el código", "CODIGO");
            //CreateFormInput("Diagnostico[]", "diagnostico","Escriba el diagnóstico", "DIAGNOSTICO");
            //CreateFormInput("Entidad[]", "entidad","Escriba la entidad", "ENTIDAD");

            $("#incapacidadINPUTS").show();
        }else{
            $("#incapacidadINPUTS").hide();
        }

    }

});

function get_funcionario()
{
    let form = $("#auto_llenar");  //el id del formulario HTML es "auto-llenar"

    $.ajax(
        {
            type:"POST",
            url:"../logic/registrarAusenFacultad.php",  //es necesario especificar exactamente la ruta
            data:form.serialize(), //aqui se pasa información de los inputs que están en el formulario HTML. serialize pasa los datos en arrays a PHP
            success: function (data)
            {

                //$("#filters-result").html(""); //limpiar la tabla que se muestra en HTML para borrar las busqeudas anteriores
                //$(document).getElementById(".cedula").html("");
                

                $.each(JSON.parse(data), function(key,funcionario)
                {
                    
                    //$("#filters-result").append(row);
                    //$("cargo").value(funcionario.Cedula);
                    

                    /*document.getElementById("nombre").disabled = true ;
                    document.getElementById("cedula").disabled = true;
                    document.getElementById("cargo").disabled = true;
                    document.getElementById("departamento").disabled = true;
                    document.getElementById("facultad").disabled = true;*/

                    //if funcionario is equal to N/A, then show a button to add a new funcionario 
                    if(funcionario == "N/A"){
                        $("#agregar_func").show();
                    }else{
                        $("#agregar_func").hide();
                        document.getElementById("nombre").value = funcionario.Nombre; 
                        document.getElementById("cedula").value = funcionario.Cedula; 
                        document.getElementById("cargo").value = funcionario.Cargo; 
                        document.getElementById("departamento").value = funcionario.Departamento; 
                        document.getElementById("facultad").value = funcionario.Facultad; 
                    }
                });

            }
        }
    )
}

function CreateFormInput(name1, id1, placeholder1, text1) { //recibe name del input, id del input y el placeholder

    //var form2 = document.getElementById("incapacidadINPUTS");
    //var form3 = document.getElementById("form_register");

    var div1 = document.createElement("div");
    div1.setAttribute("class", "form_group");
    //div1.setAttribute("method", "POST");

    var label1 = document.createElement("label");
    label1.setAttribute("for", name1);
    label1.innerHTML = text1;

    var ID4 = document.createElement("input");
    ID4.setAttribute("type", "text");
    ID4.setAttribute("name", name1);
    ID4.setAttribute("class", "input_decor");
    ID4.setAttribute("id", id1);
    ID4.setAttribute("placeholder", placeholder1);
    ID4.setAttribute("required", "");

    var ID5 = document.createElement("span");
    ID5.setAttribute("class", "form_line");

    div1.append(label1);
    div1.append(ID4);
    div1.append(ID5);
    //form2.appendChild(div1);
    $("#incapacidadINPUTS").append(div1);
}