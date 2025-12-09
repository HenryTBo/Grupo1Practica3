<?php
include_once __DIR__ . '/conexionModel.php';


function ConsultarComprasModel()
{
    $context = OpenConnection();

    $sentencia = "CALL sp_Compras_ObtenerTodas()";
    $resultado = $context->query($sentencia);

    $datos = [];
    while ($row = $resultado->fetch_assoc()) {
        $datos[] = $row;
    }

    $resultado->free();
    CloseConnection($context);

    return $datos;
}