<?php

include('conexion.php');
$conexion = conectar();

$cod_alu = $_POST['cod_alumno'];
$cod_lib = $_POST['cod_libro'];
$fecha = $_POST['fecha'];

// Validación básica
if (empty($cod_alu) || empty($cod_lib) || empty($fecha)) {
    echo "
    <script>
    alert('FALTAN DATOS');
    window.location='alta_reser.html';
    </script>";
    exit();
}

// Consulta preparada (segura)
$stmt = $conexion->prepare("INSERT INTO reserva (cod_alumno, cod_libro, fecha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $cod_alu, $cod_lib, $fecha);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_reser.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('DATOS GUARDADOS CORRECTAMENTE');
    window.location='alta_reser.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>