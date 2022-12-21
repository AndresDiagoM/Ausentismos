<?php
    include "../template/cabecera.php";
    $id_usuario     = $_GET['ID'];
    //si la variable $id_usuario esta vacia, o tiene valore sque no sean numeros, redireccionar a la pagina de admin_edition
    if(empty($id_usuario) || !is_numeric($id_usuario)){
        if(headers_sent())
            die("<script>location.href='admin_edition_client.php';</script>");
        else
            exit(header("Location: admin_edition_client.php"));
        //header("Location: admin_edition.php");
    }

?>


<!-- INICIO DE CONTENEDOR DE USUARIO SELECCIONADO -->
<div class="container card-group py-2">

    <div class="card">
        <div class="card-header">
            DATOS ACTUALES
        </div>
        <div class="card-body">
            
            <?php
                $sqli   = "SELECT * FROM usuarios 
                            INNER JOIN dependencias ON usuarios.Dependencia=dependencias.ID 
                            WHERE Cedula_U = '$id_usuario'";
                $result = $conectar->query($sqli);
                $num_rows = $result->num_rows;
                //si no encuentra ningun usuario, entonces redirigir admin_edition_client.php
                if($num_rows >0 ){
                    $data=[];
                    while($row = mysqli_fetch_assoc($result)){
                        $Id_editar = $row['Cedula_U'];
                        $data[] = $row;
                    }
                    $mostrar = $data[0];
                    //print_r($mostrar);
                }else{
                    die("<script>location.href='admin_edition_client.php';</script>");
                }

            ?>
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre_U'] ?></h5>
            <form>
                
                <!-- LABEL DE Cedula -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Cedula_U'];?>">
                    <label class="col-form-label" for="Cedula_U"> Cedula </label>
                </div>
                
                <!-- LABEL DE Nombre -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Nombre_U'];?>">
                    <label class="col-form-label" for="Nombre"> Nombre </label>
                </div>
                
                <!-- LABEL DE Correo -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Correo'];?>">
                    <label class="col-form-label" for="Correo"> Correo </label>
                </div>
                
                <!-- LABEL DE Departamento -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Departamento'];?>">
                    <label class="col-form-label" for="Departamento"> Departamento </label>
                </div>
                
                <!-- LABEL DE Facultad -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['Facultad'];?>">
                    <label class="col-form-label" for="Facultad"> Facultad </label>
                </div>
                
                <!-- LABEL DE TipoUsuario -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" value="<?php echo $mostrar['TipoUsuario'];?>">
                    <label class="col-form-label" for="TipoUsuario"> Tipo Usuario </label>
                </div>
                
                <!-- LABEL DE Login -->
                <div class="form-floating mb-2">
                    <input type="text" readonly disabled  class="form-control" min="4" max="40" placeholder="Digite su Login"  value="<?php echo $mostrar['Login'];?>">
                    <label class="col-form-label" for="login"> Login </label>
                </div>
                
                <!-- LABEL DE LA Contraseña -->
                <div class="form-floating mb-2">
                    <input type="password" readonly disabled  class="form-control" min="4" max="40" placeholder="Digite su contraseña"  value="<?php echo $mostrar['Contrasena'];?>">
                    <label class="col-form-label" for="Contraseña"> Contraseña </label>
                </div>
            </form>
            
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            MODIFICACIÓN DE DATOS
        </div>
        <div class="card-body">
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre_U'] ?></h5>

            <form action="../logic/form_editLogic.php?ID=<?php echo $Id_editar ?>" method="POST">
                
                <!-- INPUT DE LA CEDULA -->
                <div class="form-floating mb-2">
                    <input type="text" name="cedula_usuario_edt" class="form-control" pattern="[0-9]{3,10}" value="<?php echo $mostrar['Cedula_U'];?>" placeholder="Digite su cedula"  required>
                    <label class="col-form-label" for="cedula_usuario_edt"> Cedula </label>
                </div>

                <!-- INPUT DEL Nombre -->
                <div class="form-floating mb-2">
                    <input type="text" name="nombre_usuario_edt" class="form-control" min="4" max="45"  value="<?php echo $mostrar['Nombre_U'];?>" placeholder="Digite su nombre"  required>
                    <label class="col-form-label" for="nombre_usuario_edt"> Nombre </label>
                </div>

                <!-- INPUT DEL Correo -->
                <div class="form-floating mb-2">
                    <input type="email" name="correo_usuario_edt" class="form-control" min="4" max="40" value="<?php echo $mostrar['Correo'];?>" placeholder="Digite su correo"  required>
                    <label class="col-form-label" for="correo_usuario_edt"> Correo </label>
                </div>

                <!-- INPUT DE LA DEPENDENCIA -->
                <div class="form-floating mb-2">
                    <select class="form-select form-select-sm" name="dependencia_usuario_edt">
                        <option value="">Seleccione</option>
                        <?php
                            //Consultar dependencias de la base de datos, donde la facultad y departamento sean unicos
                            //$sql = "SELECT DISTINCT facultad, departamento FROM dependencias";
                            $sql = "SELECT * FROM dependencias ORDER BY Departamento";
                            $result = $conectar->query($sql);
                            //echo 'ERROR'.$conectar->error;
                            //print_r($result); exit;
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo '<option value="'.$row['ID'].'">'.$row['Facultad'].' - '.$row['Departamento'].'</option>';
                                    if($row['ID'] == $mostrar['ID']){
                                        echo '<option value="'.$row['ID'].'" selected>'.$row['Facultad'].' - '.$row['Departamento'].'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>
                    <label class="col-form-label" for="dependencia"> Dependencia </label>
                </div>

                <div class="form-floating mb-2">
                    <select class="form-select" name="tipo_usuario_edt" required>
                            <option value="">Seleccione</option>
                            <option value="ADMIN" <?php if($mostrar['TipoUsuario'] == 'ADMIN'){echo 'selected';}?> >ADMIN</option>
                            <option value="CONSULTA" <?php if($mostrar['TipoUsuario'] == 'CONSULTA'){echo 'selected';}?> >CONSULTA</option>
                            <option value="FACULTAD" <?php if($mostrar['TipoUsuario'] == 'FACULTAD'){echo 'selected';}?> >FACULTAD</option>
                    </select>
                    <label for="tipo_usuario_edt" class="col-form-label">Tipo Usuario</label>
                </div>

                <!-- INPUT DEL LOGIN -->
                <div class="form-floating mb-2">
                    <input type="text" name="login_usuario_edt" class="form-control" min="4" max="40" value="<?php echo $mostrar['Login'];?>" placeholder="Digite su login"  required>
                    <label class="col-form-label" for="login"> Login </label>
                </div>

                <!-- INPUT DE LA Contraseña -->
                <div class="form-floating mb-2">
                    <input type="password" name="contrasena_usuario_edt" class="form-control" min="4" max="40" value="<?php echo $mostrar['Contrasena'];?>" placeholder="Digite su contraseña"  required>
                    <label class="col-form-label" for="login"> Contraseña </label>
                </div>

                <button type="submit" class="btn btn-success">Modificar</button> 
            </form>

        </div>
        
    </div>

</div>


</div> <!-- fin de la clase w-100-->
</div> <!-- fin de la clase d-flex -->

    <!-- Bootstrap core JavaScript -->
    <script src="../bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS 
    <script src="../js/app1.js"></script> -->

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 


<?php
    include("../template/pie.php");
?>