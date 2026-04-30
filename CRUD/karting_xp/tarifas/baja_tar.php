<?php

include('conexion.php');
$conexion = conectar();

$idtarifa = $_POST['IDTarifa'];

// Validación
if (empty($idtarifa)) {
    echo "
    <script>
    alert('ID DE TARIFA VACÍO');
    window.location='baja_tar.html';
    </script>";
    exit();
}

// Comprobar si existe
$check = $conexion->prepare("SELECT IDTarifa FROM tarifas WHERE IDTarifa = ?");
$check->bind_param("i", $idtarifa);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "
    <script>
    alert('LA TARIFA NO EXISTE');
    window.location='baja_tar.html';
    </script>";
    exit();
}

// Desactivar la tarifa (soft delete)
$stmt = $conexion->prepare("UPDATE tarifas SET Activa = 0 WHERE IDTarifa = ?");
$stmt->bind_param("i", $idtarifa);

if (!$stmt->execute()) {
    echo "
    <script>
    alert('ERROR AL DESACTIVAR');
    window.location='baja_tar.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('TARIFA DESACTIVADA CORRECTAMENTE');
    window.location='baja_tar.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
