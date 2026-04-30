<?php

include('conexion.php');
$conexion = conectar();

$idtarifa = $_POST['IDTarifa'];

// Validación
if (empty($idtarifa)) {
    echo "
    <script>
    alert('ID DE TARIFA VACÍO');
    window.location='cambio_tar.html';
    </script>";
    exit();
}

<link rel="stylesheet" href="styles.css">
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
<body class="form-page">
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(230, 57, 70, 0.4);
    }

    .button-secondary {
        background: rgba(230, 57, 70, 0.3);
        margin-top: 10px;
    }

    .button-secondary:hover {
        background: rgba(255, 140, 0, 0.3);
    }

</style>

</head>

<body>

<div class="container">

    <h1>✏️ ACTUALIZAR TARIFA</h1>

    <form action="cambio_tar2.php" method="post">

        <div class="form-group">
            <label for="IDTarifa">ID Tarifa (No se puede cambiar)</label>
            <input type="text" name="IDTarifa" id="IDTarifa" value="<?php echo htmlspecialchars($fila['IDTarifa']); ?>" disabled>
        </div>

        <input type="hidden" name="IDTarifa" value="<?php echo htmlspecialchars($fila['IDTarifa']); ?>">

        <div class="form-group">
            <label for="Nombre">Nombre</label>
            <input type="text" name="Nombre" id="Nombre" value="<?php echo htmlspecialchars($fila['Nombre']); ?>">
        </div>

        <div class="form-group">
            <label for="PrecioPorPersona">Precio por Persona (€)</label>
            <input type="number" name="PrecioPorPersona" id="PrecioPorPersona" step="0.01" min="0" value="<?php echo htmlspecialchars($fila['PrecioPorPersona']); ?>">
        </div>

        <div class="form-group checkbox-group">
            <input type="checkbox" name="Activa" id="Activa" value="1" <?php echo $fila['Activa'] ? 'checked' : ''; ?>>
            <label for="Activa">Tarifa Activa</label>
        </div>

        <button type="submit">ACTUALIZAR</button>
        <button type="button" class="button-secondary" onclick="window.location='index.html'">VOLVER</button>

    </form>

</div>

</body>

</html>

<?php
$consulta->close();
$conexion->close();
?>
