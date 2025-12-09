<?php

function OpenConnection()
{
    // Para que mysqli lance excepciones si algo sale mal
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $server   = "localhost";
    $user     = "root";
    $password = "dannyJP_2021";
    $database = "practica3";

    $conn = mysqli_connect($server, $user, $password, $database);

    if (!$conn) {
        die("Error de conexión a la base de datos");
    }

    // Soporte para tildes y eñes
    $conn->set_charset("utf8mb4");

    return $conn;
}

function CloseConnection($context)
{
    if ($context) {
        $context->close();
    }
}
