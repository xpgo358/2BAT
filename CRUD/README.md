# CRUD Sitio de Karts

## Objetivo
Aplicacion CRUD para gestionar un sitio de karts con las siguientes entidades:

- Clientes
- Pistas
- Karts
- Tarifas
- Reservas
- Carreras
- Corredores
- Resultados

## Alcance funcional
Cada entidad debe cubrir operaciones CRUD:

- Create: alta de registros
- Read: consulta y listado
- Update: modificacion de datos
- Delete: baja logica o eliminacion segun el caso

## Funciones basicas CRUD (definicion)

- CREATE
    - Alta de nuevos registros con validacion de campos obligatorios.
    - Debe devolver confirmacion de guardado o errores por campo.
- READ
    - Listado paginado con busqueda y filtros por cada entidad.
    - Vista detalle de cada registro con sus datos relacionados.
- UPDATE
    - Edicion de registros existentes con formulario precargado.
    - Reutiliza validaciones de CREATE y registra el cambio.
- DELETE
    - Eliminacion con confirmacion previa.
    - Puede ser baja logica o eliminacion/anonimizado segun reglas de negocio.

## Reglas generales de validacion
- Todos los campos obligatorios deben validarse antes de guardar.
- El correo debe tener formato valido.
- El telefono debe tener formato valido.
- El DNI se valida como texto libre (sin formato estricto).
- El descuento en reservas debe estar entre 0 y 100.
- No se permiten reservas solapadas en la misma pista y franja horaria.
- La foto de cliente se guarda como ruta/URL en base de datos y el archivo en carpeta del proyecto.
- Ruta de archivos de foto: `uploads/clientes/`.
- DELETE de Karts y Tarifas se hace con baja logica.
- DELETE de Clientes aplica privacidad: se reasignan referencias al cliente generico y se eliminan/anominizan datos personales.
- Datos anonimizados al eliminar cliente: nombre, apellidos, foto, telefono, email y direccion.
- Cliente generico para reasignaciones: DNI `ANONIMO`, nombre `Anonimo`, apellido1 `Privado`, resto vacio.
- `tiempo_total` en Resultados se guarda como texto en formato `mm:ss.SSS`.
- Los puntos en Resultados se calculan automaticamente segun la posicion.
- Flujo de estados en reservas: Reservada -> En curso -> Completada, o Cancelada, o No presentada.
- Relacion negocio actual: una carrera referencia una reserva; una reserva puede estar referenciada por varias carreras.
- Estado inicial por defecto en reservas: `Reservada`.
- En nuevas reservas solo se pueden usar tarifas activas.
- Un kart inactivo mantiene su historico en resultados (solo lectura).

## Convenciones SQL
- Precios: `DECIMAL(10,2)`.
- Fechas: tipo `DATE`.
- Horas: tipo `TIME`.
- En `database/schema.sql` solo se define estructura: tablas, PK, FK y UNIQUE.
- Validaciones de negocio, historicos por DNI, privacidad, calculos y reglas de estados se implementan en PHP (capa web).

---

## 1. Entidad: CLIENTES

### Campos
- `dni` (PK)
- `nombre`
- `apellido1`
- `apellido2`
- `foto`
- `telefono`
- `email`
- `direccion`
- `fecha_renovacion`

### CREATE
- [ ] Formulario con todos los campos del cliente.
- [ ] Validar DNI unico.
- [ ] Validar formato de email.
- [ ] Validar telefono.
- [ ] Permitir subir foto.
- [ ] Guardar registro.

### READ
- [ ] Listado de clientes.
- [ ] Mostrar: DNI, nombre, apellidos, telefono, email.
- [ ] Vista detalle con foto y direccion.
- [ ] Busqueda por DNI o nombre.

### UPDATE
- [ ] Formulario precargado.
- [ ] Editar todos los campos.
- [ ] Mantener validaciones de CREATE.
- [ ] Permitir cambiar foto.

### DELETE
- [ ] Eliminar cliente con politica de privacidad.
- [ ] Reasignar en reservas/resultados al cliente generico antes de eliminar/anomizar.
- [ ] Anonimizar: nombre, apellidos, foto, telefono, email y direccion.
- [ ] Confirmacion previa obligatoria.

---

## 2. Entidad: KARTS

### Campos
- `numero_matricula` (PK)
- `pista`
- `fecha_ultimo_mantenimiento`
- `fecha_proximo_mantenimiento`
- `observaciones`
- `activo` (baja logica)

### CREATE
- [ ] Formulario con matricula, pista, fechas y observaciones.
- [ ] Validar matricula unica.
- [ ] Guardar registro.

### READ
- [ ] Listado de karts.
- [ ] Mostrar: matricula, pista, ultimo mantenimiento, proximo mantenimiento.
- [ ] Busqueda por matricula.
- [ ] Filtro por pista.

### UPDATE
- [ ] Formulario precargado.
- [ ] Editar pista, fechas y observaciones.
- [ ] Guardar cambios.

### DELETE
- [ ] Baja logica de kart (`activo = 0`) con confirmacion.
- [ ] Actualizar listado.

---

## 3. Entidad: PISTAS

### Campos
- `id_pista` (PK)
- `nombre` (unico)

### CREATE
- [ ] Formulario con nombre de pista.
- [ ] Validar nombre unico.
- [ ] Guardar registro.

### READ
- [ ] Listado de pistas.
- [ ] Mostrar: ID pista, nombre.
- [ ] Busqueda por nombre.

### UPDATE
- [ ] Formulario precargado.
- [ ] Editar nombre.
- [ ] Guardar cambios.

### DELETE
- [ ] Eliminar pista con confirmacion si no tiene referencias activas.
- [ ] Actualizar listado.

---

## 4. Entidad: TARIFAS

### Campos
- `nombre` (PK)
- `precio_por_persona`
- `activa` (baja logica)

### CREATE
- [ ] Formulario con nombre y precio por persona.
- [ ] Validar nombre unico.
- [ ] Guardar registro.

### READ
- [ ] Listado de tarifas.
- [ ] Mostrar: nombre, precio por persona.
- [ ] Busqueda por nombre.

### UPDATE
- [ ] Formulario precargado.
- [ ] Editar nombre y precio por persona.
- [ ] Guardar cambios.

### DELETE
- [ ] Baja logica de tarifa (`activa = 0`) con confirmacion.
- [ ] Actualizar listado.

---

## 5. Entidad: RESERVAS

### Campos
- `id_reserva` (PK)
- `dni_cliente` (FK -> clientes.dni)
- `tarifa` (FK -> tarifas.nombre)
- `id_pista` (FK -> pistas.id_pista)
- `fecha_reserva`
- `hora_inicio`
- `hora_fin`
- `estado` (Reservada, En curso, Completada, Cancelada, No presentada)
- `descuento` (porcentaje descontado 0-100)

### CREATE
- [ ] Formulario con DNI cliente, pista, tarifa, fecha, hora inicio, hora fin, estado y descuento (%).
- [ ] Validar que exista el cliente.
- [ ] Validar que exista la tarifa.
- [ ] Permitir seleccionar solo tarifas activas.
- [ ] Validar que exista la pista.
- [ ] Validar descuento entre 0 y 100.
- [ ] Validar que no haya solape horario en la misma pista.
- [ ] Validar flujo de estado: Reservada -> En curso -> Completada/Cancelada/No presentada.
- [ ] Estado por defecto al crear: Reservada.
- [ ] Guardar registro.

### READ
- [ ] Listado de reservas.
- [ ] Mostrar: ID reserva, DNI cliente, pista, tarifa, fecha, hora inicio, hora fin, estado, descuento (%).
- [ ] Busqueda por ID reserva o DNI cliente.
- [ ] Filtros por fecha y estado.

### UPDATE
- [ ] Formulario precargado.
- [ ] Editar pista, fecha, horas, estado, tarifa y descuento.
- [ ] Guardar cambios.

### DELETE
- [ ] Cancelar reserva (baja logica) cambiando estado a Cancelada.
- [ ] Confirmacion previa.

### Regla de calculo
Precio final:

$$
precio\_final = precio\_por\_persona - \left(precio\_por\_persona \times \frac{descuento}{100}\right)
$$

`precio_final` se calcula al vuelo y no se guarda en la base de datos.

---

## 6. Entidad: CARRERAS

### Campos
- `id_carrera` (PK)
- `id_reserva` (FK -> reservas.id_reserva)
- `nombre_carrera`
- `fecha_carrera`
- `hora_inicio`
- `pista`
- `estado` (Programada, En curso, Finalizada, Cancelada)

### CREATE
- [ ] Formulario con reserva, nombre, fecha, hora, pista y estado.
- [ ] Validar que exista la reserva seleccionada.
- [ ] Guardar registro.

### READ
- [ ] Listado de carreras.
- [ ] Mostrar: ID, reserva, nombre, fecha, hora, pista, estado.
- [ ] Busqueda por nombre o ID.
- [ ] Filtros por estado y fecha.

### UPDATE
- [ ] Formulario precargado.
- [ ] Editar reserva, nombre, fecha, hora, pista y estado.
- [ ] Guardar cambios.

### DELETE
- [ ] Eliminar o cancelar carrera con confirmacion.
- [ ] Actualizar listado.

---

## 7. Entidad: CORREDORES

### Objetivo
- Relacionar en cada carrera que cliente corre con que kart.
- Evitar duplicados de cliente y kart dentro de la misma carrera.

### Campos
- `id_carrera` (FK -> carreras.id_carrera)
- `dni` (FK -> clientes.dni)
- `matricula` (FK -> karts.numero_matricula)

Clave principal:
- PK compuesta: (`id_carrera`, `dni`)

### Reglas
- No repetir `id_carrera + dni`.
- No repetir `id_carrera + matricula`.
- El numero de kart se asigna manualmente desde el CRUD.
- Las validaciones se aplican en backend PHP (no en triggers SQL).

### CREATE
- [ ] Registrar corredor con carrera, cliente y kart.
- [ ] Validar existencia de carrera, cliente y kart.
- [ ] Validar que no se repita `id_carrera + dni`.
- [ ] Validar que no se repita `id_carrera + matricula`.

### READ
- [ ] Listado por carrera de participantes y karts.

### UPDATE
- [ ] Permitir cambio de kart o cliente en un corredor.
- [ ] Revalidar que no se repita `id_carrera + dni`.
- [ ] Revalidar que no se repita `id_carrera + matricula`.

### DELETE
- [ ] Eliminar corredor con confirmacion.

---

## 8. Entidad: RESULTADOS

### Campos
- `id_resultado` (PK)
- `id_carrera` (FK -> carreras.id_carrera)
- `dni_cliente` (FK -> clientes.dni)
- `numero_matricula` (FK -> karts.numero_matricula)
- `posicion`
- `tiempo_total` (formato `mm:ss.SSS`)
- `puntos`

Nota: en la siguiente iteracion, Resultados se ajustara para referenciar `corredores`.

### CREATE
- [ ] Registrar resultado de un piloto en una carrera.
- [ ] Validar existencia de carrera, cliente y kart.
- [ ] Calcular puntos automaticamente segun la posicion (en PHP).
- [ ] Guardar registro.

### Tabla de puntos
- [ ] 1º = 25
- [ ] 2º = 18
- [ ] 3º = 15
- [ ] 4º = 12
- [ ] 5º = 10
- [ ] 6º = 8
- [ ] 7º = 6
- [ ] 8º = 4
- [ ] 9º = 2
- [ ] 10º = 1
- [ ] Del 11º en adelante = 0

### READ
- [ ] Listado de resultados.
- [ ] Mostrar: carrera, piloto, kart, posicion, tiempo, puntos.
- [ ] Mantener visibles resultados historicos aunque el kart este inactivo.
- [ ] Filtros por carrera y piloto.
- [ ] Consulta de historico por DNI (carreras y resultados).

### UPDATE
- [ ] Editar posicion y tiempo.
- [ ] Recalcular puntos automaticamente si cambia la posicion.
- [ ] Guardar cambios.

### DELETE
- [ ] Eliminar resultado con confirmacion.
- [ ] Actualizar listado.

### Consulta de historico por DNI
- Se implementa desde PHP con consultas SQL sobre `corredores`, `carreras`, `resultados`, `clientes` y `karts`.
- Filtro principal: `dni`.
- Orden recomendado: fecha/hora de carrera descendente.

---

## Tecnologias
- Frontend: HTML, CSS, JavaScript
- Backend: PHP (XAMPP)
- Base de datos: MySQL (XAMPP)

## Estructura recomendada
```text
CRUD/
|-- README.md
|-- frontend/
|   |-- index.html
|   |-- style.css
|   `-- script.js
|-- backend/
|   `-- (archivos del servidor)
`-- database/
    `-- (scripts SQL)
```

## Definicion de la web

### Tipo de web
- Aplicacion web de administracion interna (panel de gestion).
- Sin autenticacion en esta fase.
- Uso principal en escritorio, adaptada tambien a movil.

### Estructura de navegacion
- Barra lateral fija con modulos: Dashboard, Clientes, Pistas, Karts, Tarifas, Reservas, Carreras, Resultados.
- Barra superior con buscador global y accesos rapidos.
- Migas de pan para indicar la ruta actual.

### Paginas

#### 1. Dashboard
- Tarjetas resumen: clientes activos, karts activos, reservas del dia, carreras programadas.
- Tabla de actividad reciente (ultimas altas/cambios).
- Alertas: mantenimientos proximos y reservas en conflicto.

#### 2. Listado por entidad
- Una pagina por entidad con tabla principal.
- Buscador por texto y filtros por estado/fecha cuando aplique.
- Botones de accion por fila: ver, editar, eliminar/cancelar.
- Boton crear nuevo registro visible en cabecera.

#### 3. Formulario Crear/Editar
- Formulario unico por entidad reutilizado para alta y edicion.
- Validacion en cliente antes de enviar.
- Mensajes claros de error y confirmacion.
- Campos obligatorios marcados visualmente.

#### 4. Vista detalle
- Ficha completa de registro con datos relacionados.
- Historial basico de cambios de estado cuando aplique (reservas/carreras).

#### 5. Licencias de conductor (PDF)
- Generar licencia de conductor desde el modulo de Clientes.
- Datos minimos en licencia: nombre, apellidos, foto, DNI, fecha de renovacion.
- Accion obligatoria al finalizar: boton "Imprimir licencia".
- Salida: PDF basico con estilo visual coherente con la web (colores y tipografia).
- El PDF debe poder abrirse en vista previa antes de imprimir.

#### 6. Informe de resultados por carrera (PDF)
- Generar un PDF por carrera desde el modulo de Carreras/Resultados.
- Datos de cabecera: carrera (ID o nombre), fecha, hora, pista.
- Datos adicionales: nombre de carrera (si existe).
- Cuerpo del informe: tabla de resultados (piloto, kart, posicion, tiempo, puntos).
- Accion obligatoria al finalizar: boton "Imprimir resultados".
- Salida: PDF con el mismo estilo base de la web.

### Componentes comunes
- Tabla reutilizable con paginacion, orden y filtros.
- Modal de confirmacion para acciones sensibles.
- Toasts de exito/error.
- Selector de fecha/hora para reservas y carreras.
- Selector de estado con transiciones permitidas.
- Plantilla PDF reutilizable para documentos de licencia y resultados.

### Reglas UX
- No perder cambios sin confirmar: aviso al salir de formularios editados.
- Acciones destructivas siempre con doble confirmacion.
- Estados inactivos/cancelados visibles con etiqueta de color.
- En listados, por defecto mostrar activos y permitir filtro para historico.

### Diseño visual
- Estilo limpio y deportivo inspirado en karting.
- Colores base propuestos:
    - Fondo: gris muy claro.
    - Primario: rojo carrera.
    - Secundario: naranja atardecer.
    - Exito/alerta/error: verde, ambar, rojo.
- Tipografia recomendada: Orbitron (titulos) + Raleway (texto).
    - Usar tipografia de google fonts
- Iconografia consistente por modulo.
    - Pocos iconos, pero interfaz intuitiva.

### Responsive
- Escritorio: layout con sidebar + contenido.
- Tablet: sidebar colapsable.
- Movil: en principio, no soporte.

### Flujo principal de uso
1. Crear pistas, tarifas y karts. (pocas veces, asi que poca importancia)
2. Registrar clientes.
3. Crear reservas (controlando solapes).
4. Crear carreras vinculadas a reserva.
5. Cargar resultados y calcular puntos.

### Mensajes y feedback
- Confirmacion de guardado en cada alta/edicion.
- Error explicito de solape en reservas indicando tramo y pista.
- Aviso cuando una tarifa inactiva no puede seleccionarse.
- Aviso cuando un cliente se elimina con politica de anonimizado.

## Orden de implementacion recomendado
1. Clientes
2. Pistas
3. Karts
4. Tarifas
5. Reservas
6. Carreras
7. Corredores
8. Resultados
