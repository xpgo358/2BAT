<?php

include('conexion.php');
$conexion = conectar();

$id_usuario = $_POST['id_usuario'] ?? '';

if (empty($id_usuario)) {
    echo "<script>window.location='baja_alu.html'</script>";
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("s", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('USUARIO NO ENCONTRADO'); window.location='baja_alu.html';</script>";
    exit();
}

$datos = $result->fetch_object();
?>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmar Eliminación - TecnoXP</title>

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
    max-width: 600px;
    width: 100%;
}

h2 {
    text-align: center;
    color: #667eea;
    margin-bottom: 30px;
}

.user-info {
    background: #f8f9ff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    border-left: 4px solid #667eea;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e0e0e0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #667eea;
}

.info-value {
    color: #333;
}

.button-group {
    display: flex;
    gap: 10px;
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
}

.btn-delete {
    background: #e74c3c;
    color: white;
}

.btn-delete:hover {
    background: #c0392b;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
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

    <form action='baja_alu2.php' method='post'>
        <input type='hidden' name='id_usuario' value="<?php echo $datos->id_usuario; ?>">
        
        <div class="button-group">
            <button type='submit' class="btn-delete">🗑️ Eliminar</button>
            <button type='button' class="btn-cancel" onclick='window.location="baja_alu.html"'>Cancelar</button>
        </div>
    </form>
</div>

</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
