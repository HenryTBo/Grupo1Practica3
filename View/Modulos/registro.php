<?php
include_once __DIR__ . '/../layout.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php showCss(); ?>
<link href="../css/estilos.css" rel="stylesheet" />

    <body>

    <?php showNavBar(); ?>

    <section class="page-section" id="registro">
        <div class="container d-flex justify-content-center">

            <div class="consulta-wrapper">
                <div class="consulta-top-bar"></div>

                <div class="consulta-inner">

                    <div class="consulta-title-box">
                        <span>Registro</span>
                    </div>

                    <form method="POST">

                        <div class="mb-3 text-center">
                            <label class="form-label fw-bold">Compra</label>

                            <div class="d-flex justify-content-center gap-3">

                                <select name="Compra" class="form-select w-50">
                                    <option value="">Seleccione...</option>
                                </select>

                                <button type="submit" name="btnConsultar" class="btn btn-secondary">
                                    Consultar
                                </button>
                            </div>
                        </div>

                
                        <div class="mb-3 text-center">
                            <label class="form-label fw-bold">Saldo Anterior</label>
                            <input type="text" name="Saldo" class="form-control w-50 mx-auto" readonly>
                        </div>

                    
                        <div class="mb-3 text-center">
                            <label class="form-label fw-bold">Abono</label>
                            <input type="number" name="Abono" class="form-control w-50 mx-auto">
                        </div>

                    
                        <div class="text-center mt-4">
                            <button type="submit" name="btnAbonar" class="btn btn-primary w-50">
                                Abonar
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </section>

    <?php showJs(); ?>

    </body>
</html>