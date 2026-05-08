<?php

include('conexion.php');
$conexion = conectar();

$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';

if (empty($cod_dispositivo)) {
    echo "<script>window.location='cambio_lib.html'</script>";
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM dispositivos WHERE cod_dispositivo = ?");
$stmt->bind_param("s", $cod_dispositivo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('DISPOSITIVO NO ENCONTRADO'); window.location='cambio_lib.html';</script>";
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

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.container {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    max-width: 500px;
    width: 100%;
}

h2 {
    text-align: center;
    color: #667eea;
    margin-bottom: 30px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

label {
    color: #333;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

input, select {
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

input:focus, select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

input[readonly] {
    background: #f0f0f0;
    cursor: not-allowed;
}

.button-group {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

button {
    flex: 1;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-cancel {
    background: #f0f0f0;
    color: #333;
}

.btn-cancel:hover {
    background: #e0e0e0;
}
</style>
</head>

<body>

<div class="container">
    <h2>✏️ EDITAR DISPOSITIVO</h2>
    
    <form action='cambio_lib2.php' method='post'>
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
                <option value="reservado" <?php if($datos->estado == 'reservado') echo 'selected'; ?>>Reservado</option>
                <option value="mantenimiento" <?php if($datos->estado == 'mantenimiento') echo 'selected'; ?>>Mantenimiento</option>
            </select>
        </div>

        <div class="button-group">
            <button type='submit' class="btn-submit">💾 Guardar</button>
            <button type='button' class="btn-cancel" onclick='window.location="cambio_lib.html"'>Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
