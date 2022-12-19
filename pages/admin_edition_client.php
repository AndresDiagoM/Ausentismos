<?php
include "../template/cabecera.php";

?>

        <!-- CONTENEDORES DE BUSQUEDAS -->
        <div class="container row col-3 py-3">
            <form class="row" id="auto_llenar">
                <div class="form-floating mb-3">
                        <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" size="50" placeholder="Ingrese el ID que desea buscar">
                        <label class="col-form-label" for="caja_busqueda">Buscar: </label>
                </div>
            </form>
        </div>

        <div class="container py-4" style="overflow-y: auto; height:70vh;" id="datos">

        </div>

        <!-- Contenedor del boton de nuevo usuario -->
        <div class="container row col-2 ms-1">
            <a href="../pages/admin_create_user.php">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Crear
                </button>
            </a>
        </div>


</div> <!-- fin de la clase w-100-->
</div> <!-- fin de la clase d-flex -->

    <!-- Bootstrap core JavaScript -->
    <script src="../bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS -->
    <script src="../js/app1.js"></script>
    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

<!--    JAVASCRIPT QUE REALIZA LA BUSQUEDA DINAMICA -->
<script src="../js/search_usuario_edit.js"></script>
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>
<!-- <script src="../js/sweet_alert.js"></script> -->

<?php
//si se recibe la variable por GET ALERT, entonces se muestra el mensaje de alerta
if (isset($_GET["ALERT"])) {
    $alert = $_GET["ALERT"];
    if ($_GET["ALERT"] != "") {
        if ($alert == "success") {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Usuario eliminado!',
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: \"#be3838\",
                    //timer: 1500
                });
            </script>";
        } elseif ($alert == "error") {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: '¡No se pudo eliminar el usuario!',
                    showConfirmButton: true,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: \"#be3838\",
                    //timer: 1500
                });
            </script>";
        }
    }
}
?>

</body>
</html>