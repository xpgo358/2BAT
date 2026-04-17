# Definicion funcional de la web

## Objetivo
Definir el comportamiento minimo de la aplicacion web del proyecto CRUD de karts.

## Base CRUD (alineado con README)
La web debe implementar en todos los modulos:

- CREATE: crear registros con validaciones.
- READ: listar, filtrar, buscar y ver detalle.
- UPDATE: editar registros existentes.
- DELETE: eliminar con confirmacion (baja logica o fisica segun modulo).

Modulos incluidos:
- Clientes
- Pistas
- Karts
- Tarifas
- Reservas
- Carreras
- Corredores
- Resultados

## Funcionalidad nueva 1: licencia de conductor en PDF

### Origen
Modulo `Clientes`.

### Datos obligatorios
- Nombre
- Apellidos
- Foto
- DNI
- Fecha de renovacion

### Flujo de usuario
1. El usuario abre la ficha del cliente.
2. Pulsa `Generar licencia`.
3. Se muestra una vista previa del documento.
4. La web solicita accion de impresion con boton `Imprimir licencia`.
5. Se descarga/abre un PDF listo para imprimir.

### Requisitos del documento
- Documento basico tipo licencia.
- Mantener estilo de la web (tipografia, colores, jerarquia visual).
- Incluir logo o cabecera del centro (si existe en la web).
- Formato recomendado: A4 vertical.

## Funcionalidad nueva 2: resultados de carrera en PDF

### Origen
Modulo `Carreras` o `Resultados`.

### Datos de cabecera obligatorios
- Carrera (ID o nombre)
- Nombre de carrera (si existe)
- Fecha
- Hora
- Pista

### Datos de resultados obligatorios
- Piloto (nombre o DNI segun disponibilidad)
- Kart
- Posicion
- Tiempo
- Puntos

### Flujo de usuario
1. El usuario abre la carrera o su tabla de resultados.
2. Pulsa `Generar PDF de resultados`.
3. Se muestra vista previa.
4. La web solicita accion de impresion con boton `Imprimir resultados`.
5. Se descarga/abre un PDF listo para imprimir.

### Requisitos del documento
- Diseño coherente con la web.
- Tabla clara y ordenada por posicion.
- Formato recomendado: A4 horizontal cuando haya muchas columnas.

## Reglas tecnicas minimas
- Generar ambos documentos desde backend PHP.
- Usar una plantilla base comun para no duplicar estilos.
- Sanitizar todos los datos antes de imprimir en PDF.
- Si falta algun dato obligatorio, bloquear la generacion y mostrar error claro.

## Criterios de aceptacion
- Existe CRUD funcional base por modulo (definido en README).
- Se puede generar e imprimir licencia de conductor en PDF.
- Se puede generar e imprimir PDF de resultados por carrera.
- Ambos PDFs mantienen estilo visual consistente con la web.
