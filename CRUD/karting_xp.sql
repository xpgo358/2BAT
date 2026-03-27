-- =========================================================
-- KARTING - Esquema SQL (MySQL/MariaDB para XAMPP)
-- Importar este archivo desde phpMyAdmin.
-- =========================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP DATABASE IF EXISTS karting_xp;
CREATE DATABASE karting_xp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE karting_xp;

-- =========================
-- 1) PISTAS
-- =========================
CREATE TABLE pistas (
    codPista VARCHAR(20) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(200) NOT NULL,
    fecha_mantenimiento DATE NULL,
    PRIMARY KEY (codPista)
) ENGINE=InnoDB;

-- =========================
-- 2) CLIENTES
-- =========================
CREATE TABLE clientes (
    dni CHAR(9) NOT NULL,
    nombre VARCHAR(80) NOT NULL,
    ap1 VARCHAR(80) NOT NULL,
    ap2 VARCHAR(80) NULL,
    foto VARCHAR(255) NULL,
    telefono VARCHAR(20) NULL,
    email VARCHAR(120) NULL,
    direccion VARCHAR(200) NULL,
    fecha_renovacion DATE NULL,
    PRIMARY KEY (dni),
    UNIQUE KEY uq_clientes_email (email)
) ENGINE=InnoDB;

-- =========================
-- 3) TARIFAS
-- =========================
CREATE TABLE tarifas (
    tarifa VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (tarifa)
) ENGINE=InnoDB;

-- =========================
-- 4) KARTS
-- =========================
CREATE TABLE karts (
    num_kart INT UNSIGNED NOT NULL,
    fecha_mantenimiento DATE NULL,
    PRIMARY KEY (num_kart)
) ENGINE=InnoDB;

-- =========================
-- 5) RESERVAS
-- =========================
CREATE TABLE reservas (
    num_reserva INT UNSIGNED NOT NULL AUTO_INCREMENT,
    dni CHAR(9) NOT NULL,
    codPista VARCHAR(20) NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    duracion SMALLINT UNSIGNED NOT NULL,
    personas TINYINT UNSIGNED NOT NULL,
    tarifa VARCHAR(50) NOT NULL,
    precio_por_persona DECIMAL(10,2) NOT NULL DEFAULT 0,
    precio_inicial DECIMAL(10,2) NOT NULL DEFAULT 0,
    descuento DECIMAL(5,2) NOT NULL DEFAULT 0,
    precio_final DECIMAL(10,2) NOT NULL DEFAULT 0,
    PRIMARY KEY (num_reserva),
    KEY idx_reservas_dni (dni),
    KEY idx_reservas_codPista (codPista),
    KEY idx_reservas_tarifa (tarifa),
    CONSTRAINT fk_reservas_clientes
        FOREIGN KEY (dni) REFERENCES clientes (dni)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_reservas_pistas
        FOREIGN KEY (codPista) REFERENCES pistas (codPista)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_reservas_tarifas
        FOREIGN KEY (tarifa) REFERENCES tarifas (tarifa)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Triggers: precio_por_persona, precio_inicial y precio_final automáticos
DELIMITER $$
CREATE TRIGGER tr_reservas_bi_set_precio
BEFORE INSERT ON reservas
FOR EACH ROW
BEGIN
    DECLARE v_precio DECIMAL(10,2);

    SELECT t.precio INTO v_precio
    FROM tarifas t
    WHERE t.tarifa = NEW.tarifa
    LIMIT 1;

    SET NEW.precio_por_persona = IFNULL(v_precio, 0);
    SET NEW.descuento = IFNULL(NEW.descuento, 0);
    SET NEW.precio_inicial = NEW.personas * NEW.precio_por_persona;
    SET NEW.precio_final = NEW.precio_inicial - (NEW.precio_inicial * NEW.descuento / 100);
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER tr_reservas_bu_set_precio
BEFORE UPDATE ON reservas
FOR EACH ROW
BEGIN
    DECLARE v_precio DECIMAL(10,2);

    SELECT t.precio INTO v_precio
    FROM tarifas t
    WHERE t.tarifa = NEW.tarifa
    LIMIT 1;

    SET NEW.precio_por_persona = IFNULL(v_precio, 0);
    SET NEW.descuento = IFNULL(NEW.descuento, 0);
    SET NEW.precio_inicial = NEW.personas * NEW.precio_por_persona;
    SET NEW.precio_final = NEW.precio_inicial - (NEW.precio_inicial * NEW.descuento / 100);
END$$
DELIMITER ;

-- =========================
-- 6) CARRERAS
-- =========================
CREATE TABLE carreras (
    num_carrera INT UNSIGNED NOT NULL AUTO_INCREMENT,
    codPista VARCHAR(20) NOT NULL,
    num_reserva INT UNSIGNED NOT NULL,
    PRIMARY KEY (num_carrera),
    KEY idx_carreras_codPista (codPista),
    KEY idx_carreras_num_reserva (num_reserva),
    CONSTRAINT fk_carreras_pistas
        FOREIGN KEY (codPista) REFERENCES pistas (codPista)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_carreras_reservas
        FOREIGN KEY (num_reserva) REFERENCES reservas (num_reserva)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =========================
-- 7) CORREDORES (global)
-- =========================
CREATE TABLE corredores (
    num_carrera INT UNSIGNED NOT NULL,
    dni CHAR(9) NOT NULL,
    num_kart INT UNSIGNED NOT NULL,
    PRIMARY KEY (num_carrera, dni),
    UNIQUE KEY uq_corredores_carrera_kart (num_carrera, num_kart),
    KEY idx_corredores_dni (dni),
    KEY idx_corredores_num_kart (num_kart),
    CONSTRAINT fk_corredores_carreras
        FOREIGN KEY (num_carrera) REFERENCES carreras (num_carrera)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_corredores_clientes
        FOREIGN KEY (dni) REFERENCES clientes (dni)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_corredores_karts
        FOREIGN KEY (num_kart) REFERENCES karts (num_kart)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =========================
-- 8) VUELTAS (global)
-- =========================
CREATE TABLE vueltas (
    num_carrera INT UNSIGNED NOT NULL,
    num_kart INT UNSIGNED NOT NULL,
    num_vuelta SMALLINT UNSIGNED NOT NULL,
    tiempo TIME(3) NOT NULL,
    PRIMARY KEY (num_carrera, num_kart, num_vuelta),
    CONSTRAINT fk_vueltas_corredores
        FOREIGN KEY (num_carrera, num_kart)
        REFERENCES corredores (num_carrera, num_kart)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;
