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

// Validación de campos obligatorios
if (empty($dni) || empty($numlicencia) || empty($nombre) || empty($ape1)) {
    echo "
    <script>
    alert('ERROR: Los campos obligatorios (*) no pueden estar vacíos');
    window.location='alta_cli.html';
    </script>";
    exit();
}

// Validación de email
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "
    <script>
    alert('ERROR: Email no válido');
    window.location='alta_cli.html';
    </script>";
    exit();
}

// Comprobar si DNI ya existe
$check = $conexion->prepare("SELECT DNI FROM clientes WHERE DNI = ?");
$check->bind_param("s", $dni);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "
    <script>
    alert('ERROR: Este DNI ya existe');
    window.location='alta_cli.html';
    </script>";
    exit();
}

// Preparar consulta segura
$stmt = $conexion->prepare("INSERT INTO clientes (DNI, NumLicencia, Nombre, Ape1, Ape2, Email, Telefono, Direccion, FechaRenovacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $dni, $numlicencia, $nombre, $ape1, $ape2, $email, $telefono, $direccion, $fecharenovacion);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_cli.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('CLIENTE GUARDADO CORRECTAMENTE');
    window.location='alta_cli.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
