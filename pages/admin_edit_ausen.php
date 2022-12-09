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
                $sqli   = "SELECT ausentismos.*, funcionarios.*, dependencias.ID as ID_depen, dependencias.C_costo as C_costo, dependencias.Departamento as Departamento, dependencias.Facultad as Facultad
                            FROM ausentismos 
                            INNER JOIN funcionarios On funcionarios.Cedula=ausentismos.Cedula_F
                            INNER JOIN dependencias ON funcionarios.Dependencia=dependencias.ID
                            WHERE ausentismos.ID = $id_ausen";
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
                    <label for="staticEmail" class="col-sm-2 col-form-label">Fecha Inicio</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Fecha_Inicio'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Fecha Fin</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Fecha_Fin'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Tiempo</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Tiempo'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Unidad</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo $mostrar['Unidad'];?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Observacion</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Observacion'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Costo</label>
                    <div class="col-sm-10">
                    <input type="text" readonly disabled class="form-control" id="staticEmail" value=<?php echo '"'.$mostrar['Seguridad_Trabajo'].'"';?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Tipo Ausentismo</label>
                    <div class="col-sm-10">
                        <?php
                            //if ($mostrar['Tipo_Ausentismo'] == 1) then echo the input with the value INCAPACIDAD, if ==2 then echo the input with the value LICENCIA
                            

                            $sqli = "SELECT * FROM tipoausentismo";
                            $tipoAusentismos = $conectar->query($sqli);  //print_r($ausentismos);
                    
                            $ausen_list = [];
                    
                            while($tipo = $tipoAusentismos->fetch_assoc()){
                                //$ausen_list[$tipo["ID"]]=$tipo;
                                $ID = $tipo["ID"];
                                $Nombre=$tipo["TipoAusentismo"];
                                /*<?php echo "\""."type_".$ID."\""; ?> --> "type_1"  */
                                if($ID == $mostrar['Tipo_Ausentismo'] ){
                                    echo "<input type='text' readonly disabled class='form-control' id='staticEmail' value=\"$Nombre\" >";
                                }
                            }
                        ?>
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

            <form action="../logic/form_ausen_editLogic.php?ID=<?php echo $Id_editar ?>" method="POST">

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Cedula</label>
                    <div class="col-sm-10">
                        <input type="text" readonly disabled name="cedula_ausen_edt" class="form-control" min="4" max="40" placeholder="cedula" value="<?php echo $mostrar['Cedula'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"> Nombre </label>
                    <div class="col-sm-10">
                        <input type="text" readonly disabled name="nombre_ausen_edt" class="form-control" min="4" max="40" placeholder="nombre" value="<?php echo $mostrar['Nombre'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"> Fecha Inicio </label>
                    <div class="col-sm-10">
                        <input type="date" name="fechaI_ausen_edt" class="form-control"  placeholder="Fecha" value="<?php echo $mostrar['Fecha_Inicio'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"> Fecha Fin </label>
                    <div class="col-sm-10">
                        <input type="date" name="fechaF_ausen_edt" class="form-control"  placeholder="Fecha" value="<?php echo $mostrar['Fecha_Fin'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"> Tiempo </label>
                    <div class="col-sm-10">
                        <input type="number" name="tiempo_ausen_edt" class="form-control"  placeholder="Tiempo" value="<?php echo $mostrar['Tiempo'];?>" min="1" max="200" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Unidad</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="unidad_ausen_edt" required>
                                <option value="">Seleccione</option>
                                <option value="dias" <?php if($mostrar['Unidad'] == 'dias'){echo 'selected';}?> > dias </option>
                                <option value="horas" <?php if($mostrar['Unidad'] == 'horas'){echo 'selected';}?> > horas </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"> Observacion </label>
                    <div class="col-sm-10">
                        <input type="text" name="obser_ausen_edt" class="form-control"  placeholder="cargo" value="<?php echo $mostrar['Observacion'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"> Costo </label>
                    <div class="col-sm-10">
                        <input type="number" name="costo_ausen_edt" class="form-control"  placeholder="cargo" value="<?php echo $mostrar['Seguridad_Trabajo'];?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label"> Tipo Ausentismo </label>
                    <div class="col-sm-10">
                        <select class="form-select form-select-sm" required name="tipo_ausen_edt" id="tipo_ausen">
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
                                        if($ID == $mostrar['Tipo_Ausentismo'] ){
                                            echo "<option value=\"$ID\" selected> $Nombre </option>";
                                        }else{
                                            echo "<option value=\"$ID\" > $Nombre </option>";
                                        }
                                
                                    }
                                ?>
                        </select>
                    </div>
                </div>


                <button type="submit" class="btn btn-success"> Modificar </button> 
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