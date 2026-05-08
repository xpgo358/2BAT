<?php

include('conexion.php');
$conexion = conectar();

$cod_dispositivo = $_POST['cod_dispositivo'] ?? '';
$nombre_dispositivo = $_POST['nombre_dispositivo'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$estado = $_POST['estado'] ?? '';
$imagen = NULL;

if (empty($cod_dispositivo) || empty($nombre_dispositivo) || empty($tipo) || empty($estado)) {
    echo "
    <script>
    alert('FALTAN DATOS OBLIGATORIOS');
    window.location='alta_lib.html';
    </script>";
    exit();
}

// Handle file upload
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $archivo_temp = $_FILES['imagen']['tmp_name'];
    $nombre_archivo = $_FILES['imagen']['name'];
    
    // Validate file type
    $info = pathinfo($nombre_archivo);
    $ext = strtolower($info['extension']);
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($ext, $allowed)) {
        echo "
        <script>
        alert('TIPO DE ARCHIVO NO PERMITIDO. SOLO SE ACEPTAN: JPG, PNG, GIF, WEBP');
        window.location='alta_lib.html';
        </script>";
        exit();
    }
    
    // Check file size (max 5MB)
    if ($_FILES['imagen']['size'] > 5242880) {
        echo "
        <script>
        alert('ARCHIVO DEMASIADO GRANDE. MÁXIMO 5MB');
        window.location='alta_lib.html';
        </script>";
        exit();
    }
    
    // Generate unique filename
    $nombreUnico = time() . '_' . uniqid() . '.' . $ext;
    $ruta_destino = 'imagen/' . $nombreUnico;
    
    if (move_uploaded_file($archivo_temp, $ruta_destino)) {
        $imagen = $nombreUnico;
    } else {
        echo "
        <script>
        alert('ERROR AL SUBIR LA IMAGEN');
        window.location='alta_lib.html';
        </script>";
        exit();
    }
}

$stmt = $conexion->prepare("INSERT INTO dispositivos (cod_dispositivo, nombre_dispositivo, tipo, estado, imagen) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $cod_dispositivo, $nombre_dispositivo, $tipo, $estado, $imagen);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_lib.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('DISPOSITIVO GUARDADO CORRECTAMENTE');
    window.location='alta_lib.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
