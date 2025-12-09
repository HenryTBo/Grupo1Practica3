<?php
    include_once __DIR__. '/../layout.php';

?>

<!DOCTYPE html>
<html lang="en">

    <?php 
    showCss()
    ?>
    <link href="../css/imagenes.css" rel="stylesheet" />
    <body id="page-top">
        <?php 
        showNavBar()
        ?>

        <?php 
        showHeader()
        ?>
        <section class="page-section" id="opciones">
            <div class="container text-center">

                <h2 class="text-uppercase text-secondary mb-4">
                    ¡Bienvenido al Sistema!
                </h2>
                <p class="mb-5 fs-5">
                    Seleccione una opción:
                </p>

                <div class="row justify-content-center">

     
                    <div class="col-md-6 mb-4">
                        <a href="../Modulos/registro.php">
                            <div class="img-box">
                                <img src="../img/registro.png" alt="Registro">
                            </div>
                        </a>
                        <h4 class="mt-3 text-secondary">Registro</h4>
                    </div>


                    <div class="col-md-6 mb-4">
                        <a href="../Modulos/consulta.php">
                            <div class="img-box">
                                <img src="../img/consulta.png" alt="Consulta">
                            </div>
                        </a>
                        <h4 class="mt-3 text-secondary">Consulta</h4>
                    </div>

                </div>
            </div>
        </section>

        <?php
        showJs()
        ?>  

    </body>
</html>