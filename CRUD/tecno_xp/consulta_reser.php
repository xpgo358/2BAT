<html>
<head>
<meta charset="utf-8"/>
<title>Listado préstamos</title>
</head>
<body>

<?php
include('conexion.php');
$conexion = conectar();

$consulta = $conexion->query("SELECT * FROM reserva");
?>

<br><br>
<center><h2><b>LISTADO DE PRÉSTAMOS</b></h2>

<table width="900" border="0" align="center">
<tr align="center">
    <td bgcolor="#CCCCCC">NIA ALUMNO</td>
    <td bgcolor="#CCCCCC">ISBN LIBRO</td>
    <td bgcolor="#CCCCCC">FECHA</td>
</tr>

<?php
$contador = 0;

while ($fila = $consulta->fetch_assoc()) {

    $contador++;

    $cod_alu = $fila['cod_alumno'];
    $cod_lib = $fila['cod_libro'];
    $fecha   = $fila['fecha'];
?>

<tr>
    <td><p style="color:#666;"><?= $cod_alu ?></p></td>
    <td><p style="color:#666;"><?= $cod_lib ?></p></td>
    <td><p style="color:#666;"><?= $fecha ?></p></td>
</tr>

<?php } ?>

</table>

<p align="center">
Registros encontrados: <?= $contador ?> <br><br><br><br>

<input type="button" onclick="window.location='index.html'" value="REGRESAR">
</p>

</body>
</html>