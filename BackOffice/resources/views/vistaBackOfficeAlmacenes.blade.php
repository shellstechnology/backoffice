
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Almacenes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
</head>
<body>
<div class="barraDeNavegacion">
    <div class="item"> Almacenes</div>
    <div class="item"> Almaceneros</div>
    <div class="item"> Camiones</div>
    <div class="item"> Camioneros</div>
    <div class="item"> Productos</div>
    <div class="item"> Paquetes</div>
    <div class="item"> Lotes</div>
</div>
    <div id="contenedor-tabla"></div>
   
    <script>
      // Datos de ejemplo
var datos = [
  { columna1: "Valor 1", columna2: "Valor 2", columna3: "Valor 3" },
  { columna1: "Valor 4", columna2: "Valor 5", columna3: "Valor 6" },
  { columna1: "Valor 7", columna2: "Valor 8", columna3: "Valor 9" },
  // ...
];

// Crear la tabla dinámicamente
var tabla = document.createElement("table");
tabla.style.height = "300px";
tabla.style.overflowY = "scroll";

// Crear la cabecera de la tabla
var cabecera = tabla.createTHead();
var filaCabecera = cabecera.insertRow();
for (var key in datos[0]) {
  var th = document.createElement("th");
  th.textContent = key;
  filaCabecera.appendChild(th);
}

// Crear el cuerpo de la tabla
var cuerpo = document.createElement("tbody");
for (var i = 0; i < datos.length; i++) {
  var fila = cuerpo.insertRow();
  for (var key in datos[i]) {
    var celda = fila.insertCell();
    celda.textContent = datos[i][key];
  }
}

tabla.appendChild(cuerpo);

// Agregar la tabla al elemento contenedor deseado en tu HTML
var contenedorTabla = document.getElementById("contenedor-tabla");
if (contenedorTabla) {
  contenedorTabla.innerHTML = ""; // Limpiar el contenido existente
  contenedorTabla.appendChild(tabla);
} else {
  console.error("Elemento contenedor-tabla no encontrado.");
}

// Función para seleccionar una fila de la tabla y enviar los valores
function seleccionarFila(event) {
  var fila = event.target.closest("tr");
  if (fila.parentNode === cuerpo) {
    var valores = Array.from(fila.cells).map(function (celda) {
      return celda.textContent;
    });
    enviarValores(valores);
  }
}

// Asociar el evento onclick a las filas de la tabla
tabla.addEventListener("click", seleccionarFila);

// Función para enviar los valores a otro lugar
function enviarValores(valores) {
  // Aquí puedes agregar la lógica para enviar los valores a otro lugar
  console.log("Valores seleccionados:", valores);
}

    </script>
    </div>
       
</body>
</html>