<?php

include('conexion.php');
$conexion = conectar();

$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';

if (empty($cod_dispositivo)) {
    echo "<script>window.location='cambio_dispositivo.html'</script>";
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM dispositivos WHERE cod_dispositivo = ?");
$stmt->bind_param("s", $cod_dispositivo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('DISPOSITIVO NO ENCONTRADO'); window.location='cambio_dispositivo.html';</script>";
    exit();
}

$datos = $result->fetch_object();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Dispositivo - TecnoXP</title>

<link rel="stylesheet" href="styles.css">
</head>

<body>

<div class="container">
    <h2>✏️ EDITAR DISPOSITIVO</h2>
    
    <form action='cambio_dispositivo2.php' method='post'>
        <div class="form-group">
            <label>Código:</label>
            <input type='text' name='cod_dispositivo' value="<?php echo $datos->cod_dispositivo; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Nombre:</label>
            <input type='text' name='nombre_dispositivo' value="<?php echo $datos->nombre_dispositivo; ?>">
        </div>

        <div class="form-group">
            <label>Tipo:</label>
            <select name='tipo'>
                <option value="Portátil" <?php if($datos->tipo == 'Portátil') echo 'selected'; ?>>Portátil</option>
                <option value="Tablet" <?php if($datos->tipo == 'Tablet') echo 'selected'; ?>>Tablet</option>
                <option value="Cámara" <?php if($datos->tipo == 'Cámara') echo 'selected'; ?>>Cámara</option>
                <option value="Monitor" <?php if($datos->tipo == 'Monitor') echo 'selected'; ?>>Monitor</option>
                <option value="Auriculares" <?php if($datos->tipo == 'Auriculares') echo 'selected'; ?>>Auriculares</option>
                <option value="Otro" <?php if($datos->tipo == 'Otro') echo 'selected'; ?>>Otro</option>
            </select>
        </div>

        <div class="form-group">
            <label>Estado:</label>
            <select name='estado'>
                <option value="disponible" <?php if($datos->estado == 'disponible') echo 'selected'; ?>>Disponible</option>
                <option value="mantenimiento" <?php if($datos->estado == 'mantenimiento') echo 'selected'; ?>>Mantenimiento</option>
            </select>
        </div>

        <div class="button-group">
            <button type='submit' class="btn-submit">💾 Guardar</button>
            <button type='button' class="btn-cancel" onclick='window.location="cambio_dispositivo.html"'>Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
