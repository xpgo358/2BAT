<?php

include('conexion.php');
$conexion = conectar();

$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';

if (empty($cod_dispositivo)) {
    echo "<script>window.location='baja_dispositivo.html'</script>";
    exit();
}

$stmt = $conexion->prepare("DELETE FROM dispositivos WHERE cod_dispositivo = ?");
$stmt->bind_param("s", $cod_dispositivo);
$resultado = $stmt->execute();

if ($resultado) {
    echo "
    <script>
    alert('DISPOSITIVO ELIMINADO CORRECTAMENTE');
    window.location='baja_dispositivo.html';
    </script>";
} else {
    echo "
    <script>
    alert('ERROR AL ELIMINAR');
    window.location='baja_dispositivo.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
