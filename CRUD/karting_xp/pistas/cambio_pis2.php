<?php

include('conexion.php');
$conexion = conectar();

$idpista = $_POST['IDPista'];
$nombre = $_POST['Nombre'];
$direccion = $_POST['Direccion'];
$descripcion = $_POST['Descripcion'];

// Validación de campos obligatorios
if (empty($nombre)) {
    echo "
    <script>
    alert('ERROR: El nombre de la pista es obligatorio');
    window.history.back();
    </script>";
    exit();
}

// Preparar consulta segura
$stmt = $conexion->prepare("UPDATE pistas SET Nombre = ?, Direccion = ?, Descripcion = ? WHERE IDPista = ?");
$stmt->bind_param("sssi", $nombre, $direccion, $descripcion, $idpista);

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
    alert('PISTA ACTUALIZADA CORRECTAMENTE');
    window.location='cambio_pis.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
