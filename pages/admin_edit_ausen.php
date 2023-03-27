<?php
    include "../conexion.php";
    session_start();

    $autentication = $_SESSION['TIPO_USUARIO'];
    if($autentication == '' || $autentication == null || !in_array($autentication, array("ADMIN", "ROOT")) ){
        //header('Location: ../pages/inicio_sesion.php?message=3');
        session_destroy();
        echo "<script> alert('Sin permisos'); location.href = '../pages/inicio_sesion.php?message=3';  </script>";    
    }

    include "../template/cabecera.php";
    $id_ausen    = $_GET['ID'];

    //add security to prevent sql injection
    $id_ausen = $conectar->real_escape_string($id_ausen);

    //if there is no id redirect to admin_consultar.php
    if(!isset($id_ausen) || empty($id_ausen)){
        header("Location: ./admin_consultar.php");
    }

    //Consultar datos de ausentismo
    $sqli   = "SELECT ausentismos.*, funcionarios.*, dependencias.ID as ID_depen, dependencias.C_costo as C_costo, dependencias.Departamento as Departamento, dependencias.Facultad as Facultad,
                COALESCE(incapacidad.ID, 'N/A') as ID_In, COALESCE(incapacidad.Codigo, 'N/A') as Codigo, COALESCE(incapacidad.Diagnostico, 'N/A') as Diagnostico, 
                COALESCE(incapacidad.Entidad, 'N/A') as Entidad, COALESCE(incapacidad.ID_Ausentismo, 'N/A') as ID_Ausentismo
                FROM ausentismos 
                INNER JOIN funcionarios On funcionarios.Cedula=ausentismos.Cedula_F
                INNER JOIN dependencias ON funcionarios.Dependencia=dependencias.ID
                LEFT JOIN incapacidad ON ausentismos.ID = incapacidad.ID_Ausentismo
                WHERE ausentismos.ID = $id_ausen";
    $result = $conectar->query($sqli);
    $data=[];
    while($row = mysqli_fetch_assoc($result)){
        $Id_editar = $row['ID'];
        $data[] = $row;
    }
    $mostrar = $data[0];
    //print_r($mostrar);
?>


<!-- INICIO DE CONTENEDOR DE FUNCIONARIO SELECCIONADO -->
<div class="container py-2">

    <div class="card mx-auto" style="overflow-y: auto; width:35rem; height:90vh;">
        <div class="card-header">
            MODIFICACIÓN DE DATOS
        </div>
        <div class="card-body">
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre'] ?></h5>

            <form action="" id="form_update" method="POST">

                <!-- INPUT DE LA CEDULA -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled name="cedula_ausen_edt" class="form-control" pattern="[0-9]{3,15}" title="La identifiación solo debe contener carácteres numéricos." value="<?php echo $mostrar['Cedula'];?>" placeholder="Digite su cedula"  required>
                    <label class="col-form-label" for="cedula_ausen_edt"> Cedula </label>
                </div>

                <!-- INPUT DEL NOMBRE -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled name="nombre_ausen_edt" class="form-control" pattern="[a-zA-Z0-9\s]+" min="4" max="40" title="El nombre solo debe contener carácteres alfabéticos." value="<?php echo $mostrar['Nombre'];?>" placeholder="Digite su nombre"  required>
                    <label class="col-form-label" for="nombre_ausen_edt"> Nombre </label>
                </div>

                <!-- INPUT DE FECHA DE INICIO -->
                <div class="form-floating mb-2">
                    <input type="date" name="fechaI_ausen_edt" class="form-control" value="<?php echo $mostrar['Fecha_Inicio'];?>" required>
                    <label class="col-form-label" for="fechaI_ausen_edt"> Fecha Inicio </label>
                </div>

                <!-- INPUT DE FECHA DE FIN -->
                <div class="form-floating mb-2">
                    <input type="date" name="fechaF_ausen_edt" class="form-control" value="<?php echo $mostrar['Fecha_Fin'];?>" required>
                    <label class="col-form-label" for="fechaF_ausen_edt"> Fecha Fin </label>
                </div>

                <!-- INPUT DE TIEMPO -->
                <div class="form-floating mb-2">
                    <input type="number" name="tiempo_ausen_edt" class="form-control"  placeholder="Tiempo" value="<?php echo $mostrar['Tiempo'];?>" pattern="[0-9]{1,5}" min="1" max="300" title="Solo valores numéricos" required>
                    <label class="col-form-label" for="tiempo_ausen_edt"> Tiempo </label>
                </div>

                <!-- INPUT DE UNIDAD -->
                <div class="form-floating mb-2">
                    <select class="form-select" name="unidad_ausen_edt" required>
                        <option value="">Seleccione</option>
                        <option value="dias" <?php if($mostrar['Unidad'] == 'dias'){echo 'selected';}?> > dias </option>
                        <option value="horas" <?php if($mostrar['Unidad'] == 'horas'){echo 'selected';}?> > horas </option>
                    </select>
                    <label class="col-form-label" for="unidad_ausen_edt"> Unidad </label>
                </div>

                <!-- INPUT DE OBSERVACION -->
                <div class="form-floating mb-2">
                    <input type="text" name="obser_ausen_edt" class="form-control"  placeholder="Observacion" value="<?php echo $mostrar['Observacion'];?>" pattern="[a-zA-Z0-9.\s]+" min="4" max="70" title="Solo valores alfanuméricos" required>
                    <label class="col-form-label" for="obser_ausen_edt"> Observacion </label>
                </div>

                <!-- INPUT DE COSTO -->
                <div class="form-floating mb-2">
                    <input type="number" name="costo_ausen_edt" class="form-control"  placeholder="cargo" value="<?php echo $mostrar['Seguridad_Trabajo'];?>" required>
                    <label class="col-form-label" for="costo_ausen_edt"> Costo </label>
                </div>

                <!-- INPUT DE TIPO DE AUSENTISMO -->
                <div class="form-floating mb-2">
                    <select class="form-select" name="tipo_ausen_edt" id="tipo_ausen" required>
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
                                if($ID == $mostrar['Tipo_Ausentismo'] ){
                                    echo "<option value=\"$ID\" selected> $Nombre </option>";
                                }else{
                                    echo "<option value=\"$ID\" > $Nombre </option>";
                                }
                            }
                        ?>
                    </select>
                    <label class="col-form-label" for="tipo_ausen_edt"> Tipo Ausentismo </label>
                </div>

                <?php
                    if($mostrar['Tipo_Ausentismo']==1){

                        $div = "<div class='form-floating mb-2'>
                                    <input type='text'  name='codigo_ausen_edt' class='form-control'  placeholder='codigo' id='staticEmail' value=' ".$mostrar['Codigo']."' required>
                                    <label for='staticEmail' class='col-sm-2 col-form-label'> Codigo </label>
                                </div>";
                        $div .= "<div class='form-floating mb-2'>
                                    <input type='text'  name='diag_ausen_edt' class='form-control'  placeholder='Diagnostico' id='staticEmail' value='".$mostrar['Diagnostico']."' required>
                                    <label for='staticEmail' class='col-sm-2 col-form-label'> Diagnostico </label>
                                </div>";
                        $div .= "<div class='form-floating mb-2'>
                                    <input type='text'  name='entidad_ausen_edt' class='form-control'  placeholder='Entidad' id='staticEmail' value='".$mostrar['Entidad']."' required>
                                    <label for='entidad_ausen_edt' class='col-sm-2 col-form-label'> Entidad </label>
                                </div>";
                        echo $div;
                    }
                ?>

                <!-- CONTENDEDOR DE BOTONES -->
                <div class="row">
                    <!-- Boton para Modificar registro -->
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-primary btn-block" value="Modificar">
                    </div>

                    <!-- Button to call JavaScript function -->
                    <div class="col-md-9">
                        <?php if($autentication == 'ROOT') { ?>
                            <button class="btn btn-danger btn-block" onclick="deleteRecord(<?php echo $id_ausen ?>)">Eliminar</button>
                        <?php } ?>
                    </div>
                </div>

                
            </form>

        </div>
        
    </div>

</div>


</div> <!-- fin de la clase w-100-->
</div> <!-- fin de la clase d-flex -->

    <!-- Bootstrap core JavaScript -->
    <script src="../assets/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../assets/bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS 
    <script src="../js/app1.js"></script> -->

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 
    <script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>
    <script src="../js/sweet_alert.js"></script>

    <script>
    //enviar datos del form a ../logic/form_ausen_editLogic.php con peticion ajax cuando se presion el boton de registrar
    $(document).ready(function(){
        $("#form_update").submit(function(e){
            e.preventDefault();
            let datos = $(this).serializeArray();
            datos.push({name: "ID", value: "<?php echo $Id_editar; ?>"});

            console.log(datos);
            $.ajax({
                type: "POST",
                url: "../logic/form_ausen_editLogic.php",
                data: datos,
                success: function(r){
                    var obj = JSON.parse(r);
                    //console.log(obj);

                    if(obj=="success"){
                        show_alert_redirect('success', 'Registro exitoso!', "../pages/admin_consultar.php");

                    }else if(obj=="error1"){
                        show_alert('error', 'Complete todos los campos');

                    }else if(obj=="error2"){
                        show_alert('error', 'El tiempo de las fechas no es igual al tiempo de la ausencia!');

                    }else if(obj=="error3"){
                        show_alert('error', 'Las horas deben estar en el mismo día!');

                    }else if(obj=="error4"){
                        show_alert('error', 'Si escoge Unidad: horas, el tipo de ausentismo debe ser permiso por horas.');

                    }else if(obj=="error5"){
                        show_alert('error', 'Si escoge el tipo de ausentismo: incapacidad, debe ingresar el codigo de incapacidad.');

                    }else if(obj=="error6"){
                        show_alert('error', 'El codigo de incapacidad no existe.');

                    }else if(obj=="error7"){
                        show_alert('error', 'Error al registrar incapacidad.');

                    }else if(obj=="error8"){
                        show_alert('error', 'El registro ya existe.');

                    }else{
                        show_alert('error', 'Error al registrar ausentismo.');
                    }

                }
            });
        });
    });

    //funcion para eliminar un registro
    function deleteRecord(id){
        //no enviar el formulario
        event.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro de eliminar el registro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../logic/form_ausen_deleteLogic.php",
                    data: {eliminar_ausen: id},
                    success: function(r){
                        var obj = JSON.parse(r);
                        //console.log(obj);

                        if(obj=="success"){
                            show_alert_redirect('success', 'Registro eliminado!', "../pages/admin_consultar.php");

                        }else{
                            show_alert('error', 'Error al eliminar registro.');
                        }
                    }
                });
            }
        })
    }
    </script>


<?php
    include("../template/pie.php");
?>