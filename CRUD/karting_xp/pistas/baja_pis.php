<?php

include('conexion.php');
$conexion = conectar();

$idpista = $_POST['IDPista'];

// Validación
if (empty($idpista)) {
    echo "
    <script>
    alert('ID DE PISTA VACÍO');
    window.location='baja_pis.html';
    </script>";
    exit();
}

// Comprobar si existe
$check = $conexion->prepare("SELECT IDPista FROM pistas WHERE IDPista = ?");
$check->bind_param("i", $idpista);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "
    <script>
    alert('LA PISTA NO EXISTE');
    window.location='baja_pis.html';
    </script>";
    exit();
}

// Comprobar si tiene reservas
$check_reservas = $conexion->prepare("SELECT IDReserva FROM reservas WHERE IDPista = ?");
$check_reservas->bind_param("i", $idpista);
$check_reservas->execute();
$result_reservas = $check_reservas->get_result();

if ($result_reservas->num_rows > 0) {
    echo "
    <script>
    alert('NO SE PUEDE ELIMINAR: LA PISTA TIENE RESERVAS ASOCIADAS');
    window.location='baja_pis.html';
    </script>";
    exit();
}

// Eliminar la pista
$stmt = $conexion->prepare("DELETE FROM pistas WHERE IDPista = ?");
$stmt->bind_param("i", $idpista);

if (!$stmt->execute()) {
    echo "
    <script>
    alert('ERROR AL ELIMINAR');
    window.location='baja_pis.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('PISTA ELIMINADA CORRECTAMENTE');
    window.location='baja_pis.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
