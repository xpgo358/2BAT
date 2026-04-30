<?php

include('conexion.php');
$conexion = conectar();

$idreserva = $_POST['IDReserva'];
$estado = $_POST['Estado'];
$descuento = $_POST['Descuento'];

// Validación de descuento
if ($descuento < 0 || $descuento > 100) {
    echo "
    <script>
    alert('ERROR: El descuento debe estar entre 0 y 100');
    window.history.back();
    </script>";
    exit();
}

// Preparar consulta segura
$stmt = $conexion->prepare("UPDATE reservas SET Estado = ?, Descuento = ? WHERE IDReserva = ?");
$stmt->bind_param("sdi", $estado, $descuento, $idreserva);

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
    alert('RESERVA ACTUALIZADA CORRECTAMENTE');
    window.location='cambio_res.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
