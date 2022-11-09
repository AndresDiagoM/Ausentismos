<?php
    //CONSULTAR AUSENTISMOS
    include "../conexion.php";
    include "../logic/admin_securityLogic.php";

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400;1,500;1,900&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script>  -->
    <link rel="icon" href="../images/icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">
    <link rel="stylesheet" href="../css/style_form.css">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../bootstrap-4.4.1-dist/css/bootstrap.min.css">

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
        <div class="contenedor_nombre_adm">
            <span> Agregar Ausentismo </span>            
        </div>
    </div>
</header>

<!-- INICIO DE SLIDE MENU -->
<div class = "contenedor_pr_menu">
    <div id="slide-menu" class="menu-expanded">

        <!-- HEADER 
        <div id="header">

            <div id="menu-btn">
                <div class="btn-logo"></div>
                <div class="btn-logo"></div>
                <div class="btn-logo"></div>
            </div>
            <div id="title"><span>PERFIL</span></div>

        </div>  -->

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
                <a href="admin_cargar.php">
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


<!-- CONTENEDOR DE CUADROS DE BÚSQUEDA -->
<div class="container offset-md-3 col-md-8">
    <br>
    
    <div class="col-md-7">
        <header class="main-header">
            <h4>
                <span class="icon-title">
                    <i class="fas fa-filter"></i>
                </span>
                BUSCAR
            </h4>
        </header>
    </div>
    
    <form class="row" id="auto_llenar">

        <div class="col-3">
                <h6>C&eacute;dula</h6>
                <div class="form-input">
                    <input type="text" class="form-input" id="cedula1" name="Cedula[]" size="20" placeholder="Ingrese la cédula">
                </div>
        </div>

        <div class="col-3">
                <h6>Nombre</h6>
                <div class="form-input">
                    <input type="text" class="form-input" id="nombre1" name="Nombre[]" size="20" placeholder="Ingrese el nombre">
                </div>
        </div>

    </form>
    
    <br>
</div>


<!-- ESPACIO PARA EL FORMULARIO -->
<div class="contenedor_form_agregar card-group">    
        <div class="card"  >
            <div class="card-header">
                Datos del funcionario
            </div>
            <div class="card-body">
                
                <form name="formulario" id="form_register" action="../logic/registrarAusen_form.php" method="POST" >
                    <!-- INPUT DE NOMBRES DE USUARIO -->
                    <div class="form_container">
                        <label for="Nombre[]"> NOMBRE </label>
                        <input type="text" name="Nombre[]" class="input_decor" id="nombre" placeholder="Nombres y apellidos" value="" required>
                        <span class="form_line"></span>
                    </div>

                    <!-- INPUT DE CÉDULA -->
                    <div class="form_container">
                        <div class="form_group">
                            <label for="Cedula[]"> CÉDULA </label>
                            <input type="text" name="Cedula_F[]" class="input_decor" id="cedula" placeholder="Número de identificación"  title="La identifiación solo debe contener carácteres numéricos" required>
                            <span class="form_line"></span>
                        </div>
                    </div>

                    <!-- INPUT DEL cargo -->
                    <div class="form_container">
                        <div class="form_group">
                            <label for="Cargo[]"> CARGO </label>
                            <input type="text" name="Cargo[]" class="input_decor" id="cargo" value="" placeholder="Cargo del funcionario"  required>
                            <span class="form_line"></span>
                        </div>
                    </div>

                    <!-- INPUT DEL departamento -->
                    <div class="form_container">
                        <div class="form_group">
                            <label for="Departamento[]"> DEPARTAMENTO </label>
                            <input type="text" name="Departamento[]" id="departamento" class="input_decor" placeholder="Digite el departamento"  required>
                            <span class="form_line"></span>
                        </div>
                    </div>

                    <!-- INPUT DEL facultad -->
                    <div class="form_container">
                        <div class="form_group">
                            <label for="Facultad[]"> FACULTAD </label>
                            <input type="text" name="Facultad[]" id="facultad" class="input_decor" placeholder="Digite la facultad"  required>
                            <span class="form_line"></span>
                        </div>
                    </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Datos del ausentismo
            </div>
        <div class="card-body">
            
            <!-- INPUT FECHA INICIO -->
            <div class="form_container">
                <div class="form_group">
                    <label for="Fecha_Inicio[]"> FECHA DE INICIO </label>
                    <input type="date" class="input_decor" id="fecha_inicio"  name="Fecha_Inicio[]"  value="" min="2018-01-01"> <!-- //value="2019-07-22" -->
                    <span class="form_line"></span>
                </div>
            </div>

            <!-- INPUT FECHA FIN -->
            <div class="form_container">
                <div class="form_group">
                    <label for="Fecha_Fin[]"> FECHA FIN </label>
                    <input type="date" class="input_decor" id="fecha_fin"  name="Fecha_Fin[]"  value="" min="2018-01-01" > <!-- //value="2019-07-22" -->
                    <span class="form_line"></span>
                </div>
            </div>

            <!-- INPUT DE TIEMPO -->
            <div class="form_container">
                <div class="form_group">
                    <label for="Tiempo[]"> TIEMPO </label>
                    <input type="number" name="Tiempo[]" class="input_decor" id="tiempo" placeholder="Tiempo del ausentimso" min="1" max="200" required>
                    <span class="form_line"></span>
                </div>
            </div>

            <!-- INPUT DE UNIDAD-->
            <div class="form_container">
                <div class="form_group">
                    <label for="Unidad[]"> UNIDAD </label>
                    <select class="input_decor" name="Unidad[]" id="Unidad" required>
                        <option value="">Seleccione</option>
                        <option value="dias"> DIAS </option>
                        <option value="horas"> HORAS </option>
                    </select>
                    <span class="form_line"></span>
                </div>
            </div>

            <!-- INPUT DE LA OBSERVACIÓN -->
            <div class="form_container">
                <div class="form_group">
                    <label for="Observacion[]"> OBSERVACIÓN </label>
                    <input type="text" name="Observacion[]" class="input_decor" id="observacion" placeholder="Observaciones" required>
                    <span class="form_line"></span>
                </div>
            </div>

            <!-- INPUT DEL TIPO DE AUSENTISMO -->
            <div class="form_container" >
                <div class="form-group">
                    <label for="Tipo_Ausentismo[]">TIPO DE AUSENTIMO</label>
                    <select class="input_decor" required name="Tipo_Ausentismo[]" id="tipo_ausen">
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
                </div>
            </div>

            <!-- INPUTS INCAPACIDAD -->
            <div class="form_container mb-3" id="incapacidadINPUTS">
                <div class="form_group">
                    <label for="Codigo[]"> CODIGO </label>
                    <input type="text" name="Codigo[]" class="input_decor" id="codigo" placeholder="Escriba el codigo" required>
                    <span class="form_line"></span>
                </div>
                <div class="form_group">
                    <label for="Diagnostico[]"> DIAGNOSTICO </label>
                    <input type="text" name="Diagnostico[]" class="input_decor" id="diagnostico" placeholder="Escriba el diagnostico" required>
                    <span class="form_line"></span>
                </div>
                <div class="form_group">
                    <label for="Entidad[]"> ENTIDAD </label>
                    <input type="text" name="Entidad[]" class="input_decor" id="entidad" placeholder="Escriba la entidad" required>
                    <span class="form_line"></span>
                </div>
            </div>

            <input type="hidden" name="ID_Usuario[]"  id="id_usuario" value=<?php echo $id_admin; ?> >

            <!-- BOTON DE REGISTRO-->
            <div class="contenedor_guardar">
                <button type="submit" class="btn btn-primary">REGISTRAR</button>
            </div>

            </form>


        </div>
        </div>    
</div>


<!-- SCRIPT DE PARTICULAS -->
<!--<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script> -->
<script src="../js/particles.min.js"></script>
<script src="../js/app.js"></script>
<!-- INSTALACION DE JQUERY -->
<script src="../js/jquery.min.js"></script>


<!-- JQuery, AJAX, Bootstrap -->
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>  -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->

<!-- LOCAL: JQuery, AJAX, Bootstrap -->
<script src="../bootstrap-4.4.1-dist/js/jquery-3.6.1.min.js"></script>
<script src="../bootstrap-4.4.1-dist/js/popper-1.16.0.min.js"></script>
<script src="../bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>

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