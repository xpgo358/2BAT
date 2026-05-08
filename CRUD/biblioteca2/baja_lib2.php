<?php
include('conexion.php');
$conexion = conectar();

$isbn = $_POST['ISBN'];

// Validación
if (empty($isbn)) {
    echo "<script>alert('ISBN VACÍO'); window.location='baja_lib.html';</script>";
    exit();
}

// Comprobar si existe el libro
$check = $conexion->prepare("SELECT ISBN FROM libros WHERE ISBN = ?");
$check->bind_param("s", $isbn);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('EL LIBRO NO EXISTE'); window.location='baja_lib.html';</script>";
    exit();
}

// ⚠️ Comprobar si está reservado
$checkRes = $conexion->prepare("SELECT * FROM reserva WHERE cod_libro = ?");
$checkRes->bind_param("s", $isbn);
$checkRes->execute();
$res = $checkRes->get_result();

if ($res->num_rows > 0) {
    echo "<script>alert('NO SE PUEDE ELIMINAR: LIBRO RESERVADO'); window.location='baja_lib.html';</script>";
    exit();
}

// Eliminar
$stmt = $conexion->prepare("DELETE FROM libros WHERE ISBN = ?");
$stmt->bind_param("s", $isbn);

if (!$stmt->execute()) {
    echo "ERROR AL ELIMINAR";
    exit();
}

echo "
<script>
alert('LIBRO ELIMINADO');
window.location='baja_lib.html';
</script>
";

$stmt->close();
$conexion->close();
?>