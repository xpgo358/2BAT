# Sistema de Gestión de Karting XP (CRUD)

## 1) Objetivo del programa

Crear una aplicación CRUD para gestionar un karting usando:

- Frontend: **HTML, CSS, JavaScript**
- Backend: **PHP** (entorno **XAMPP**)
- Base de datos: **MySQL** (gestionada con **phpMyAdmin**)

El sistema permitirá crear, consultar, editar y eliminar información de pistas, clientes, reservas, karts, carreras, corredores y vueltas.

---

## 2) Tablas principales previstas

- `pistas`
- `clientes`
- `tarifas`
- `reservas`
- `karts`
- `carreras`
- `corredores` (por carrera)
- `vueltas` (por carrera)

---

## 3) Diseño inicial de tablas

### 3.1 Tabla `pistas`

Campos:

1. `codPista` (**clave primaria**)
2. `nombre`
3. `direccion`
4. `fecha_mantenimiento`

Notas:

- `codPista` identifica de forma única cada pista.
- `fecha_mantenimiento` almacena la fecha del último mantenimiento.

### 3.2 Tabla `clientes`

Campos:

1. `dni` (**clave primaria**)
2. `nombre`
3. `ap1`
4. `ap2`
5. `foto`
6. `telefono`
7. `email`
8. `direccion`
9. `fecha_renovacion`

Notas:

- `dni` identifica de forma única al cliente.
- `foto` guardará la ruta o nombre del archivo de imagen.
- `fecha_renovacion` representa la fecha de renovación del cliente.

### 3.3 Tabla `reservas`

Campos:

1. `num_reserva` (**clave primaria**)
2. `dni` (**clave foránea** → `clientes.dni`)
3. `codPista` (**clave foránea** → `pistas.codPista`)
4. `fecha`
5. `hora_inicio`
6. `duracion`
7. `personas`
8. `tarifa`
9. `precio_por_persona` (automático, tomado de la tarifa)
10. `precio_inicial` (automático, calculado a partir de personas y precio por persona)
11. `descuento`
12. `precio_final` (automático, calculado)

Notas:

- `num_reserva` identifica de forma única cada reserva.
- `dni` enlaza la reserva con el cliente.
- `codPista` enlaza la reserva con la pista.
- `personas` indica el número de participantes incluidos en la reserva.
- `tarifa` indica el tipo de tarifa aplicado a la reserva (por ejemplo: normal, fin de semana, nocturna, etc.).
- `precio_por_persona` no se introduce manualmente: se obtiene automáticamente según la tarifa seleccionada.
- `precio_inicial` se calcula automáticamente: $precio\_inicial = personas \cdot precio\_por\_persona$
- `precio_final` se calcula automáticamente aplicando el descuento al precio inicial.
- Fórmula propuesta: $precio\_final = precio\_inicial - (precio\_inicial \cdot descuento/100)$

### 3.4 Tabla `tarifas`

Campos:

1. `tarifa` (**clave primaria**)
2. `precio`

Notas:

- `tarifa` identifica el tipo de tarifa (por ejemplo: normal, fin de semana, nocturna).
- `precio` representa el precio por persona asociado a esa tarifa.

### 3.5 Tabla `karts`

Campos:

1. `num_kart` (**clave primaria**)
2. `fecha_mantenimiento`

Notas:

- `num_kart` identifica de forma única cada kart.
- `fecha_mantenimiento` almacena la fecha del último mantenimiento del kart.

### 3.6 Tabla `carreras`

Campos:

1. `num_carrera` (**clave primaria**)
2. `codPista` (**clave foránea** → `pistas.codPista`)
3. `num_reserva` (**clave foránea** → `reservas.num_reserva`)

Notas:

- `num_carrera` identifica de forma única cada carrera.
- `codPista` indica en qué pista se disputa la carrera.
- `num_reserva` enlaza la carrera con la reserva que la origina.

### 3.7 Tabla `corredores` (global, por carrera)

> Decisión: **no** crear tablas nuevas por cada carrera. Se usará una tabla global.

Campos:

1. `num_carrera` (**clave foránea** → `carreras.num_carrera`)
2. `dni` (**clave foránea** → `clientes.dni`)
3. `num_kart` (**clave foránea** → `karts.num_kart`)

Clave primaria compuesta:

- (`num_carrera`, `dni`)

Restricciones recomendadas:

- `UNIQUE (num_carrera, num_kart)` para evitar que el mismo kart se asigne a dos corredores en la misma carrera.

Notas:

- Esta tabla define qué clientes participan en cada carrera y qué kart lleva cada uno.

### 3.8 Tabla `vueltas` (global, por carrera)

> Decisión: **no** crear tablas nuevas por cada carrera. Se usará una tabla global.

Campos:

1. `num_carrera`
2. `num_kart`
3. `num_vuelta`
4. `tiempo`

Clave primaria compuesta:

- (`num_carrera`, `num_kart`, `num_vuelta`)

Relaciones recomendadas:

- Clave foránea compuesta (`num_carrera`, `num_kart`) → `corredores` (`num_carrera`, `num_kart`)

Notas:

- Cada registro representa el tiempo de una vuelta concreta de un kart en una carrera.
- `num_vuelta` empieza en 1 y aumenta de forma secuencial por kart dentro de cada carrera.

---

## 4) Siguiente paso

En el siguiente paso prepararemos el script SQL de creación de base de datos y tablas.
