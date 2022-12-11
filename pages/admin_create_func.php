<?php
include "../template/cabecera.php";
?>


<!-- CONTENEDOR DE FORMULARIO -->
<div class="content">
    <div class="row py-3">   

        <div class="card mx-auto" style="width: 30rem; overflow-y: auto; height:85vh;">
            <div class="card-header">
            REGISTRO DE FUNCIONARIO
            </div>
            <div class="card-body">            
                <form action="../logic/admin_create_funcLogic.php" method="POST" class="form" name="formulario">
                    <!-- INPUT DE NOMBRES DE FUNCIONARIO -->
                    <div class="form-floating mb-3">
                        <input type="text" name="nomb_func" class="form-control" placeholder="Digite los nombres y apellidos" required>
                        <label class="col-form-label" for="nomb_func"> Nombres y Apellidos </label>
                    </div>
                    
                    <!-- INPUT DEL NUMERO DE IDENTIFICACION -->
                    <div class="form-floating mb-3">
                        <input type="number" name="numero_id" class="form-control" placeholder="Número de identificación" pattern="[0-9]{5,15}" title="La identifiación solo debe contener carácteres numéricos. Entre 5 y 15." required>
                        <label class="col-form-label" for="numero_id"> Número de identificación </label>
                    </div>

                    <!-- INPUT DEL CARGO-->
                    <div class="form-floating mb-3">
                        <input type="text" name="cargo" class="form-control" placeholder="Digite el cargo" required>
                        <label class="col-form-label" for="cargo"> Cargo </label>
                    </div>

                    <!-- INPUT DE LA DEPENDENCIA -->
                    <div class="form-floating mb-3">
                        <select class="form-control" name="dependencia">
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
                                    }
                                }
                            ?>
                        </select>
                        <label class="col-form-label" for="dependencia"> Dependencia </label>
                    </div>

                    <!-- INPUT DEL GENERO -->
                    <div class="form-floating mb-3">
                        <select class="form-control" name="genero">
                            <option value="">Seleccione</option>
                            <option value="MAS">Masculino</option>
                            <option value="FEM">Femenino</option>
                        </select>
                        <label class="col-form-label" for="genero"> Género </label>
                    </div>
                    
                    <!-- INPUT DEL SALARIO -->
                    <div class="form-floating mb-3">
                        <input type="number" name="salario" class="form-control" pattern="[0-9]{5,8}" placeholder="Digite el salario" required>
                        <label class="col-form-label" for="salario"> Salario </label>
                    </div>

                    <div class="container">
                        <button type="submit" class="btn btn-primary">REGISTRAR</button>
                    </div>

                </form>
            </div>
            
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

</body>
</html>