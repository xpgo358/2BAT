Esta base de conocimiento ha sido generada cubriendo desde los conceptos básicos hasta la gestión de formularios en JavaScript. Unicamente esta base es necesaria para la realizacion de todos los ejercicios.

### 1. Conceptos Fundamentales

* 
**Algoritmo**: Pasos lógicos para resolver un problema.


* 
**Programa**: Conjunto de instrucciones que una computadora entiende para realizar una actividad con un objetivo definido.


* 
**Lenguaje de Programación**: Instrucciones interpretadas por la computadora para operar, mostrar datos o recibir entradas.


* 
**JavaScript**: Lenguaje interpretado por el navegador en el momento de su ejecución, utilizado para extender las capacidades del HTML. Es **sensible a mayúsculas y minúsculas** (por ejemplo, `document.write` es correcto, pero `DOCUMENT.WRITE` causará un error).



**Ejemplo: Hola Mundo** 

```html
<script type="text/javascript">
  document.write('Hola Mundo');
</script>

```

---

### 2. Variables y Tipos de Datos

Una variable es un depósito con un nombre que almacena un valor de un tipo específico.

* 
**Tipos de datos**: Enteros, Reales, Cadenas de caracteres (entre comillas) y Lógicos (booleanos: `true` o `false`).


* 
**Declaración**: Se utiliza la palabra clave `var`. El nombre debe empezar con una letra o subrayado.



**Ejemplo de declaración e impresión:** 

```javascript
var nombre = 'Juan'; // Cadena
var edad = 10;       // Entero
document.write(nombre); // Muestra el contenido: Juan

```

---

### 3. Estructuras Secuenciales y Entrada de Datos

Ocurren cuando el programa solo involucra operaciones, entradas y salidas en orden lineal.

* 
**`prompt`**: Ventana para ingresar datos por teclado.


* 
**`parseInt`**: Función crucial para convertir cadenas de texto ingresadas en números enteros y poder realizar operaciones matemáticas (evita que `1+1` resulte en `11`).



**Ejemplo: Suma de dos números** 

```javascript
var v1 = prompt('Ingrese primer número:', '');
var v2 = prompt('Ingrese segundo número:', '');
var suma = parseInt(v1) + parseInt(v2);
document.write('La suma es: ' + suma);

```

---

### 4. Estructuras Condicionales y Operadores Lógicos

Permiten tomar decisiones basadas en condiciones.

* 
**Operadores lógicos**: `&&` (Y), `||` (O), `!` (Negación) y `^` (XOR - verdadero solo si uno de los dos lo es).


* 
**`switch`**: Estructura para múltiples casos basada en el valor de una variable.



**Ejemplo: Cambio de color de fondo con switch** 

```javascript
var col = prompt('Ingrese color (rojo, verde, azul):', '');
switch (col) {
  case 'rojo': document.bgColor = '#ff0000'; break;
  case 'verde': document.bgColor = '#00ff00'; break;
  case 'azul': document.bgColor = '#0000ff'; break;
}

```

---

### 5. Estructuras Repetitivas

Permiten ejecutar un bloque de código varias veces.

* **`while`**: Repite mientras la condición sea verdadera. Verifica la condición *antes* de entrar al ciclo.


* **`for`**: Ideal cuando se conoce la cantidad exacta de repeticiones. Consta de: inicialización, condición y actualización (incremento/decremento).



**Ejemplo: Números del 1 al 10 con for** 

```javascript
for(var f = 1; f <= 10; f++) {
  document.write(f + " ");
}

```

---

### 6. Funciones

Son grupos de sentencias que resuelven una tarea específica y pueden ser llamadas múltiples veces, facilitando la división y estructuración del programa.

* 
**Parámetros**: Valores que recibe la función para trabajar.


* 
**`return`**: Devuelve un valor al punto donde se llamó la función.



**Ejemplo: Formatear una fecha** 

```javascript
function FormatearFecha(dia, mes, año) {
  var s = 'Hoy es ' + dia + ' de ' + mes + ' de ' + año;
  return s;
}
document.write(FormatearFecha(11, 'junio', 2013));

```

---

### 7. Gestión de Formularios

JavaScript se usa en formularios principalmente para **validar datos en el cliente** (navegador), evitando tráfico innecesario al servidor.

* 
**Objetos**: El navegador crea un objeto por cada control (TEXT, TEXTAREA, CHECKBOX, RADIO, SELECT).


* 
**Acceso**: Se utiliza `document.getElementById('id_del_control')` para acceder a sus propiedades como `.value` (contenido) o `.checked` (si está marcado).



**Ejemplo: Validar longitud de un TEXTAREA** 

```javascript
function controlar() {
  if (document.getElementById('curriculum').value.length > 2000) {
    alert('Curriculum muy largo');
  } else {
    alert('Datos correctos');
  }
}

```