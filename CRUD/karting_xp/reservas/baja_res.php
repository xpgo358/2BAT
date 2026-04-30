<?php

include('conexion.php');
$conexion = conectar();

$idreserva = $_POST['IDReserva'];

// Validación
if (empty($idreserva)) {
    echo "
    <script>
    alert('ID DE RESERVA VACÍO');
    window.location='baja_res.html';
    </script>";
    exit();
}

// Comprobar si existe
$check = $conexion->prepare("SELECT IDReserva FROM reservas WHERE IDReserva = ?");
$check->bind_param("i", $idreserva);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "
    <script>
    alert('LA RESERVA NO EXISTE');
    window.location='baja_res.html';
    </script>";
    exit();
}

// Eliminar la reserva
$stmt = $conexion->prepare("DELETE FROM reservas WHERE IDReserva = ?");
$stmt->bind_param("i", $idreserva);

if (!$stmt->execute()) {
    echo "
    <script>
    alert('ERROR AL ELIMINAR');
    window.location='baja_res.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('RESERVA ELIMINADA CORRECTAMENTE');
    window.location='baja_res.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
