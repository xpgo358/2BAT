-- Base de Datos: Karting XP
-- Crear base de datos
CREATE DATABASE IF NOT EXISTS karting_xp CHARACTER SET utf8 COLLATE utf8_general_ci;
USE karting_xp;

-- Tabla Clientes
CREATE TABLE clientes (
    DNI VARCHAR(20) PRIMARY KEY,
    NumLicencia VARCHAR(50) UNIQUE NOT NULL,
    Nombre VARCHAR(100) NOT NULL,
    Ape1 VARCHAR(100) NOT NULL,
    Ape2 VARCHAR(100),
    Telefono VARCHAR(20),
    Email VARCHAR(100),
    Direccion VARCHAR(255),
    FechaRenovacion DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla Pistas
CREATE TABLE pistas (
    IDPista INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Direccion VARCHAR(255),
    Descripcion TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla Tarifas
CREATE TABLE tarifas (
    IDTarifa INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    PrecioPorPersona DECIMAL(10,2) NOT NULL,
    Activa TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla Reservas
CREATE TABLE reservas (
    IDReserva INT AUTO_INCREMENT PRIMARY KEY,
    NumLicencia VARCHAR(50) NOT NULL,
    IDPista INT NOT NULL,
    FechaReserva DATE NOT NULL,
    HoraInicio TIME NOT NULL,
    HoraFin TIME NOT NULL,
    Personas INT NOT NULL,
    IDTarifa INT NOT NULL,
    Descuento DECIMAL(5,2) DEFAULT 0,
    Estado VARCHAR(50) DEFAULT 'Reservada',
    FOREIGN KEY (NumLicencia) REFERENCES clientes(NumLicencia),
    FOREIGN KEY (IDPista) REFERENCES pistas(IDPista),
    FOREIGN KEY (IDTarifa) REFERENCES tarifas(IDTarifa),
    UNIQUE KEY unique_pista_franja (IDPista, FechaReserva, HoraInicio, HoraFin)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Cliente genérico para anonimización
INSERT INTO clientes (DNI, NumLicencia, Nombre, Ape1, Ape2, Telefono, Email, Direccion, FechaRenovacion)
VALUES ('ANONIMO', 'LIC-ANONIMO', 'Anonimo', 'Privado', '', '', '', '', NULL);

-- Índices
CREATE INDEX idx_cliente_dni ON clientes(DNI);
CREATE INDEX idx_cliente_nombre ON clientes(Nombre);
CREATE INDEX idx_reserva_licencia ON reservas(NumLicencia);
CREATE INDEX idx_reserva_fecha ON reservas(FechaReserva);
