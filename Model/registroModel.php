<?php
include_once __DIR__ . '/conexionModel.php';

function ObtenerComprasPendientesModel()
{
    $context = OpenConnection();

    $sql = "CALL sp_Compras_ObtenerPendientes()";
    $resultado = $context->query($sql);

    $datos = [];
    while ($row = $resultado->fetch_assoc()) {
        $datos[] = $row; 
    }

    $resultado->free();
    CloseConnection($context);

    return $datos;
}

function ObtenerSaldoCompraModel($idCompra)
{
    $context = OpenConnection();

    $id = (int)$idCompra;
    $sql = "CALL sp_Compras_ObtenerSaldo($id)";
    $resultado = $context->query($sql);

    $saldo = null;
    if ($row = $resultado->fetch_assoc()) {
        $saldo = $row['Saldo'];
    }

    $resultado->free();
    CloseConnection($context);

    return $saldo;
}

function RegistrarAbonoModel($idCompra, $monto)
{
    $context = OpenConnection();

    $id = (int)$idCompra;
    $m  = (float)$monto;

    try {
        $sql = "CALL sp_Abonos_Registrar($id, $m)";
        $context->query($sql);

        CloseConnection($context);
        return null; 
    } catch (mysqli_sql_exception $e) {
        $msg = $e->getMessage();
        CloseConnection($context);
        return $msg; 
    }
}
