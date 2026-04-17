-- =============================================
-- Base de datos: CRUD Sitio de Karts
-- Motor: MySQL 5.6.x (XAMPP 5.6.33)
-- =============================================

DROP DATABASE IF EXISTS karting_crud;
CREATE DATABASE karting_crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE karting_crud;

-- =============================================
-- TABLAS
-- =============================================

CREATE TABLE clientes (
    dni VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    apellido1 VARCHAR(80) NOT NULL,
    apellido2 VARCHAR(80) NULL,
    foto VARCHAR(255) NULL,
    telefono VARCHAR(25) NOT NULL,
    email VARCHAR(120) NOT NULL,
    direccion VARCHAR(200) NULL,
    fecha_renovacion DATE NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_clientes_email UNIQUE (email)
);

CREATE TABLE pistas (
    id_pista INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_pistas_nombre UNIQUE (nombre)
);

CREATE TABLE karts (
    numero_matricula VARCHAR(30) PRIMARY KEY,
    pista VARCHAR(80) NOT NULL,
    fecha_ultimo_mantenimiento DATE NOT NULL,
    fecha_proximo_mantenimiento DATE NOT NULL,
    observaciones VARCHAR(300) NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tarifas (
    nombre VARCHAR(100) PRIMARY KEY,
    precio_por_persona DECIMAL(10,2) NOT NULL,
    activa TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE reservas (
    id_reserva INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dni_cliente VARCHAR(20) NOT NULL,
    tarifa VARCHAR(100) NOT NULL,
    id_pista INT UNSIGNED NOT NULL,
    fecha_reserva DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    estado ENUM('Reservada', 'En curso', 'Completada', 'Cancelada', 'No presentada') NOT NULL DEFAULT 'Reservada',
    descuento DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_reservas_cliente FOREIGN KEY (dni_cliente)
        REFERENCES clientes(dni)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_reservas_tarifa FOREIGN KEY (tarifa)
        REFERENCES tarifas(nombre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_reservas_pista FOREIGN KEY (id_pista)
        REFERENCES pistas(id_pista)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE carreras (
    id_carrera INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT UNSIGNED NOT NULL,
    nombre_carrera VARCHAR(120) NOT NULL,
    fecha_carrera DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    pista VARCHAR(80) NOT NULL,
    estado ENUM('Programada', 'En curso', 'Finalizada', 'Cancelada') NOT NULL DEFAULT 'Programada',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_carreras_reserva FOREIGN KEY (id_reserva)
        REFERENCES reservas(id_reserva)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

CREATE TABLE participaciones_carrera (
    id_participacion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_carrera INT UNSIGNED NOT NULL,
    dni_cliente VARCHAR(20) NOT NULL,
    numero_matricula VARCHAR(30) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_participaciones_carrera FOREIGN KEY (id_carrera)
        REFERENCES carreras(id_carrera)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_participaciones_cliente FOREIGN KEY (dni_cliente)
        REFERENCES clientes(dni)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_participaciones_kart FOREIGN KEY (numero_matricula)
        REFERENCES karts(numero_matricula)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT uq_participaciones_carrera_cliente UNIQUE (id_carrera, dni_cliente)
);

CREATE TABLE resultados (
    id_resultado INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_carrera INT UNSIGNED NOT NULL,
    dni_cliente VARCHAR(20) NOT NULL,
    numero_matricula VARCHAR(30) NOT NULL,
    posicion INT UNSIGNED NOT NULL,
    tiempo_total VARCHAR(12) NOT NULL,
    puntos INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_resultados_carrera FOREIGN KEY (id_carrera)
        REFERENCES carreras(id_carrera)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_resultados_cliente FOREIGN KEY (dni_cliente)
        REFERENCES clientes(dni)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_resultados_kart FOREIGN KEY (numero_matricula)
        REFERENCES karts(numero_matricula)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- =============================================
-- INDICES
-- =============================================

CREATE INDEX idx_clientes_nombre ON clientes(nombre, apellido1);
CREATE INDEX idx_karts_pista_activo ON karts(pista, activo);
CREATE INDEX idx_reservas_fecha_pista ON reservas(fecha_reserva, id_pista);
CREATE INDEX idx_reservas_estado_fecha ON reservas(estado, fecha_reserva);
CREATE INDEX idx_carreras_fecha_estado ON carreras(fecha_carrera, estado);
CREATE INDEX idx_participaciones_carrera ON participaciones_carrera(id_carrera, dni_cliente);
CREATE INDEX idx_resultados_carrera_posicion ON resultados(id_carrera, posicion);

-- =============================================
-- TRIGGERS
-- =============================================

DELIMITER $$

CREATE TRIGGER trg_karts_validate_insert
BEFORE INSERT ON karts
FOR EACH ROW
BEGIN
    IF NEW.activo NOT IN (0, 1) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El campo activo en karts solo admite 0 o 1';
    END IF;

    IF NEW.fecha_proximo_mantenimiento < NEW.fecha_ultimo_mantenimiento THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La fecha de proximo mantenimiento no puede ser menor que la de ultimo mantenimiento';
    END IF;
END$$

CREATE TRIGGER trg_karts_validate_update
BEFORE UPDATE ON karts
FOR EACH ROW
BEGIN
    IF NEW.activo NOT IN (0, 1) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El campo activo en karts solo admite 0 o 1';
    END IF;

    IF NEW.fecha_proximo_mantenimiento < NEW.fecha_ultimo_mantenimiento THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La fecha de proximo mantenimiento no puede ser menor que la de ultimo mantenimiento';
    END IF;
END$$

CREATE TRIGGER trg_tarifas_validate_insert
BEFORE INSERT ON tarifas
FOR EACH ROW
BEGIN
    IF NEW.precio_por_persona < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El precio por persona no puede ser negativo';
    END IF;

    IF NEW.activa NOT IN (0, 1) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El campo activa en tarifas solo admite 0 o 1';
    END IF;
END$$

CREATE TRIGGER trg_tarifas_validate_update
BEFORE UPDATE ON tarifas
FOR EACH ROW
BEGIN
    IF NEW.precio_por_persona < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El precio por persona no puede ser negativo';
    END IF;

    IF NEW.activa NOT IN (0, 1) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El campo activa en tarifas solo admite 0 o 1';
    END IF;
END$$

CREATE TRIGGER trg_reservas_no_solape_insert
BEFORE INSERT ON reservas
FOR EACH ROW
BEGIN
    DECLARE v_conflict INT DEFAULT 0;

    IF NEW.hora_fin <= NEW.hora_inicio THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Hora fin debe ser mayor que hora inicio';
    END IF;

    IF NEW.descuento < 0 OR NEW.descuento > 100 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El descuento debe estar entre 0 y 100';
    END IF;

    -- Solo se puede reservar con tarifa activa.
    IF NOT EXISTS (
        SELECT 1
        FROM tarifas t
        WHERE t.nombre = NEW.tarifa
          AND t.activa = 1
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La tarifa no existe o esta inactiva';
    END IF;

    -- Bloqueo de solape por pista y franja horaria, ignorando reservas canceladas.
    SELECT COUNT(*) INTO v_conflict
    FROM reservas r
    WHERE r.id_pista = NEW.id_pista
      AND r.fecha_reserva = NEW.fecha_reserva
      AND r.estado <> 'Cancelada'
      AND NEW.hora_inicio < r.hora_fin
      AND NEW.hora_fin > r.hora_inicio;

    IF v_conflict > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Existe solape de reserva en la pista y horario indicado';
    END IF;
END$$

CREATE TRIGGER trg_reservas_no_solape_update
BEFORE UPDATE ON reservas
FOR EACH ROW
BEGIN
    DECLARE v_conflict INT DEFAULT 0;

    IF NEW.hora_fin <= NEW.hora_inicio THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Hora fin debe ser mayor que hora inicio';
    END IF;

    IF NEW.descuento < 0 OR NEW.descuento > 100 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El descuento debe estar entre 0 y 100';
    END IF;

    IF NOT EXISTS (
        SELECT 1
        FROM tarifas t
        WHERE t.nombre = NEW.tarifa
          AND t.activa = 1
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La tarifa no existe o esta inactiva';
    END IF;

    SELECT COUNT(*) INTO v_conflict
    FROM reservas r
    WHERE r.id_reserva <> NEW.id_reserva
      AND r.id_pista = NEW.id_pista
      AND r.fecha_reserva = NEW.fecha_reserva
      AND r.estado <> 'Cancelada'
      AND NEW.hora_inicio < r.hora_fin
      AND NEW.hora_fin > r.hora_inicio;

    IF v_conflict > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Existe solape de reserva en la pista y horario indicado';
    END IF;
END$$

CREATE TRIGGER trg_resultados_puntos_insert
BEFORE INSERT ON resultados
FOR EACH ROW
BEGIN
    IF NEW.posicion < 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La posicion debe ser mayor o igual a 1';
    END IF;

    IF NEW.tiempo_total NOT REGEXP '^[0-9]{2}:[0-9]{2}\.[0-9]{3}$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'tiempo_total debe tener formato mm:ss.SSS';
    END IF;

    SET NEW.puntos = CASE
        WHEN NEW.posicion = 1 THEN 25
        WHEN NEW.posicion = 2 THEN 18
        WHEN NEW.posicion = 3 THEN 15
        WHEN NEW.posicion = 4 THEN 12
        WHEN NEW.posicion = 5 THEN 10
        WHEN NEW.posicion = 6 THEN 8
        WHEN NEW.posicion = 7 THEN 6
        WHEN NEW.posicion = 8 THEN 4
        WHEN NEW.posicion = 9 THEN 2
        WHEN NEW.posicion = 10 THEN 1
        ELSE 0
    END;
END$$

CREATE TRIGGER trg_resultados_puntos_update
BEFORE UPDATE ON resultados
FOR EACH ROW
BEGIN
    IF NEW.posicion < 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La posicion debe ser mayor o igual a 1';
    END IF;

    IF NEW.tiempo_total NOT REGEXP '^[0-9]{2}:[0-9]{2}\.[0-9]{3}$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'tiempo_total debe tener formato mm:ss.SSS';
    END IF;

    SET NEW.puntos = CASE
        WHEN NEW.posicion = 1 THEN 25
        WHEN NEW.posicion = 2 THEN 18
        WHEN NEW.posicion = 3 THEN 15
        WHEN NEW.posicion = 4 THEN 12
        WHEN NEW.posicion = 5 THEN 10
        WHEN NEW.posicion = 6 THEN 8
        WHEN NEW.posicion = 7 THEN 6
        WHEN NEW.posicion = 8 THEN 4
        WHEN NEW.posicion = 9 THEN 2
        WHEN NEW.posicion = 10 THEN 1
        ELSE 0
    END;
END$$

DELIMITER ;

-- =============================================
-- DATOS SEMILLA
-- =============================================

INSERT INTO clientes (
    dni, nombre, apellido1, apellido2, foto, telefono, email, direccion, fecha_renovacion
) VALUES (
    'ANONIMO', 'Anonimo', 'Privado', NULL, NULL, '000000000', 'anonimo@local', NULL, '2099-12-31'
);

-- =============================================
-- PROCEDIMIENTO DE PRIVACIDAD (CLIENTES)
-- =============================================

DELIMITER $$

CREATE PROCEDURE sp_eliminar_cliente_privacidad(IN p_dni VARCHAR(20))
BEGIN
    IF p_dni = 'ANONIMO' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se puede eliminar ni anonimizar el cliente generico';
    END IF;

    IF NOT EXISTS (SELECT 1 FROM clientes c WHERE c.dni = p_dni) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El cliente no existe';
    END IF;

    -- Reasignar historico al cliente generico.
    UPDATE reservas
    SET dni_cliente = 'ANONIMO'
    WHERE dni_cliente = p_dni;

    UPDATE participaciones_carrera
    SET dni_cliente = 'ANONIMO'
    WHERE dni_cliente = p_dni;

    UPDATE resultados
    SET dni_cliente = 'ANONIMO'
    WHERE dni_cliente = p_dni;

    -- Anonimizar datos del cliente original conservando su PK para trazabilidad tecnica.
    UPDATE clientes
    SET nombre = 'Anonimizado',
        apellido1 = 'Privado',
        apellido2 = NULL,
        foto = NULL,
        telefono = '000000000',
        email = CONCAT('anon+', REPLACE(dni, ' ', ''), '@local'),
        direccion = NULL,
        updated_at = CURRENT_TIMESTAMP
    WHERE dni = p_dni;
END$$

DELIMITER ;

-- Uso recomendado para privacidad:
-- CALL sp_eliminar_cliente_privacidad('12345678A');
