<?php

include('conexion.php');
$conexion = conectar();

$nombre = $_POST['Nombre'];
$preciporpersona = $_POST['PrecioPorPersona'];
$activa = isset($_POST['Activa']) ? 1 : 0;

// Validación de campos obligatorios
if (empty($nombre) || empty($preciporpersona)) {
    echo "
    <script>
    alert('ERROR: Los campos obligatorios (*) no pueden estar vacíos');
    window.location='alta_tar.html';
    </script>";
    exit();
}

// Validación de precio positivo
if ($preciporpersona < 0) {
    echo "
    <script>
    alert('ERROR: El precio no puede ser negativo');
    window.location='alta_tar.html';
    </script>";
    exit();
}

// Preparar consulta segura
$stmt = $conexion->prepare("INSERT INTO tarifas (Nombre, PrecioPorPersona, Activa) VALUES (?, ?, ?)");
$stmt->bind_param("sdi", $nombre, $preciporpersona, $activa);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_tar.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('TARIFA GUARDADA CORRECTAMENTE');
    window.location='alta_tar.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
