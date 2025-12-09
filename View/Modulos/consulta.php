<?php
include_once __DIR__ . '/../layout.php';
include_once __DIR__ . '/../../Controller/consultaController.php';

$consulta = [];

if (isset($_POST['btnConsultar'])) {
    $consulta = ConsultarCompras();
}
?>

<!DOCTYPE html>
<html lang="es">

    <?php showCss(); ?>
    <link href="../css/estilos.css" rel="stylesheet" />

    <body>

    <?php showNavBar(); ?>

    <section class="page-section" id="consulta">
        <div class="container d-flex justify-content-center">
            
            <div class="consulta-wrapper">
                <div class="consulta-top-bar"></div>

                <div class="consulta-inner">

                    <div class="consulta-title-box">
                        <span>Consulta</span>
                    </div>

                    <form method="POST" class="mb-4 text-center">
                        <button type="submit" name="btnConsultar" class="btn btn-primary">
                            Consultar
                        </button>
                    </form>

                    <table class="table table-bordered consulta-table mb-0">
                        <thead>
                            <tr>
                                <th>Código Compra</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Saldo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($consulta)): ?>
                                <?php foreach ($consulta as $fila): ?>
                                    <tr>
                                        <td><?= $fila['IdCompra'] ?></td>
                                        <td><?= $fila['Descripcion'] ?></td>
                                        <td><?= number_format($fila['Precio'], 2) ?></td>
                                        <td><?= number_format($fila['Saldo'], 2) ?></td>
                                        <td><?= $fila['Estado'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No hay registros para mostrar.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </section>

    <?php showJs(); ?>

    </body>
</html>
