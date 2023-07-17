function crearTabla(infoProducto) {
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

function redireccionar(ruta) {
    window.location.href = ruta;
}

function cargarTabla(rutaDestino,rutaOrigen){
    var xhr = new XMLHttpRequest();
  xhr.open('GET', rutaDestino, true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Procesar los datos recibidos del servidor
      var datos = JSON.parse(xhr.responseText);
     crearTabla(datos)
    }
  };
  xhr.send();
}

/****************************************************************/

function comprobarCbxAgregar() {
    if (cbxAgregar.checked) {
        cbxModificar.checked = false;
        cbxEliminar.checked = false
    }
}

function comprobarCbxModificar() {
    if (cbxModificar.checked) {
        cbxAgregar.checked = false;
        cbxEliminar.checked = false
    }
}

function comprobarCbxEliminar() {
    if (cbxEliminar.checked) {
        cbxAgregar.checked = false;
        cbxModificar.checked = false
    }
}

/****************************************************/
function validarInputs(ruta1, ruta2, ruta3) {
    var cbxAgregar = document.getElementById('cbxAgregar');
    var cbxModificar = document.getElementById('cbxModificar');
    if (cbxAgregar.checked || cbxModificar.checked) {
        procesarInputs(ruta1)
    } else {
        var cbxEliminar = document.getElementById('cbxEliminar');
        if (cbxEliminar.checked) {
            eliminarInput(ruta3)
        } else {
            alert("Error:no hay ninguna checkbox activa")
        }
    }

}

function procesarInputs(ruta) {
    // Obtener los valores de los campos de texto
  var nombre = document.getElementById('nombre').value;
  var precio = parseInt(document.getElementById('precio').value);
  var tipoMoneda = document.getElementById('tipoMoneda').value;
  var stock = parseInt(document.getElementById('stock').value);

  // Verificar que ninguno sea vacío
  if (nombre === '' || isNaN(precio) || tipoMoneda === '' || isNaN(stock)) {
    alert('Por favor, rellene todos los campos correctamente.');
    return;
  }

  // Crear el objeto con los datos
  var datosInputs = {
    nombre: nombre,
    precio: precio,
    tipoMoneda: tipoMoneda,
    stock: stock
  };

  enviarDatos(ruta,datosInputs)
}

function enviarDatos(ruta, datosInputs) {
    console.log(datosInputs)
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const xhr = new XMLHttpRequest();
    xhr.open('POST', ruta);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', token);
    xhr.onload = function () {
      if (xhr.status === 200) {
        console.log('Respuesta del controlador:', xhr.responseText);
        var datos = JSON.parse(xhr.responseText);
        console.log(datos);
      } else {
        console.error('Error en la solicitud:', xhr.statusText);
      }
    };
    xhr.onerror = function () {
      console.error('Error en la solicitud:', xhr.statusText);
    };
    xhr.send(JSON.stringify(datosInputs));
  
}

function eliminarInput() {
    var inputs = document.querySelectorAll('input');
    var inputsArray = Array.from(inputs);
    inputs = inputsArray.filter(elemento => elemento.id.includes("id"));
    var datosInputs = [];
    inputs.forEach(input => {
        datosInputs.push(input.value);
    });
    console.log(datosInputs)
    if (datosInputs != "") {
    } else {
        alert("Error:Por favor, ingrese un Id")
    }

}