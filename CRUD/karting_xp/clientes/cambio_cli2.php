<?php

include('conexion.php');
$conexion = conectar();

$dni = $_POST['DNI'];
$numlicencia = $_POST['NumLicencia'];
$nombre = $_POST['Nombre'];
$ape1 = $_POST['Ape1'];
$ape2 = $_POST['Ape2'];
$email = $_POST['Email'];
$telefono = $_POST['Telefono'];
$direccion = $_POST['Direccion'];
$fecharenovacion = $_POST['FechaRenovacion'];

// Validación de email
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "
    <script>
    alert('ERROR: Email no válido');
    window.history.back();
    </script>";
    exit();
}

// Preparar consulta segura
$stmt = $conexion->prepare("UPDATE clientes SET NumLicencia = ?, Nombre = ?, Ape1 = ?, Ape2 = ?, Email = ?, Telefono = ?, Direccion = ?, FechaRenovacion = ? WHERE DNI = ?");
$stmt->bind_param("sssssssss", $numlicencia, $nombre, $ape1, $ape2, $email, $telefono, $direccion, $fecharenovacion, $dni);

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
    alert('CLIENTE ACTUALIZADO CORRECTAMENTE');
    window.location='cambio_cli.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
