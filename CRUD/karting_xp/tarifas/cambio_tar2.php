<?php

include('conexion.php');
$conexion = conectar();

$idtarifa = $_POST['IDTarifa'];
$nombre = $_POST['Nombre'];
$preciporpersona = $_POST['PrecioPorPersona'];
$activa = isset($_POST['Activa']) ? 1 : 0;

// Validación de campos obligatorios
if (empty($nombre) || empty($preciporpersona)) {
    echo "
    <script>
    alert('ERROR: Los campos obligatorios no pueden estar vacíos');
    window.history.back();
    </script>";
    exit();
}

// Validación de precio positivo
if ($preciporpersona < 0) {
    echo "
    <script>
    alert('ERROR: El precio no puede ser negativo');
    window.history.back();
    </script>";
    exit();
}

// Preparar consulta segura
$stmt = $conexion->prepare("UPDATE tarifas SET Nombre = ?, PrecioPorPersona = ?, Activa = ? WHERE IDTarifa = ?");
$stmt->bind_param("sdii", $nombre, $preciporpersona, $activa, $idtarifa);

if (!$stmt->execute()) {
    echo "
    <script>
    alert('ERROR AL ACTUALIZAR DATOS');
    window.history.back();
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('TARIFA ACTUALIZADA CORRECTAMENTE');
    window.location='cambio_tar.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
