<?php
//MENU DEL ADMIN, CON DASHBOARD
include "../conexion.php";
include "../logic/admin_securityLogic.php";

// Inicio o reanudacion de una sesion
$nombre_admin   = $_SESSION['NOM_USUARIO'];
$id_admin       = $_SESSION['ID_USUARIO'];
$tipo_usuario   = $_SESSION['TIPO_USUARIO'];

$tabla1 ="";
$tabla2 ="";
$tabla3 ="";
//Cuando se presiona el boton de cargar
if(isset($_POST['accion']) and isset($_FILES['excelFile'])){
    //echo 'BOTON: '.$_POST['accion'];
    //echo ($_FILES['excelFile']['name']!="");
    include "../logic/cargarFuncionarios.php";

    //mostrar una tabla si los arreglos no están vacios
    $tabla1 ="";
    $tabla2 ="";
    $tabla3 ="";
    if($funcionariosExistentes!=null){
        $tabla1 .= "<table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col'  colspan='3'>Funcionarios que ya existen</th>
                        </tr>
                        <tr>
                            <th scope='col'>Cedula</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach($funcionariosExistentes as $funcionario){
            $tabla1 .= "<tr>
                            <th scope='row'>".$funcionario['CEDULA']."</th>
                            <td>".$funcionario['NOMBRE']."</td>
                            <td>".$funcionario['NOMBRE_DEL_CARGO']."</td>
                        </tr>";
        }
        $tabla1 .= "</tbody>
                </table>";
    }
    if($funcionariosInsertados!=null){
        $tabla2 .= "<table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col'  colspan='3'>Funcionarios que se insertaron</th>
                        </tr>
                        <tr>
                            <th scope='col'>Cedula</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach($funcionariosInsertados as $funcionario){
            $tabla2 .= "<tr>
                            <th scope='row'>1".$funcionario['CEDULA']."</th>
                            <td>".$funcionario['NOMBRE']."</td>
                            <td>".$funcionario['NOMBRE_DEL_CARGO']."</td>
                        </tr>";
        }
        $tabla2 .= "</tbody>
                </table>";
    }
    if($funcionariosNoInsertados!=null){
        $tabla3 .= "<table class='table table-striped table-bordered table-hover table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col'  colspan='3'>Funcionarios que no se insertaron</th>
                        </tr>
                        <tr>
                            <th scope='col'>Cedula</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach($funcionariosNoInsertados as $funcionario){
            $tabla3 .= "<tr>
                            <th scope='row'>".$funcionario['CEDULA']."</th>
                            <td>".$funcionario['NOMBRE']."</td>
                            <td>".$funcionario['NOMBRE_DEL_CARGO']."</td>
                        </tr>";
        }
        $tabla3 .= "</tbody>
                </table>";
    }
}
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
    <!-- <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400;1,500;1,900&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script> -->
    <link rel="icon" href="../images/icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">

    <!-- Bootstrap 4 CSS -->
    <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../bootstrap-4.4.1-dist/css/bootstrap.min.css">

    <!-- ICONOS en https://ionic.io/ionicons/v4/usage#md-pricetag -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    

    <title>Admin</title>
</head>

<body>

    <div id="particles-js"></div>
    <!-- CABECERA DE TRABAJO -->
    <header>
        <div class="contenedor_principal">
            <div class="contenedor_logo">
                <a href="admin_menu.php"><img id="imagen_logo" src="../images/logo.png" alt="Error al cargar la imagen"></a>
            </div>
            
        </div>
    </header>


    <!-- INICIO DE SLIDE MENU -->
    <div class="contenedor_pr_menu">
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
                    <a href="admin_menu.php">
                        <div class="icon"><img src="../images/home.png" alt=""></div>
                        <div class="title"><span>Menú Principal</span></div>
                    </a>
                </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

                <div class="item">
                    <a href="#">
                        <div class="icon"><img src="../images/upload.png" alt=""></div>
                        <div class="title"><span>Cargar Datos</span></div>
                    </a>
                </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

                <div class="item">
                    <a href="admin_agregar.php">
                        <div class="icon"><img src="../images/add.png" alt=""></div>
                        <div class="title"><span>Agregar Registro</span></div>
                    </a>
                </div>
                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

                <div class="item">
                    <a href="admin_consultar.php">
                        <div class="icon"><img src="../images/stadistics.png" alt=""></div>
                        <div class="title"><span>Consultar Ausentismos</span></div>
                    </a>
                </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

                <div class="item">
                    <a href="admin_edition_client.php">
                        <div class="icon"><img src="../images/users_admin.png" alt=""></div>
                        <div class="title"><span>Gestionar Usuario</span></div>
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


    <!-- Contenerdor del contenido de la página-->
    <div class="contenedor_tabla2" >
        <!-- Contenerdor de cards-->
        <section class="bg-gray">

            <div class="container">
                <div class="row">
                    <!-- CARD DE CARGAR FUNCIONARIOS -->                    
                    <div class="col-lg-6 my-3">

                        <div class="card rounded-0 ">
                            <div class="d-flex card-header bg-light ">
                                <h6 class="font-weight-bold mb-0 mr-3">Cargar Funcionarios </h6>                                
                            </div>
                            
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="file" class="form-control mb-3" name="excelFile" required id="excelFile" placeholder="Imagen">
                                    <!--- input type file that just allows excel files -->

                                    <div class="btn-group" role="group" aria-label="">
                                        <button type="submit" name="accion"  value="CARGAR" class="btn btn-success">CARGAR</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </section>
    
        <?php
        if($tabla1 != null){          
        ?>
        <section>
            <!-- Contenedor de tabla -->
            <div class="container " style="overflow-y:auto; height:600px; position:absolute">
                <?php 
                    echo $tabla1;
                    if($tabla2 != null){
                        echo $tabla2;
                    }
                    if($tabla3 != null){
                        echo $tabla3;
                    }
                ?>
            </div>
        </section>
        <?php
        }
        ?>
    </div>



    <!-- SCRIPT DE PARTICULAS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script> -->
    <script src="../js/particles.min.js"></script>
    <script src="../js/app.js"></script>

    <!-- CDN: Libreria de chart.js para las gráficas -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js" integrity="sha256-+8RZJua0aEWg+QVVKg4LEzEEm/8RFez5Tb4JBNiV5xA=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

    <!-- LOCAL: JQuery, AJAX, Bootstrap 
    <script src="../bootstrap-4.4.1-dist/js/jquery-3.6.1.min.js"></script> -->     
    <script src="../bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>

</body>
</html>