<?php
    include "../template/cabecera.php";
    $id_ausen    = $_GET['ID'];
?>


<!-- INICIO DE CONTENEDOR DE FUNCIONARIO SELECCIONADO -->
<div class="container card-group py-2">

    <div class="card">
        <div class="card-header">
            DATOS ACTUALES
        </div>
        <div class="card-body">
            
            <?php
                $sqli   = "SELECT * FROM ausentismos WHERE ID = $id_ausen";
                $result = $conectar->query($sqli);
                $data=[];
                while($row = mysqli_fetch_assoc($result)){
                    $Id_editar = $row['ID'];
                    $data[] = $row;
                }
                $mostrar = $data[0];
                //print_r($mostrar);
            ?>
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre'] ?></h5>
            <form>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cedula</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo $mostrar['Cedula'];?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                    <input type="text"  disabled class="form-control" value=<?php echo '"'.$mostrar['Nombre'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cargo</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Cargo'].'"';?>>
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
                    <label for="staticEmail" class="col-sm-2 col-form-label">Genero</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo $mostrar['Genero'];?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Salario</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Salario'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Estado</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Estado'].'"';?>>
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
            <h5 class="card-title">Nombre: <?php echo $mostrar['Nombre'] ?></h5>

            <form action="../logic/form_func_editLogic.php?ID=<?php echo $Id_editar ?>" method="POST">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cedula</label>
                    <div class="col-sm-10">
                    <input type="text" name="cedula_func_edt" class="form-control" min="4" max="40" placeholder="cedula" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" name="nombre_func_edt" class="form-control" min="4" max="40" placeholder="nombre" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cargo</label>
                    <div class="col-sm-10">
                        <input type="text" name="cargo_func_edt" class="form-control"  placeholder="cargo" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Departamento</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="departamento_func_edt" required>
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
                        <select class="custom-select" name="facultad_func_edt" required>
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
                    <label for="staticEmail" class="col-sm-2 col-form-label">Genero</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="genero_func_edt" required>
                                <option value="">Seleccione</option>
                                <option value="MAS">Masculino</option>
                                <option value="FEM">Femenino</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Salario</label>
                    <div class="col-sm-10">
                    <input type="number" name="salario_func_edt" class="form-control" min="1" max="100000000" placeholder="salario" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Estado</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="estado_func_edt" required>
                                <option value="">Seleccione</option>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>
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


</body>
</html>