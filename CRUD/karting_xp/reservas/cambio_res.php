<?php

include('conexion.php');
$conexion = conectar();

$idreserva = $_POST['IDReserva'];

// Validación
if (empty($idreserva)) {
<link rel="stylesheet" href="styles.css">
    }

    button {
<body class="form-page">
        padding: 12px;
        background: linear-gradient(135deg, #E63946 0%, #FF8C00 100%);
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
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

    <h1>✏️ ACTUALIZAR RESERVA</h1>

    <form action="cambio_res2.php" method="post">

        <div class="form-group">
            <label for="IDReserva">ID Reserva (No se puede cambiar)</label>
            <input type="text" name="IDReserva" id="IDReserva" value="<?php echo htmlspecialchars($fila['IDReserva']); ?>" disabled>
        </div>

        <input type="hidden" name="IDReserva" value="<?php echo htmlspecialchars($fila['IDReserva']); ?>">

        <div class="form-group">
            <label for="Estado">Estado de la Reserva</label>
            <select name="Estado" id="Estado">
                <option value="Reservada" <?php echo $fila['Estado'] == 'Reservada' ? 'selected' : ''; ?>>Reservada</option>
                <option value="Confirmada" <?php echo $fila['Estado'] == 'Confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                <option value="En curso" <?php echo $fila['Estado'] == 'En curso' ? 'selected' : ''; ?>>En curso</option>
                <option value="Completada" <?php echo $fila['Estado'] == 'Completada' ? 'selected' : ''; ?>>Completada</option>
                <option value="Cancelada" <?php echo $fila['Estado'] == 'Cancelada' ? 'selected' : ''; ?>>Cancelada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="Descuento">Descuento (%)</label>
            <input type="number" name="Descuento" id="Descuento" min="0" max="100" step="0.01" value="<?php echo htmlspecialchars($fila['Descuento']); ?>">
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
