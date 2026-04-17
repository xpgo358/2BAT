# Funcionalidades Web - Definicion

## Objetivo
Este documento sirve para definir que debe poder hacer la web, pantalla por pantalla y modulo por modulo.

## Como usar este documento
- Marcar con [x] cuando una funcionalidad quede definida.
- Marcar con [~] cuando este en discusion.
- Marcar con [ ] cuando aun no este definida.
- En cada funcionalidad, anadir notas cortas si hay reglas especiales.

---

## 1. Reglas globales de la web

### 1.1 Navegacion y estructura
- [ ] Sidebar con modulos: Dashboard, Clientes, Pistas, Karts, Tarifas, Reservas, Carreras, Corredores, Resultados.
- [ ] Header con titulo de seccion y acciones rapidas.
- [ ] Breadcrumb para saber en que pantalla esta el usuario.
- [ ] Buscador global (si/no).

### 1.2 Validaciones y mensajes
- [ ] Validaciones en frontend antes de enviar formulario.
- [ ] Validaciones en backend PHP obligatorias.
- [ ] Mensajes de error claros por campo.
- [ ] Mensajes de exito al guardar/editar/eliminar.
- [ ] Confirmacion previa en acciones sensibles.

### 1.3 Comportamiento general
- [ ] En tablas, paginacion.
- [ ] En tablas, filtros.
- [ ] En tablas, orden por columnas.
- [ ] En formularios, aviso si hay cambios sin guardar.

---

## 2. Dashboard
- [ ] Tarjetas resumen (clientes, reservas del dia, carreras activas, etc.).
- [ ] Alertas importantes (mantenimientos, conflictos de reserva).
- [ ] Actividad reciente.
- [ ] Accesos directos a crear nuevo registro.

Notas:
- 

---

## 3. Modulo Clientes

### 3.1 Listado
- [ ] Ver tabla de clientes.
- [ ] Buscar por DNI, nombre o apellidos.
- [ ] Ver detalle rapido.

### 3.2 Alta y edicion
- [ ] Crear cliente.
- [ ] Editar cliente.
- [ ] Subir foto de cliente.

### 3.3 Eliminacion con privacidad
- [ ] Ejecutar anonimizado desde la web.
- [ ] Reasignar historial a ANONIMO.
- [ ] Mostrar aviso claro antes de confirmar.

Notas:
- 

---

## 4. Modulo Pistas
- [ ] Listar pistas.
- [ ] Crear pista.
- [ ] Editar pista.
- [ ] Eliminar pista (si no rompe relaciones).

Notas:
- 

---

## 5. Modulo Karts
- [ ] Listar karts.
- [ ] Crear kart.
- [ ] Editar kart.
- [ ] Baja logica de kart (activo/inactivo).
- [ ] Filtro por estado de actividad.

Notas:
- 

---

## 6. Modulo Tarifas
- [ ] Listar tarifas.
- [ ] Crear tarifa.
- [ ] Editar tarifa.
- [ ] Baja logica de tarifa (activa/inactiva).
- [ ] Evitar usar tarifas inactivas en nuevas reservas.

Notas:
- 

---

## 7. Modulo Reservas

### 7.1 Listado
- [ ] Ver reservas con filtros por fecha/estado.
- [ ] Buscar por ID reserva o DNI.

### 7.2 Alta y edicion
- [ ] Crear reserva.
- [ ] Editar reserva.
- [ ] Cambiar estado segun flujo definido.

### 7.3 Reglas de negocio
- [ ] Control de solapes por pista y franja horaria.
- [ ] Validar descuento 0 a 100.
- [ ] Calcular precio final en backend.

Notas:
- 

---

## 8. Modulo Carreras
- [ ] Listar carreras.
- [ ] Crear carrera asociada a reserva.
- [ ] Editar carrera.
- [ ] Cambiar estado de carrera.
- [ ] Cancelar carrera.

Notas:
- 

---

## 9. Modulo Corredores
- [ ] Listar corredores por carrera.
- [ ] Anadir corredor (id_carrera + dni + matricula).
- [ ] Editar asignacion de matricula.
- [ ] Eliminar corredor.
- [ ] Validar no repetidos: id_carrera + dni.
- [ ] Validar no repetidos: id_carrera + matricula.

Notas:
- 

---

## 10. Modulo Resultados
- [ ] Listar resultados.
- [ ] Crear resultado.
- [ ] Editar resultado.
- [ ] Eliminar resultado.
- [ ] Calculo de puntos por posicion en backend.

### 10.1 Historico por DNI
- [ ] Busqueda por DNI para ver historico de carreras y resultados.
- [ ] Vista cronologica (mas reciente primero).
- [ ] Mostrar carrera, fecha, kart, posicion, tiempo y puntos.

Notas:
- 

---

## 11. Requisitos tecnicos web (PHP)
- [ ] Definir rutas/endpoints por modulo.
- [ ] Definir estructura de controladores PHP.
- [ ] Definir consultas SQL por cada accion CRUD.
- [ ] Manejo centralizado de errores.
- [ ] Sanitizacion y validacion de entrada.

Notas:
- 

---

## 12. Priorizacion (MVP)

### Imprescindible
- [ ] Clientes
- [ ] Reservas
- [ ] Carreras
- [ ] Corredores
- [ ] Resultados

### Deseable
- [ ] Dashboard completo
- [ ] Mejoras de UX
- [ ] Exportaciones

### Futuro
- [ ] Estadisticas avanzadas
- [ ] Informes en PDF

---

## 13. Dudas abiertas
- [ ] 
- [ ] 
- [ ] 
