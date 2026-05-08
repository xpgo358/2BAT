<?php

include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'];
$nombre = $_POST['nombre'];
$ape1 = $_POST['ape1'];
$ape2 = $_POST['ape2'];
$grupo = $_POST['grupo'];

// Preparar consulta segura
$stmt = $conexion->prepare("INSERT INTO usuarios (id_usuario, nombre, ape1, ape2, grupo) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $id_usuario, $nombre, $ape1, $ape2, $grupo);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_alu.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('DATOS GUARDADOS CORRECTAMENTE');
    window.location='alta_alu.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>