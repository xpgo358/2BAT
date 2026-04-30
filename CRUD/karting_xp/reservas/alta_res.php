<?php

include('conexion.php');
$conexion = conectar();

$numlicencia = $_POST['NumLicencia'];
$idpista = $_POST['IDPista'];
$fechareseva = $_POST['FechaReserva'];
$horainicio = $_POST['HoraInicio'];
$horafin = $_POST['HoraFin'];
$personas = $_POST['Personas'];
$idtarifa = $_POST['IDTarifa'];
$descuento = $_POST['Descuento'];

// Validación de campos obligatorios
if (empty($numlicencia) || empty($idpista) || empty($fechareseva) || empty($horainicio) || empty($horafin) || empty($personas) || empty($idtarifa)) {
    echo "
    <script>
    alert('ERROR: Los campos obligatorios (*) no pueden estar vacíos');
    window.location='alta_res.html';
    </script>";
    exit();
}

// Validación de personas positivas
if ($personas <= 0) {
    echo "
    <script>
    alert('ERROR: El número de personas debe ser positivo');
    window.location='alta_res.html';
    </script>";
    exit();
}

// Validación de descuento
if ($descuento < 0 || $descuento > 100) {
    echo "
    <script>
    alert('ERROR: El descuento debe estar entre 0 y 100');
    window.location='alta_res.html';
    </script>";
    exit();
}

// Validación de horarios
if ($horainicio >= $horafin) {
    echo "
    <script>
    alert('ERROR: La hora de inicio debe ser anterior a la de fin');
    window.location='alta_res.html';
    </script>";
    exit();
}

// Comprobar overlap de horarios
$check_overlap = $conexion->prepare("SELECT IDReserva FROM reservas WHERE IDPista = ? AND FechaReserva = ? AND HoraInicio < ? AND HoraFin > ?");
$check_overlap->bind_param("isss", $idpista, $fechareseva, $horafin, $horainicio);
$check_overlap->execute();
$result_overlap = $check_overlap->get_result();

if ($result_overlap->num_rows > 0) {
    echo "
    <script>
    alert('ERROR: Hay una reserva conflictiva en ese horario para esa pista');
    window.location='alta_res.html';
    </script>";
    exit();
}

// Preparar consulta segura
$stmt = $conexion->prepare("INSERT INTO reservas (NumLicencia, IDPista, FechaReserva, HoraInicio, HoraFin, Personas, IDTarifa, Descuento, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Reservada')");
$stmt->bind_param("sissssid", $numlicencia, $idpista, $fechareseva, $horainicio, $horafin, $personas, $idtarifa, $descuento);

$registro = $stmt->execute();

if (!$registro) {
    echo "
    <script>
    alert('ERROR AL GUARDAR DATOS');
    window.location='alta_res.html';
    </script>";
    exit();
} else {
    echo "
    <script>
    alert('RESERVA GUARDADA CORRECTAMENTE');
    window.location='alta_res.html';
    </script>";
}

$stmt->close();
$conexion->close();

?>
