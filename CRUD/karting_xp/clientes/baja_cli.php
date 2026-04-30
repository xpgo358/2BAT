<?php

include('conexion.php');
$conexion = conectar();

$dni = $_POST['DNI'];

// Validación
if (empty($dni)) {
    echo "
    <script>
    alert('DNI VACÍO');
    window.location='baja_cli.html';
    </script>";
    exit();
}

// No permitir eliminar cliente anónimo
if ($dni === 'ANONIMO') {
    echo "
    <script>
    alert('NO SE PUEDE ELIMINAR EL CLIENTE GENÉRICO');
    window.location='baja_cli.html';
    </script>";
    exit();
}

// Comprobar si existe
$check = $conexion->prepare("SELECT DNI FROM clientes WHERE DNI = ?");
$check->bind_param("s", $dni);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "
    <script>
    alert('EL CLIENTE NO EXISTE');
    window.location='baja_cli.html';
    </script>";
    exit();
}

// Reasignar reservas a cliente anónimo
$update_reservas = $conexion->prepare("UPDATE reservas SET NumLicencia = 'LIC-ANONIMO' WHERE NumLicencia IN (SELECT NumLicencia FROM clientes WHERE DNI = ?)");
$update_reservas->bind_param("s", $dni);
$update_reservas->execute();

// Anonimizar datos del cliente
$stmt = $conexion->prepare("UPDATE clientes SET Nombre = '', Ape1 = '', Ape2 = '', Email = '', Telefono = '', Direccion = '' WHERE DNI = ?");
$stmt->bind_param("s", $dni);

if (!$stmt->execute()) {
    echo "
    <script>
    alert('ERROR AL ELIMINAR');
    window.location='baja_cli.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('CLIENTE ELIMINADO Y ANONIMIZADO CORRECTAMENTE');
    window.location='baja_cli.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
