<?php

include('conexion.php');
$conexion = conectar();

$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';

if (empty($cod_dispositivo)) {
    echo "<script>window.location='baja_lib.html'</script>";
    exit();
}

// Get image to delete
$stmt = $conexion->prepare("SELECT imagen FROM dispositivos WHERE cod_dispositivo = ?");
$stmt->bind_param("s", $cod_dispositivo);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_object();

// Delete image file if exists
if (!empty($datos->imagen)) {
    $ruta_imagen = 'imagen/' . $datos->imagen;
    if (file_exists($ruta_imagen)) {
        unlink($ruta_imagen);
    }
}

// Delete from database
$stmt = $conexion->prepare("DELETE FROM dispositivos WHERE cod_dispositivo = ?");
$stmt->bind_param("s", $cod_dispositivo);
$resultado = $stmt->execute();

if ($resultado) {
    echo "
    <script>
    alert('DISPOSITIVO ELIMINADO CORRECTAMENTE');
    window.location='baja_lib.html';
    </script>";
} else {
    echo "
    <script>
    alert('ERROR AL ELIMINAR');
    window.location='baja_lib.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
