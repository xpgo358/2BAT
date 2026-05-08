<html>
<head>
<meta charset="utf-8"/>
<title>Listado alumnos</title>
</head>
<body>

<?php
include('conexion.php');
$conexion = conectar();

$consulta = $conexion->query("SELECT * FROM alumnos");
?>

<br><br>
<center><h2><b>LISTADO DE ALUMNOS</b></h2>

<table width="900" border="0" align="center">
<tr align="center">
    <td bgcolor="#CCCCCC">NIA</td>
    <td bgcolor="#CCCCCC">NOMBRE</td>
    <td bgcolor="#CCCCCC">APELLIDO 1</td>
    <td bgcolor="#CCCCCC">APELLIDO 2</td>
    <td bgcolor="#CCCCCC">CURSO</td>
</tr>

<?php
$contador = 0;

while ($fila = $consulta->fetch_assoc()) {
    $contador++;
?>

<tr>
    <td><p style="color:#666;"><?= $fila['NIA'] ?></p></td>
    <td><p style="color:#666;"><?= $fila['Nombre'] ?></p></td>
    <td><p style="color:#666;"><?= $fila['Ape1'] ?></p></td>
    <td><p style="color:#666;"><?= $fila['Ape2'] ?></p></td>
    <td><p style="color:#666;"><?= $fila['Curso'] ?></p></td>
</tr>

<?php } ?>

</table>

<p align="center">
Registros encontrados: <?= $contador ?> <br><br><br><br>

<input type="button" onclick="window.location='index.html'" value="REGRESAR">
</p>

</body>
</html>