<?php
include "../logic/admin_securityLogic.php"; // Verifica que el usuario sea administrador
include "../template/cabecera.php";
?>


    <div class="row ms-1">
            <!-- CONTENEDORES DE BUSQUEDAS -->
            <div class="container row col-3 py-2">
                <form class="row" id="auto_llenar">
                    <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" pattern="[a-zA-Z0-9\s]+" size="50" placeholder="Ingrese el ID que desea buscar">
                            <label class="col-form-label" for="caja_busqueda">Buscar cedula: </label>
                    </div>
                </form>
            </div>
            
            <!-- Contenedor del boton de nuevo usuario -->
            <div class="container row col-2 ms-1 py-3">
                <a href="../pages/admin_create_user.php">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Crear Usuario
                    </button>
                </a>
            </div>
    </div>

    <!-- Contenedor de la tabla de usuarios -->
    <div class="container py-4" style="overflow-x: auto; overflow-y: auto; height:70vh; font-size:14px" id="datos">

    </div>


</div> <!-- fin de la clase w-100-->
</div> <!-- fin de la clase d-flex -->

    <!-- Bootstrap core JavaScript -->
    <script src="../assets/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../bootstrap-5.2.2-dist/js/bootstrap.min.js"></script> -->
    <script src="../assets/bootstrap-5.2.2-dist/js/popper.min.js"></script>

    <!-- APP JS CONTIENE  FUNCIONES PARA LOS GRÁFICOS -->
    <script src="../js/app1.js"></script>
    <!-- INSTALACION DE JQUERY -->
    <script src="../js/jquery.min.js"></script> 

    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="../js/sweetalert2-11.6.15/package/dist/sweetalert2.min.js"></script>
    <script src="../js/sweet_alert.js"></script>

    <!--    JAVASCRIPT QUE REALIZA LA BUSQUEDA DINAMICA -->
    <script src="../js/search_usuario_edit.js"></script>


<?php
    include("../template/pie.php");
?>