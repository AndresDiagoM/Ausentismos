<?php
include('paginacion.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>

    <header>
        <div class="container">
            <div class="col-md-12">
                <h1>Funcionarios</h1>
            </div>
    </header>

    <!-- TABLA  -->
    <section>
        <table class="table table-striped table-hover">
            <thead>
                <tr class="bg-primary">
                    <th>CEDULA</th>
                    <th>NOMBRE</th>
                    <th>CARGO</th>
                    <th>DEPENDENCIA</th>
                    <th>Facultad</th>
                    <th>Genero</th>
                    <th>Salario</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tabla; ?>
            </tbody>
        </table>

    </section>

    <!--///////////////// SLIDER con paginacion /////////////////////-->
    <div class="container-fluid  col-12">
        <ul class="pagination pg-dark justify-content-center pb-5 pt-5 mb-0" style="float: none;">
            <li class="page-item">
                <?php
                if ($_GET["pag"] == "1") {
                    $_GET["pag"] == "0";
                    echo  "";
                } else {
                    if ($pag > 1)
                        $ant = $_GET["pag"] - 1;
                    echo "<a class='page-link' aria-label='Previous' href='?pag=1'><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a>";
                    echo "<li class='page-item '><a class='page-link' href='?pag=" . ($pag - 1) . "' >" . $ant . "</a></li>";
                }
                echo "<li class='page-item active'><a class='page-link' >" . $_GET["pag"] . "</a></li>";
                $sigui = $_GET["pag"] + 1;
                $ultima = $total / $limit;
                if ($ultima == $_GET["pag"] + 1) {
                    $ultima == "";
                }
                if ($pag < $totalpag && $totalpag > 1)
                    echo "<li class='page-item'><a class='page-link' href='?pag=" . ($pag + 1) . "'>" . $sigui . "</a></li>";
                if ($pag < $totalpag && $totalpag > 1)
                    echo "<li class='page-item'><a class='page-link' aria-label='Next' href='?pag=" . ceil($ultima) . "'><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a>
                                            </li>";
                ?>
        </ul>
    </div>

</body>

</html>