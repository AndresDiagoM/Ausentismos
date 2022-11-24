<?php
//MENU DEL ADMIN, CON DASHBOARD
include "../conexion.php";

session_start();
$autentication = $_SESSION['TIPO_USUARIO'];
if($autentication == '' || $autentication == null || $autentication == 'CONSULTA'){
    //header('Location: ../pages/inicio_sesion.php?message=3');
    echo "<script> alert('Sin permisos'); location.href = '../pages/inicio_sesion.php?message=3';  </script>";    
}

// Inicio o reanudacion de una sesion
$nombre_admin   = $_SESSION['NOM_USUARIO'];
$id_admin       = $_SESSION['ID_USUARIO'];
$tipo_usuario   = $_SESSION['TIPO_USUARIO'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap-5.2.2-dist/css/bootstrap.min.css" /> 

    <!-- CSS -->
    <link href="../css/estilo.css" rel="stylesheet" integrity="" crossorigin="anonymous">

    <!-- ICONOS en https://ionic.io/ionicons/v4/usage#md-pricetag -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <title>Admin</title>
</head>

<body>
    <div class="d-flex">

    <!-- SIDE BAR - menu lateral -->
    <div id="sidebar-container" class="bg-primary">
        <div class="logo" >
            <h4 class="text-light font-weight-bold"> GESTION DE AUSENTISMOS </h4>
        </div>

        <div class="menu">
            
            <!-- <a href="../pages/facultad_edition_client.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-people mr-2 lead"></i> GESTIONAR USUARIO</a> -->
            <a href="../logic/cerrar_sesion.php" class="p-3 text-light d-block text-decoration-none"> 
                <i class="icon ion-md-log-out mr-2 lead"></i> CERRAR CESION</a>
        </div>
    </div>

    <div class="w-100">

        <!-- NAV BAR - menu en la parte superior -->
        <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../pages/facultad_agregar.php"> <i class="icon ion-md-home me-2 lead"></i> </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="d-flex justify-content-end " id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../images/user_profile.png" class="img-fluid rounded-circle avatar mr-2" />
                            <?php //echo de las 2 primeras palabras del nombre
                                $nombre = explode(" ", $nombre_admin);
                                //si tiene mas de 2 palabras, imprime las 2 primeras
                                if (count($nombre) > 1) {
                                    echo $nombre[0] . " " . $nombre[1];
                                } elseif(count($nombre) == 1) {
                                    echo $nombre[0];
                                }else{
                                    echo "Usuario";
                                }
                                //echo $nombre[0]." ".$nombre[2];
                            ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href=<?php echo '../pages/admin_form_edition.php?ID='.$id_admin.''; ?>>Mi perfil </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../logic/cerrar_sesion.php">Cerrar Sesion</a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
        </nav>


<!-- Contenerdor de bienvenida y boton de reporte-->
<section class="py-2">
        <!-- py-3 es padding en y, como <br> -->
        <div class="container-fluid">
            <div class="row">
                <!-- con 2 columnas -->

                <div class="col-lg-9">
                    <h1 class="font-weight-bold mb-0">Registro de Permiso por horas</h1> <!-- mb-0 es sin margen inferior -->
                    
                </div>
                

            </div>
        </div>
    </section>

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

    </form>
</div>


<!-- ESPACIO PARA EL FORMULARIO -->
<div class="container  card-group" style="overflow-y: auto; height:65vh;">    
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
                    <input type="text" name="Cedula_F[]" class="form-control" id="cedula" placeholder="Número de identificación"  title="La identifiación solo debe contener carácteres numéricos" required>
                    <label class="col-form-label" for="Cedula[]"> CÉDULA </label>
                </div>

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
                    <input type="number" name="Tiempo[]" class="form-control" id="tiempo" placeholder="Tiempo del ausentimso" min="1" max="200" required>
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
                                if($ID == 5){
                                    echo "<option value=\"$ID\">$Nombre</option>";
                                }else{
                                    //echo "<option value=\"$ID\">$Nombre</option>";
                                }
                        
                            }
                        ?>
                    </select>
                    <label class="col-form-label" for="Tipo_Ausentismo[]">TIPO DE AUSENTIMO</label>
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

</body>
</html>