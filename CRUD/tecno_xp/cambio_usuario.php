<?php

include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'] ?? '';

if (empty($id_usuario)) {
    echo "<script>window.location='cambio_usuario.html'</script>";
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("s", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('USUARIO NO ENCONTRADO'); window.location='cambio_usuario.html';</script>";
    exit();
}

$datos = $result->fetch_object();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Usuario - TecnoXP</title>

<link rel="stylesheet" href="styles.css">
</head>

<body>

<div class="container">
    <h2>✏️ EDITAR USUARIO</h2>
    
    <form action='cambio_usuario2.php' method='post'>
        <div class="form-group">
            <label>ID Usuario:</label>
            <input type='text' name='id_usuario' value="<?php echo $datos->id_usuario; ?>" readonly>
        </div>

        <div class="form-group">
            <label>Nombre:</label>
            <input type='text' name='nombre' value="<?php echo $datos->nombre; ?>">
        </div>

        <div class="form-group">
            <label>Primer Apellido:</label>
            <input type='text' name='ape1' value="<?php echo $datos->ape1; ?>">
        </div>

        <div class="form-group">
            <label>Segundo Apellido:</label>
            <input type='text' name='ape2' value="<?php echo $datos->ape2; ?>">
        </div>

        <div class="form-group">
            <label>Grupo:</label>
            <input type='text' name='grupo' value="<?php echo $datos->grupo; ?>">
        </div>

        <div class="button-group">
            <button type='submit' class="btn-submit">💾 Guardar</button>
            <button type='button' class="btn-cancel" onclick='window.location="cambio_usuario.html"'>Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
