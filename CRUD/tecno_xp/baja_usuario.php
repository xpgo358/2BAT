<?php

include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'] ?? '';

if (empty($id_usuario)) {
    echo "<script>window.location='baja_usuario.html'</script>";
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("s", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('USUARIO NO ENCONTRADO'); window.location='baja_usuario.html';</script>";
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
    
    <div class="user-info">
        <div class="info-row">
            <span class="info-label">ID Usuario:</span>
            <span class="info-value"><?php echo $datos->id_usuario; ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Nombre:</span>
            <span class="info-value"><?php echo $datos->nombre; ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Apellido 1:</span>
            <span class="info-value"><?php echo $datos->ape1; ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Apellido 2:</span>
            <span class="info-value"><?php echo $datos->ape2 ?? 'N/A'; ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Grupo:</span>
            <span class="info-value"><?php echo $datos->grupo; ?></span>
        </div>
    </div>

    <form action='baja_usuario2.php' method='post'>
        <input type='hidden' name='id_usuario' value="<?php echo $datos->id_usuario; ?>">
        
        <div class="button-group">
            <button type='submit' class="btn-delete">🗑️ Eliminar</button>
            <button type='button' class="btn-cancel" onclick='window.location="baja_usuario.html"'>Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
