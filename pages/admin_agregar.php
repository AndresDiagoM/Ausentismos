<?php
    include "../template/cabecera.php";
?>


<!-- CONTENEDOR DE CUADROS DE BÚSQUEDA -->
<div class="container">
    <br>
    
    <div class="col-md-7">
        <header class="main-header">
            <h6>
                <span class="icon-title">
                    <i class="fas fa-filter"></i>
                </span>
                BUSCAR
            </h6>
        </header>
    </div>
    
    <form class="row" id="auto_llenar">

        <div class="form-floating mb-3 col-3">          
            <input type="text" class="form-control" id="cedula1" name="Cedula[]" placeholder="Ingrese la cédula">
            <label class="col-form-label" for="Cedula[]"> C&eacute;dula </label>
        </div>

        <div class="form-floating mb-3 col-3">  
            <input type="text" class="form-control" id="nombre1" name="Nombre[]" placeholder="Ingrese el nombre">
            <label class="col-form-label" for="Nombre[]"> Nombre </label>
        </div>

        <div class="form-floating py-2 mb-3 col-3" id="agregar_func">  
            <a href="./admin_create_func.php" class="btn btn-success">Agregar Funcionario</a>
        </div>

    </form>
</div>


<!-- ESPACIO PARA EL FORMULARIO -->
<div class="container  card-group" style="overflow-y: auto; height:73vh;">    
    <div class="card"  >
        <div class="card-header">
            Datos del funcionario
        </div>
        <div class="card-body ">
            
            <form name="formulario" id="form_register" action="../logic/registrarAusen_form.php" method="POST" >
            <div class="d-block row g-3 align-items-center col-auto">

                <!-- INPUT DE NOMBRES DE USUARIO -->
                <div class="form-floating mb-3">
                    <input type="text" name="Nombre[]" class="form-control" id="nombre" placeholder="Nombres y apellidos" value="" required>
                    <label class="col-form-label" for="Nombre[]"> NOMBRE </label>
                </div>

                <!-- INPUT DE CÉDULA -->                    
                <div class="form-floating mb-3">
                    <input type="text" name="Cedula[]" class="form-control" id="cedula" pattern="[0-9]{3,10}" placeholder="Número de identificación"  title="La identifiación solo debe contener carácteres numéricos." required>
                    <label class="col-form-label" for="Cedula[]"> CÉDULA </label>
                </div>
                <input type="hidden" name="Cedula_F[]"  id="cedula_f" value="" >

                <!-- INPUT DEL cargo -->
                <div class="form-floating mb-3">
                    <input type="text" name="Cargo[]" class="form-control" id="cargo" value="" placeholder="Cargo del funcionario"  required>
                    <label class="col-form-label" for="Cargo[]"> CARGO </label>
                </div>

                <!-- INPUT DEL departamento -->
                <div class="form-floating mb-3">
                    <input type="text" name="Departamento[]" id="departamento" class="form-control" placeholder="Digite el departamento"  required>
                    <label class="col-form-label" for="Departamento[]"> DEPARTAMENTO </label>
                </div>

                <!-- INPUT DEL facultad -->
                <div class="form-floating mb-3">
                    <input type="text" name="Facultad[]" id="facultad" class="form-control" placeholder="Digite la facultad"  required>
                    <label class="col-form-label" for="Facultad[]"> FACULTAD </label>
                </div>

            </div> 

        </div> <!-- fin de la clase card-body -->
    </div> <!-- fin de la clase card -->

    <div class="card">
        <div class="card-header">
            Datos del ausentismo
        </div>

        <div class="card-body">
            <div class="d-block row g-3 align-items-center col-auto">

                <!-- INPUT FECHA INICIO -->
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="fecha_inicio"  name="Fecha_Inicio[]"  value="" min="2018-01-01"> <!-- //value="2019-07-22" -->
                    <label class="col-form-label" for="Fecha_Inicio[]"> FECHA DE INICIO </label>
                </div>

                <!-- INPUT FECHA FIN -->
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="fecha_fin"  name="Fecha_Fin[]"  value="" min="2018-01-01" > <!-- //value="2019-07-22" -->
                    <label class="col-form-label" for="Fecha_Fin[]"> FECHA FIN </label>
                </div>

                <!-- INPUT DE TIEMPO -->
                <div class="form-floating mb-3">
                    <input type="text" name="Tiempo[]" class="form-control" id="tiempo" pattern="[0-9]{1,370}" placeholder="Tiempo del ausentimso" title="Solo debe contener carácteres numéricos." required>
                    <label class="col-form-label" for="Tiempo[]"> TIEMPO </label>
                </div>

                <!-- INPUT DE UNIDAD-->
                <div class="form-floating mb-3">
                    <select class="form-select form-select-sm" name="Unidad[]" id="Unidad" required>
                        <option value="">Seleccione</option>
                        <option value="dias"> DIAS </option>
                        <option value="horas"> HORAS </option>
                    </select>
                    <label class="col-form-label" for="Unidad[]"> UNIDAD </label>
                </div>

                <!-- INPUT DE LA OBSERVACIÓN -->
                <div class="form-floating mb-3">
                    <input type="text" name="Observacion[]" class="form-control" id="observacion" placeholder="Observaciones" required>
                    <label class="col-form-label" for="Observacion[]"> OBSERVACIÓN </label>
                </div>
            
                <!-- INPUT DEL TIPO DE AUSENTISMO -->
                <div class="form-floating mb-3">
                        <select class="form-select form-select-sm" required name="Tipo_Ausentismo[]" id="tipo_ausen">
                            <option value="">Seleccione</option>
                                <?php
                                    $sqli = "SELECT * FROM tipoausentismo";
                                    $tipoAusentismos = $conectar->query($sqli);  //print_r($ausentismos);
                            
                                    $ausen_list = [];
                            
                                    while($tipo = $tipoAusentismos->fetch_assoc()){
                                        //$ausen_list[$tipo["ID"]]=$tipo;
                                        $ID = $tipo["ID"];
                                        $Nombre=$tipo["TipoAusentismo"];
                                        /*<?php echo "\""."type_".$ID."\""; ?> --> "type_1"  */
                                        if($ID == 1){
                                            echo "<option value=\"$ID\">$Nombre</option>";
                                        }else{
                                            echo "<option value=\"$ID\">$Nombre</option>";
                                        }
                                
                                    }
                                ?>
                        </select>
                        <label class="col-form-label" for="Tipo_Ausentismo[]">TIPO DE AUSENTIMO</label>
                    </div>

                <!-- INPUTS INCAPACIDAD -->
                <div class="form-floating mb-3" id="incapacidadINPUTS">
                    <div class="form-floating mb-3">
                        <input type="text" name="Codigo[]" class="form-control" id="codigo" placeholder="Escriba el codigo" >
                        <label class="col-form-label" for="Codigo[]"> CODIGO </label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select form-select-sm" name="Diagnostico[]" id="diagnostico" >
                            <option value="">Seleccione</option>
                            <option value="Enfermedad general"> ENFERMEDAD GENERAL </option>
                            <option value="Enfermedad laboral"> ENFERMEDAD LABORAL </option>
                            <option value="Accidente de trabajo"> ACCIDENTE DE TRABAJO </option>
                        </select>
                        <label class="col-form-label" for="Diagnostico[]"> DIAGNOSTICO </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="Entidad[]" class="form-control" id="entidad" placeholder="Escriba la entidad" >
                        <label class="col-form-label" for="Entidad[]"> ENTIDAD </label>
                    </div>
                </div>

                <input type="hidden" name="ID_Usuario[]"  id="id_usuario" value=<?php echo $id_admin; ?> >

                <!-- BOTON DE REGISTRO-->
                <div class="contenedor_guardar">
                    <button type="submit" class="btn btn-primary">REGISTRAR</button>
                </div>

            </form>

            </div> <!-- fin de la d-block -->
        </div> <!-- fin de la clase card-body -->

    </div> <!-- fin de la clase card --> 
</div>

</div> <!-- fin de la clase w-100-->
</div> <!-- fin de la clase d-flex -->

    
    <script src="../bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../bootstrap-5.2.2-dist/js/popper.min.js"></script>


    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS -->
    <script src="../js/app1.js"></script>

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

    <script src="../js/registrar.js"></script>

<script>
    //SCRIPT para colocar en fecha inicial, la fecha con mes actual
    //function DateNow()
    //{        
        var date = new Date();

        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();

        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        var today = year + "-" + month + "-" + day;
        //var today = year + "-" + month + "-0" + 1 ;  
        //var today = "2019-07-22";
        document.getElementById("fecha_inicio").value = today; 
        document.getElementById("fecha_fin").value = today; 
        //return today;
    //}
</script>

<script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>

<script>
    //enviar datos del form a ../logic/registrarAusen_form.php con peticion ajax cuando se presion el boton de registrar
    $(document).ready(function(){
        $("#form_register").submit(function(e){
            e.preventDefault();
            var datos = $(this).serialize();
            //console.log(datos);
            $.ajax({
                type: "POST",
                url: "../logic/registrarAusen_form.php",
                data: datos,
                success: function(r){
                    var obj = JSON.parse(r);
                    //console.log(obj);

                    if(obj=="success"){
                        //use sweetalert2, reload the page when the alert dissapears
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Registro exitoso!.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                document.getElementById("form_register").reset();
                            }
                        });
                    }else if(obj=="error1"){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'No existe la cedula del funcionario!.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                document.getElementById("form_register").reset();
                            }
                        });
                    }else if(obj=="errorTiempo"){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'El tiempo de las fechas no es igual al tiempo de la ausencia!.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                //document.getElementById("form_register").reset();
                            }
                        });
                    }else if(obj=="error2"){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Debe seleccionar el tipo de ausentismo!.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                //document.getElementById("form_register").reset();
                            }
                        });
                    }else if(obj=="error3"){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Las horas deben estar en el mismo día!.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                //document.getElementById("form_register").reset();
                            }
                        });
                    }else if(obj=="error4"){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Si escoge Unidad: horas, el tipo de ausentismo debe ser permiso por horas.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                //document.getElementById("form_register").reset();
                            }
                        });
                    }else if(obj=="error5"){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Si escoge el tipo de ausentismo: incapacidad, debe ingresar el codigo de incapacidad.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                //document.getElementById("form_register").reset();
                            }
                        });
                    }else if(obj=="error6"){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'El codigo de incapacidad no existe.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                //document.getElementById("form_register").reset();
                            }
                        });
                    }else if(obj=="error7"){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Error al registrar incapacidad.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                //document.getElementById("form_register").reset();
                            }
                        });
                    }else{
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Error al registrar ausentismo.',
                            showConfirmButton: true,
                            //timer: 2500
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                //location.reload();
                                //clean the form
                                //document.getElementById("form_register").reset();
                            }
                        });
                    }


                }
            });
        });
    });
</script>

<?php
    include("../template/pie.php");
?>