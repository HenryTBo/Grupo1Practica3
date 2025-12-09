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




if (isset($_GET['action']) && $_GET['action'] === 'saldo' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $saldo = ObtenerSaldoCompra($id);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok'    => $saldo !== null,
        'saldo' => $saldo
    ]);
    exit;
}




if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['accion']) && $_POST['accion'] === 'abonar') {

    
    $idCompra = $_POST['Compra'] ?? null;
    $monto    = $_POST['Abono'] ?? null;

    $error = RegistrarAbono($idCompra, $monto);

    if ($error === null) {
      
        header('Location: ../View/Modulos/consulta.php');
        exit;
    } else {
        
        header('Location: ../View/Modulos/registro.php?error=' . urlencode($error));
        exit;
    }
}
