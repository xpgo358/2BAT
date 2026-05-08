<?php

include('conexion.php');
$conexion = conectar();

$nia = $_POST['NIA'];
$nombre = $_POST['Nombre'];
$ape1 = $_POST['Ape1'];
$ape2 = $_POST['Ape2'];
$curso = $_POST['Curso'];

// Preparar consulta segura
$stmt = $conexion->prepare("INSERT INTO alumnos (NIA, Nombre, Ape1, Ape2, Curso) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nia, $nombre, $ape1, $ape2, $curso);

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