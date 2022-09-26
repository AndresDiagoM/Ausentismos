<?php

    include '../conexion.php';
    include '../logic/client_securityLogic.php';

    // Validacion de inicio de session
    $nombre_cliente     = $_SESSION['NOM_USUARIO'];
    $id_cliente         = $_SESSION['ID_USUARIO'];
    $tipo_usuario       = $_SESSION['TIPO_USUARIO'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" href="../css/style_client.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_client_alarmas.css">
    <link rel="stylesheet" href="../css/style_client_suscription.css">
    <link rel="stylesheet" href="../css/style_collapsed_menu.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400;1,500;1,900&family=Lobster&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b50f20f4b1.js" crossorigin="anonymous"></script>
    <title>Alertas del Sistema</title>
</head>
<body>

<!-- CONTENEDOR DE PARTICULAS -->
<div id="particles-js"></div>

<!-- CABECERA DE TRABAJO -->
<header>

    <div class="contenedor_principal">
        <div class="contenedor_logo">
            <a href="../index.php"><img id="imagen_logo" src="../images/logo.png" alt="Error al cargar la imagen"></a>
        </div>
        <div class="contenedor_nombre_clt">
            <span> ALERTAS DEL USUARIO </span>

        </div>
        <div class="contenedor_clt">
            Nombre de usuario:
            <span class="info_clt">
                <?php
                    echo " $nombre_cliente";
                ?>
            </span><br>
            <span>
                ID usuario:
            </span>
            <span class="info_clt">
                <?php
                    echo " $id_cliente";
                ?>
            </span><br>
                Tipo de usuario:
            <span>
                <?php
                    echo $tipo_usuario;
                ?>
            </span>


            <div class="contenedor_cerrar_sesion" >
                <a href="../logic/cerrar_sesion.php"><button class="btn-cierre-sesion">Cerrar Sesión</button></a>
            </div>
        </div>
    </div>
</header>
<!-- INICIO DE SLIDE MENU -->
<div class = "contenedor_pr_menu">
    <div id="slide-menu" class="menu-collapsed">

        <!-- HEADER -->
        <div id="header">

            <div id="menu-btn">
                <div class="btn-logo"></div>
                <div class="btn-logo"></div>
                <div class="btn-logo"></div>
            </div>
            <div id="title"><span>PERFIL</span></div>
        </div>

        <!-- PROFILE -->
        <div id="profile">
            <div id="photo"><img src="../images/profile2.png" alt=""></div>
            <div id="name"><span>Nombre: <?php echo $nombre_cliente ?></span></div>
            <div id="name"><span>Id: <?php echo $id_cliente ?></span></div>
        </div>

        <!-- ITEMS -->
        <div id="menu-items">

            <div class="item">
                <a href="client_menu.php">
                    <div class="icon"><img src="../images/home.png" alt="Error al cargar imagen"></div>
                    <div class="title"><span>Menú Principal</span></div>

                </a>
            </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="client_estadisticas.php">
                    <div class="icon"><img src="../images/stadistics.png" alt="Error al cargar imagen"></div>
                    <div class="title"><span>Estadísticas</span></div>

                </a>
            </div>

             <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="client_alertas.php">
                    <div class="icon"><img src="../images/alert.png" alt="Error al cargar imagen"></div>
                    <div class="title"><span>Alertas</span></div>

                </a>
            </div>

                <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="client_suscription.php">
                    <div class="icon"><img src="../images/subscription.png" alt="Error al cargar imagen"></div>
                    <div class="title"><span>Suscripciones</span></div>

                </a>
            </div>
            
            <!-- SEPARADOR -->
                <div class="item separator">
                </div>

            <div class="item">
                <a href="client_rango_alertas.php">
                    <div class="icon"><img src="../images/meter.png" alt=""></div>
                    <div class="title"><span>Rango de medición</span></div>
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



<!-- BARRA DE NAVEGACION -->
<div class="contenedor_menu">
    <div class="contenedor_listas">
        <ul>
            <a href="../index.php"><li class="btn-inicio-go_home">Menú Principal</li></a>
            <a href="suscription.php"><li>Suscripciones<i class="fa fa-angle-down"></i></a>
                <ul>
                    <a href="compras.php?suscp=Prem"><li> Premiun</li></a>
                    <a href="compras.php?suscp=Basic"><li> Básico</li></a>
                </ul>
            </li>
            <a href="quienes_somos.php"><li class="btn-inicio-go_catalogo">¿Quiénes somos?</li></a>
            <a href="client_menu.php"><li class="btn-inicio-go_catalogo">Menú del Usuario</li></a>

        </ul>
    </div>
</div>

<!-- CONTENEDOR TITULO -->
<div class="contenedor_titulo_alarmas">
    <h2>ALERTAS DE TEMPERATURA Y HUMEDAD</h2>
</div>
<div class="contenedor_alertas">
    <table class="users_table2">

        <!-- CONSULTA SQL QUE DETERMINA LA EXISTENCIA DE ALERTAS -->
        <?php
            $sql1 = "SELECT * FROM datos_medidos INNER JOIN biodigestor
            ON datos_medidos.ID_BIODIGESTOR = biodigestor.ID_BIODIGESTOR  WHERE biodigestor.ID_USUARIO  = $id_cliente";
            $result1 = mysqli_query($conectar, $sql1);
            if(mysqli_num_rows($result1)>0){


        ?>
        <tr>
            <th>ID ALARMA</th>
            <th>BIODIGESTOR</th>
            <th>TEMPERATURA (°C)</th>
            <th>HUMEDAD (%)</th>
            <th>FECHA DE LECTURA</th>
            <th>HORA DE LECTURA</th>
            <th>NIVEL DE GAS</th>
            <th>PRESION DE GAS</th>
            <th>ESTADO DE RELE</th>
            <th>ALARMA DE TEMPERATURA</th>
            <th>ALARMA DE HUMEDAD</th>
        </tr>
        <?php
            //$sql5 = "SELECT COUNT(DISTINCT ID_BIODIGESTOR) from biodigestor where ID_USUARIO='$id_cliente'";
            $sql5 = "SELECT DISTINCT ID_BIODIGESTOR from biodigestor where ID_USUARIO=$id_cliente";
            $result5 = mysqli_query($conectar, $sql5);
            while($mostrar5 = mysqli_fetch_array($result5)){//echo "MOSTRAR===".$mostrar5[0];
                
            
            
        
            $sql2 = "SELECT * FROM datos_medidos INNER JOIN biodigestor
            ON datos_medidos.ID_BIODIGESTOR = biodigestor.ID_BIODIGESTOR INNER JOIN datos_maximos
            ON datos_maximos.ID_BIODIGESTOR = biodigestor.ID_BIODIGESTOR INNER JOIN estado_rele
            ON estado_rele.id = biodigestor.ID_BIODIGESTOR
            WHERE ( biodigestor.ID_USUARIO = $id_cliente and datos_medidos.ID_BIODIGESTOR=$mostrar5[0]) ORDER BY ID_ALARMA DESC LIMIT 1";
            $result2 = mysqli_query($conectar, $sql2);
            while($mostrar = mysqli_fetch_array($result2)){



        ?>
        <tr>
            <td><?php echo $mostrar['ID_ALARMA'] ?></td>
            <td><?php echo $mostrar['UBICACION']?> (<?php echo $mostrar['ID_BIODIGESTOR']?> )</td>
            <td><?php echo $mostrar['TEMPERATURA']?></td>
            <td><?php echo $mostrar['HUMEDAD']?></td>
            <td><?php echo $mostrar['FECHA_LECTURA']?></td>
            <td><?php echo $mostrar['HORA_LECTURA']?></td>
            <td><?php echo $mostrar['NIVEL_GAS']?></td>
            <td><?php echo $mostrar['PRESION_GAS']?></td>

            <?php
                $id_bd          = $mostrar['ID_BIODIGESTOR'];
                $id_alarma      = $mostrar['ID_ALARMA'];
                $estado_rele    = $mostrar['estado'];
                $estado_temp    = $mostrar['TEMPERATURA'];
                $estado_hum     = $mostrar['HUMEDAD'];
                $humedad_max    = $mostrar['HUMEDAD_MAX'];
                $humedad_min    = $mostrar['HUMEDAD_MIN'];
                $temp_max       = $mostrar['TEMP_MAX'];
                $temp_min       = $mostrar['TEMP_MIN'];

                // CONDICIONAL PARA DETERMINAR EL ESTADO DEL RELE
                if($estado_rele == 1){
            ?>
            <!-- ACTUALMENTE EL RELE ESTA ACTIVO (1). ES DECIR QUE AL PRESIONAR EL BOTON, SE DEBE APAGAR -->
            <td><a href="../logic/estado_releLogic.php?estado_rele=0&id_bd=<?php echo $id_bd ?>"><img src="../images/power_on.png" alt="Error al cargar la imagen"></a></td>

            <?php
                }else{
            ?>
            <!-- ACTUALMENTE EL RELE ESTA APAGADO (0). ES DECIR QUE AL PRESIONAR EL BOTON, SE DEBE ENCENDER -->
            <td><a href="../logic/estado_releLogic.php?estado_rele=1&id_bd=<?php echo $id_bd?>"><img src="../images/power_off.png" alt="Error al cargar la imagen"></a></td>

            <?php
                }

            ?>


                <!-- CONDICIONAL PARA DETERMINAR LA ALARMA DE TEMPERATURA -->
                <?php
                    if($estado_temp > $temp_max){
                ?>
                        <!-- EL NIVEL DE TEMPERATURA ES SUPERA EL NIVEL ESTABLECIDO -->
                        <td><img src="../images/temperature_alert.png" alt="Error al cargar la imagen"></td>
                <?php
                    }if ($estado_temp < $temp_min){
                ?>
                        <!-- EL NIVEL DE TEMPERATURA ES INFERIOR AL NIVEL ESTABLECIDO -->
                        <td><img src="../images/temperature_alert2.png" alt="Error al cargar la imagen"></td>
                <?php
                    }if ($estado_temp <= $temp_max && $estado_temp >= $temp_min){
                ?>
                        <!-- EL NIVEL DE TEMPERATURA ES INFERIOR AL NIVEL ESTABLECIDO -->
                        <td><img src="../images/accept.png" alt="Error al cargar la imagen"></td>
                <?php
                    }
                ?>
                <!-- CONDICIONAL PARA DETERMINAR LA ALARMA DE HUMEDAD -->
                <?php
                    if($estado_hum > $humedad_max){
                        
                    
                ?>
                        <!-- EL NIVEL DE TEMPERATURA ES SUPERA EL NIVEL ESTABLECIDO -->
                        <td><img src="../images/humedad_alert2.png" alt="Error al cargar la imagen"></td>
                <?php
                    }if ($estado_hum <= $humedad_max && $estado_hum >= $humedad_min){
                        

                ?>
                        <!-- EL NIVEL DE HUMEDAD ESTA ENEL NIVEL ESTABLE -->
                        <td><img src="../images/accept.png" alt="Error al cargar la imagen"></td>
                <?php 
                    }if ($estado_hum < $humedad_min){
                        
                    
                ?>
                        <!-- EL NIVEL DE HUMEDAD ESTA DEBAJO DEL NIVEL ESTABLE -->
                        <td><img src="../images/humedad_alert.png" alt="Error al cargar la imagen"></td>
                <?php
                    }
                ?>




        </tr>
        <!-- CIERRE DE CICLO WHILE QUE RECORRE LA TABLA DE ALERTAS -->
        <?php

            }
            }
        ?>

    </table>
    <?php
        }else{


    ?>
        <h2>NO SE ENCONTRARON ALERTAS REGISTRADAS</h2>
    <?php
        }
    ?>
</div>




<!-- AGREGAR PARTICULAS -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="../js/app.js"></script>

<!-- SCRIPT MENU LATERAL-->
<script>
    const btn = document.querySelector('#menu-btn');
    const menu = document.querySelector('#slide-menu');

    btn.addEventListener('click', e => {
       menu.classList.toggle("menu-expanded");
       menu.classList.toggle("menu-collapsed");

    });
</script>

</body>
</html>