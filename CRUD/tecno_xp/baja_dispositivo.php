<?php

include('conexion.php');
$conexion = conectar();

$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';

if (empty($cod_dispositivo)) {
    echo "<script>window.location='baja_dispositivo.html'</script>";
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM dispositivos WHERE cod_dispositivo = ?");
$stmt->bind_param("s", $cod_dispositivo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('DISPOSITIVO NO ENCONTRADO'); window.location='baja_dispositivo.html';</script>";
    exit();
}

$datos = $result->fetch_object();
?>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmar Eliminación - TecnoXP</title>

<link rel="stylesheet" href="styles.css">
</head>

<body>

<div class="container">
    <h2>⚠️ CONFIRMAR ELIMINACIÓN</h2>
    
    <div class="device-info">
        <div class="info-row">
            <span class="info-label">Código:</span>
            <span class="info-value"><?php echo $datos->cod_dispositivo; ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Nombre:</span>
            <span class="info-value"><?php echo $datos->nombre_dispositivo; ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Tipo:</span>
            <span class="info-value"><?php echo $datos->tipo; ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Estado:</span>
            <span class="info-value"><?php echo $datos->estado; ?></span>
        </div>
    </div>

    <form action='baja_dispositivo2.php' method='post'>
        <input type='hidden' name='cod_dispositivo' value="<?php echo $datos->cod_dispositivo; ?>">
        
        <div class="button-group">
            <button type='submit' class="btn-delete">🗑️ Eliminar</button>
            <button type='button' class="btn-cancel" onclick='window.location="baja_dispositivo.html"'>Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
