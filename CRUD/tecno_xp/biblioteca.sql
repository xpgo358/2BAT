DROP DATABASE IF EXISTS tecno_xp;
CREATE DATABASE tecno_xp CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE tecno_xp;

CREATE TABLE usuarios (
  id_usuario VARCHAR(12) NOT NULL,
  nombre VARCHAR(40) NOT NULL,
  ape1 VARCHAR(40) NOT NULL,
  ape2 VARCHAR(40) DEFAULT NULL,
  grupo VARCHAR(20) NOT NULL,
  PRIMARY KEY (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE dispositivos (
  cod_dispositivo VARCHAR(20) NOT NULL,
  nombre_dispositivo VARCHAR(60) NOT NULL,
  tipo VARCHAR(40) NOT NULL,
  estado VARCHAR(20) NOT NULL,
  imagen VARCHAR(120) DEFAULT NULL,
  PRIMARY KEY (cod_dispositivo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE reservas (
  cod_usuario VARCHAR(12) NOT NULL,
  cod_dispositivo VARCHAR(20) NOT NULL,
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  estado VARCHAR(20) NOT NULL,
  PRIMARY KEY (cod_usuario, cod_dispositivo, fecha_inicio),
  KEY idx_reserva_dispositivo (cod_dispositivo),
  CONSTRAINT fk_reserva_usuario FOREIGN KEY (cod_usuario) REFERENCES usuarios(id_usuario),
  CONSTRAINT fk_reserva_dispositivo FOREIGN KEY (cod_dispositivo) REFERENCES dispositivos(cod_dispositivo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios (id_usuario, nombre, ape1, ape2, grupo) VALUES
('1111A', 'Alberto', 'Ruiz', 'Martinez', '2BAC'),
('2222B', 'Marta', 'Lopez', 'Gil', '1SMR');

INSERT INTO dispositivos (cod_dispositivo, nombre_dispositivo, tipo, estado, imagen) VALUES
('PORT-01', 'Portatil Lenovo', 'Portatil', 'disponible', NULL),
('TAB-02', 'Tablet Samsung', 'Tablet', 'disponible', NULL);

INSERT INTO reservas (cod_usuario, cod_dispositivo, fecha_inicio, fecha_fin, estado) VALUES
('1111A', 'PORT-01', '2026-05-07', '2026-05-10', 'activa');
