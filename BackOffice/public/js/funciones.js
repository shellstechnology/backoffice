function crearTabla(infoProducto){
    console.log(infoProducto);

// Crear la tabla dinámicamente
var tabla = document.createElement("table");
tabla.style.borderCollapse = "collapse";

// Crear la cabecera de la tabla
var cabecera = tabla.createTHead();
var filaCabecera = cabecera.insertRow();
for (var key in infoProducto[0]) {
  var th = document.createElement("th"); // th es table header
  th.textContent = key;
  filaCabecera.appendChild(th);
}

// Crear el cuerpo de la tabla
var cuerpo = document.createElement("tbody");
for (var i = 0; i < infoProducto.length; i++) {
  var fila = cuerpo.insertRow();
  for (var key in infoProducto[i]) {
    var celda = fila.insertCell();
    celda.textContent = infoProducto[i][key];
  }
}
tabla.appendChild(cuerpo);

// Agregar una línea separadora entre cada fila
var filas = cuerpo.getElementsByTagName("tr"); //tr es table row
for (var i = 0; i < filas.length; i++) {
  filas[i].style.borderBottom = "1px solid black";
  filas[i].addEventListener("click", function () {
    imprimirDatos(this);
  });
}
// Agregar la tabla al div
var contenedorTabla = document.getElementById("contenedor-tabla");
if (contenedorTabla) {
  contenedorTabla.innerHTML = ""; // Limpiar el contenido existente
  contenedorTabla.appendChild(tabla);
} else {
  console.error("Elemento contenedor-tabla no encontrado.");
}

   }
// Función para imprimir en consola los datos de la línea seleccionada
function imprimirDatos(fila) {
  var datosFila = Array.from(fila.cells).map(function (celda) {
    return celda.textContent;
  });
  console.log("Datos de la línea:", datosFila);
}


function menu(){
            window.location.href = "{{ route('backoffice') }}";
           }