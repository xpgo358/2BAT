<?php

function conectar() {

    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $bd = "karting_xp";

    // Crear conexión
    $conexion = new mysqli($servidor, $usuario, $password, $bd);

    // Comprobar conexión
    if ($conexion->connect_error) {
        die("ERROR AL CONECTAR CON EL SERVIDOR: " . $conexion->connect_error);
    }

    // Establecer codificación
    $conexion->set_charset("utf8");

    return $conexion;
}

?>
