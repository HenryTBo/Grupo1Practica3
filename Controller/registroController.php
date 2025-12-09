<?php
include_once __DIR__ . '/../Model/registroModel.php';

function ObtenerComprasPendientes()
{
    return ObtenerComprasPendientesModel();
}

function ObtenerSaldoCompra($id)
{
    return ObtenerSaldoCompraModel($id);
}

function RegistrarAbono($idCompra, $monto)
{
    return RegistrarAbonoModel($idCompra, $monto);
}

/*
 * Endpoint AJAX para obtener el saldo de una compra
 * URL: registroController.php?action=saldo&id=#
 */
if (isset($_GET['action']) && $_GET['action'] === 'saldo' && isset($_GET['id'])) {
    $id    = (int)$_GET['id'];
    $saldo = ObtenerSaldoCompra($id);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok'    => $saldo !== null,
        'saldo' => $saldo
    ]);
    exit;
}

/*
 * Procesamiento del formulario de abono
 */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['accion']) &&
    $_POST['accion'] === 'abonar'
) {
    $idCompra = $_POST['Compra'] ?? null;
    $monto    = $_POST['Abono'] ?? null;

    $error = RegistrarAbono($idCompra, $monto);

    if ($error === null) {
        // Abono correcto -> ir a Consulta
        header('Location: ../View/Modulos/consulta.php');
        exit;
    } else {
        // Hubo error -> regresar a Registro con mensaje
        header('Location: ../View/Modulos/registro.php?error=' . urlencode($error));
        exit;
    }
}
