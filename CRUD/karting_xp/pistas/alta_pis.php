<?php

include('conexion.php');
$conexion = conectar();

$nombre = $_POST['Nombre'];
$direccion = $_POST['Direccion'];
$descripcion = $_POST['Descripcion'];

// Validación de campos obligatorios
if (empty($nombre)) {
    echo "
    <script>
    alert('ERROR: El nombre de la pista es obligatorio');
    window.location='alta_pis.html';
    </script>";
    exit();
}

// Preparar consulta segura
$stmt = $conexion->prepare("INSERT INTO pistas (Nombre, Direccion, Descripcion) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $direccion, $descripcion);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_pis.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('PISTA GUARDADA CORRECTAMENTE');
    window.location='alta_pis.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
