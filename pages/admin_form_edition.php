<?php
    include "../conexion.php";
    include "../logic/admin_securityLogic.php";

     // Inicio o reanudacion de una sesion
    $nombre_admin   = $_SESSION['NOM_USUARIO'];
    $id_admin       = $_SESSION['ID_USUARIO'];
    $tipo_usuario   = $_SESSION['TIPO_USUARIO'];
    $id_usuario     = $_GET['ID'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="icon" href="../images/icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">
    <link rel="stylesheet" href="../css/style_admin_form.css">
    <link rel="stylesheet" href="../css/style_form.css">
    <title>Eliminar Usuario</title>

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../bootstrap-4.4.1-dist/css/bootstrap.min.css">
    
</head>
<body>

<!-- CABECERA DE TRABAJO -->
<div id="particles-js"></div>
<header>
    <div class="contenedor_principal">
        <div class="contenedor_logo">
            <a href="../index.php"><img id="imagen_logo" src="../images/logo.png" alt="Error al cargar la imagen"></a>
        </div>
        <div class="contenedor_nombre_adm">
            <span>FORMULARIO DE EDICIÓN</span>
        </div>
    </div>
</header>

<!-- INICIO DE SLIDE MENU -->
<div class = "contenedor_pr_menu">
    <div id="slide-menu" class="menu-expanded">

        <!-- PROFILE -->
        <div id="profile">
            <div id="photo"><img src="../images/profile2.png" alt=""></div>
            <div id="name"><span>Nombre: <?php echo $nombre_admin ?></span></div>
            <div id="name"><span>Id: <?php echo $id_admin ?></span></div>
        </div>

        <!-- ITEMS -->
        <div id="menu-items">

            <div class="item">
                <a href="./admin_menu.php">
                    <div class="icon"><img src="../images/home.png" alt=""></div>
                    <div class="title"><span>Menú Principal</span></div>

                </a>
            </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="admin_edition_client.php">
                    <div class="icon"><img src="../images/edit_user.png" alt=""></div>
                    <div class="title"><span>Editar usuario</span></div>

                </a>
            </div>

            <!-- SEPARADOR -->
            <div class="item separator">
            </div>

            <div class="item">
                <a href="admin_delete_user.php">
                    <div class="icon"><img src="../images/delete_user.png" alt=""></div>
                    <div class="title"><span>Eliminar usuario</span></div>

                </a>
            </div>

            <!-- SEPARADOR -->
            <div class="item separator">
            </div>

            <div class="item">
                <a href="admin_create_user.php">
                    <div class="icon"><img src="../images/add-admin.png" alt=""></div>
                    <div class="title"><span>Creación de usuarios</span></div>

                </a>
            </div>

            <!-- SEPARADOR -->
            <div class="item separator">
                </div>

            <div class="item">
                <a href="../logic/cerrar_sesion.php">
                    <div class="icon"><img src="../images/cerrar-sesion.png" alt=""></div>
                    <div class="title"><span>Cerrar Sesión</span></div>
                </a>
            </div>


        </div>

        <!--
            =================================
            BOTON DE CARGA SUPERIOR
            =================================
        -->
        <div class="footer">
            <a href="#">
                <div class="btn_carga"><img src="../images/pages_up.png" alt=""></div>
            </a>
        </div>

    </div>
</div>


<!-- INICIO DE CONTENEDOR DE USUARIO SELECCIONADO -->
<div class="contenedor_form_agregar card-group py-2">

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
                $data=[];
                while($row = mysqli_fetch_assoc($result)){
                    $Id_editar = $row['Cedula_U'];
                    $data[] = $row;
                }
                $mostrar = $data[0];
                //print_r($mostrar);
            ?>
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre_U'] ?></h5>
            <form>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cedula</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo $mostrar['Cedula_U'];?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                    <input type="text"  disabled class="form-control" value=<?php echo '"'.$mostrar['Nombre_U'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Correo</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Correo'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Departamento</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Departamento'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Facultad</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Facultad'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">TipoUsuario</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo $mostrar['TipoUsuario'];?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Login</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Login'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Contraseña</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo $mostrar['Contrasena'];?>>
                    </div>
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
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cedula</label>
                    <div class="col-sm-10">
                    <input type="text" name="cedula_usuario_edt" class="form-control" min="4" max="40" placeholder="cedula" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                    <input type="text" name="nombre_usuario_edt" class="form-control" min="4" max="40" placeholder="nombre" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Correo</label>
                    <div class="col-sm-10">
                    <input type="email" name="correo_usuario_edt" class="form-control" min="4" max="40" placeholder="correo" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Departamento</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="departamento_usuario_edt" required>
                            <option value="">Seleccione</option>
                            <?php 
                                //Consultar en la tabla dependencias, los departamentos de forma unica 
                                $sql = "SELECT DISTINCT Departamento FROM dependencias";
                                $result = $conectar->query($sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    echo '<option value="'.$row['Departamento'].'">'.$row['Departamento'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Facultad</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="facultad_usuario_edt" required>
                            <option value="">Seleccione</option>
                            <?php 
                                //Consultar en la tabla dependencias, los departamentos de forma unica 
                                $sql = "SELECT DISTINCT Facultad FROM dependencias";
                                $result = $conectar->query($sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    echo '<option value="'.$row['Facultad'].'">'.$row['Facultad'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">TipoUsuario</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="tipo_usuario_edt" required>
                                <option value="">Seleccione</option>
                                <option value="admin">ADMIN</option>
                                <option value="consulta">CONSULTA</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Login</label>
                    <div class="col-sm-10">
                    <input type="text" name="login_usuario_edt" class="form-control" min="4" max="40" placeholder="login" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Contraseña</label>
                    <div class="col-sm-10">
                    <input type="text" name="contrasena_usuario_edt" class="form-control" min="4" max="40" placeholder="contraseña" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Modificar</button> 
            </form>

        </div>
        
    </div>

</div>


<!-- SCRIPTS DE PARTICULAS Y DEL MENU LATERAL -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="../js/app.js"></script>

<!-- LOCAL: JQuery, AJAX, Bootstrap -->
<script src="../bootstrap-4.4.1-dist/js/jquery-3.6.1.min.js"></script>
<script src="../bootstrap-4.4.1-dist/js/popper-1.16.0.min.js"></script>
<script src="../bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>


</body>
</html>
