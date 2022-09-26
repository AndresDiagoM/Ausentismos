<?php

    // ========================
    //SECCION DE SEGURIDAD
    //=========================
    include "../conexion.php";

    session_start();
    $bandera = false;
    $bandera2 = false;

    // INFORMACION DE LA SESSION
    $autentication      = $_SESSION['TIPO_USUARIO'];
    $tipo_cliente       = $_SESSION['TIPO_USUARIO'];
    $numero_id          = $_SESSION['ID_USUARIO'];


    // INFORMACION DEL FORMULARIO
    $ubi_db     =   strtoupper($_POST['ubi_db']);
    $tel_db     =   strtoupper($_POST['tel_db']);
    $tipo_plan  =   strtoupper($_POST['plan']);



    // VERIFICACION DE INICIO DE SESION
    if ($autentication == 'Cliente'){
        $bandera = true;

        $consulta_id = "SELECT * FROM biodigestor WHERE ID_USUARIO = '$numero_id'";
        $verificar_id =  mysqli_query($conectar, $consulta_id);

        // VERIFICACION DE EXISTENCIA O NO DE UN PLAN
        if(mysqli_num_rows($verificar_id) > 5){
            echo "<script>
                alert('ERROR, ya se ha adquirido el maximo0 de suscripciones. Favor cancele una en el MENU DE USUARIO');
                location.href = '../index.php';
            </script>";

        // SI EN LA BASE DE DATOS NO SE ENCUENTRA REGISTRADO UN PLAN, REALIZA EL REGISTRO
        }else{
            
            $registro_compra = "INSERT INTO biodigestor (ID_USUARIO,UBICACION,TEL_CONTACTO, TIPO_PLAN, ESTADO) VALUES ('$numero_id','$ubi_db', '$tel_db', '$tipo_plan', 'ACTIVO')";
            $prueba = mysqli_query($conectar, $registro_compra);
            
            $ULTIMO = "SELECT ID_BIODIGESTOR FROM biodigestor ORDER BY ID_BIODIGESTOR DESC LIMIT 1 ";
            $prueba_ultimo = mysqli_query($conectar, $ULTIMO);
            $mostrar = mysqli_fetch_array($prueba_ultimo);
            //echo "ULTIMO===".$mostrar[0];
            
            //echo "ULTIMO===".$prueba_ultimo;
            
            if($prueba){
                
                $registro_dt_mx = "INSERT INTO datos_maximos (ID_BIODIGESTOR,TEMP_MAX,TEMP_MIN, HUMEDAD_MAX, HUMEDAD_MIN) VALUES ('$mostrar[0]', 40, 25, 60, 40)";
                $prueba2 = mysqli_query($conectar, $registro_dt_mx);
                
                $registro_EST_RELE = "INSERT INTO estado_rele (id, estado) VALUES ('$mostrar[0]', 0)";
                $prueba3 = mysqli_query($conectar, $registro_EST_RELE);

                echo "<script>
                    alert('Compra realizada EXITOSAMENTE');
                    location.href='../index.php';
                </script>";
            }
            else{
                echo "<script>
                    alert('ERROR. No se ha podido completar la compra');
                    location.href = '../index.php';
                </script>";
            }

        }

    }
    else{
        header('Location: ../pages/inicio_sesion.php?message=3');
    }


?>