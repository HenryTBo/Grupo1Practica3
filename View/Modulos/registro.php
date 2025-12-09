<?php
include_once __DIR__ . '/../layout.php';
include_once __DIR__ . '/../../Controller/registroController.php';


$pendientes = ObtenerComprasPendientes();


$error = isset($_GET['error']) ? $_GET['error'] : '';
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

                <?php if ($error): ?>
                    <div class="alert alert-danger text-center">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                
                <form method="POST" action="../../Controller/registroController.php" id="formAbono">

                    <input type="hidden" name="accion" value="abonar">

                    <!-- COMPRA -->
                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold">Compra</label>

                        <div class="d-flex justify-content-center gap-3">

                            <select name="Compra" id="Compra" class="form-select w-50" required>
                                <option value="">Seleccione...</option>

                                <?php foreach ($pendientes as $fila): ?>
                                    <option value="<?= $fila['IdCompra'] ?>">
                                        <?= $fila['IdCompra'] . ' - ' . $fila['Descripcion'] ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>

                           
                            <button type="button" id="btnConsultarSaldo" class="btn btn-secondary">
                                Consultar
                            </button>
                        </div>
                    </div>

                    
                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold">Saldo Anterior</label>
                        <input type="text" id="Saldo" name="Saldo" class="form-control w-50 mx-auto" readonly>
                    </div>

                    
                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold">Abono</label>
                        <input type="number" step="0.01" min="0" name="Abono" id="Abono" class="form-control w-50 mx-auto" required>
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

<script>

document.getElementById('btnConsultarSaldo').addEventListener('click', function () {
    const id = document.getElementById('Compra').value;
    const saldoInput = document.getElementById('Saldo');

    if (!id) {
        alert('Debe seleccionar una compra.');
        return;
    }

    fetch('../../Controller/registroController.php?action=saldo&id=' + encodeURIComponent(id))
        .then(r => r.json())
        .then(data => {
            if (data.ok) {
                saldoInput.value = data.saldo;
            } else {
                alert('No se pudo obtener el saldo de la compra seleccionada.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error al consultar el saldo.');
        });
});


document.getElementById('formAbono').addEventListener('submit', function (e) {
    const saldo = parseFloat(document.getElementById('Saldo').value || '0');
    const abono = parseFloat(document.getElementById('Abono').value || '0');

    if (isNaN(saldo) || saldo <= 0) {
        alert('Debe consultar el saldo anterior antes de abonar.');
        e.preventDefault();
        return;
    }

    if (abono <= 0) {
        alert('El abono debe ser mayor a cero.');
        e.preventDefault();
        return;
    }

    if (abono > saldo) {
        alert('El abono no puede ser mayor que el saldo anterior.');
        e.preventDefault();
    }
});
</script>

</body>
</html>
