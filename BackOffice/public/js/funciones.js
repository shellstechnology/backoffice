var identificador = null;
var idTabla = 0;
function crearTabla(idTablaPagina, infoProducto) {
    if (idTabla != idTablaPagina) {
        console.log(infoProducto);
        var tabla = document.createElement("table");
        tabla.style.borderCollapse = "collapse";

        // Crear la cabecera de la tabla
        var cabecera = tabla.createTHead();
        var filaCabecera = cabecera.insertRow();
        for (var key in infoProducto[0]) {
            var th = document.createElement("th"); // th es table header
            if (key == "updated_at") {
                key = "Ultima Actualizacion"
            } else {
                if (key == "created_at") {
                    key = "Fecha de creacion"
                } else {
                    if (key == "deleted_at") {
                        key = "Fecha de borrado"
                    }
                }
            }
            th.textContent = key;
            filaCabecera.appendChild(th);
        }
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
    var contenedorTabla = document.getElementById("contenedorTabla");
    if (contenedorTabla) {
        contenedorTabla.innerHTML = "";
        contenedorTabla.appendChild(tabla);
    } else {
        console.error("Elemento contenedorTabla no encontrado.");
    }
}

function imprimirDatos(fila) {
    var datosFila = Array.from(fila.cells).map(function (celda) {
        return celda.textContent;
    });
    var nombrePagina = window.location.pathname.split('/').pop();
    console.log(nombrePagina)
    if (nombrePagina == "vistaBackOfficeProducto") {
        cargarInputsProducto(datosFila);
    }
}

function cargarTabla(rutaDestino, idTablaPagina) {
    console.time("tabla");
    var xhr = new XMLHttpRequest();
    xhr.open('GET', rutaDestino, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var datos = JSON.parse(xhr.responseText);
            crearTabla(idTablaPagina, datos)
        }
    };
    xhr.send();
    console.timeEnd("tabla");
}
function redireccionar(ruta) {
    window.location.href = ruta;
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
function filtro(event){
var tecla = event.key;
if (['.','e'].includes(tecla))
   event.preventDefault()
}
/****************************************************/
function validarInputs(ruta1, ruta2, ruta3, rutaDestino) {
    console.time("ingresarInputs");
    var cbxAgregar = document.getElementById('cbxAgregar');
    if (cbxAgregar.checked) {
        var inputsProcesados = procesarInputs()
        if (inputsProcesados != null)
            if (enviarDatos(ruta1, inputsProcesados, rutaDestino))
                alert("Elemento agregado")
    } else {
        var cbxModificar = document.getElementById('cbxModificar');
        if (cbxModificar.checked) {
            var inputsProcesados = procesarInputs()
            if (inputsProcesados != null)
                modificarDatos(ruta2, inputsProcesados, rutaDestino)
        } else {
            var cbxEliminar = document.getElementById('cbxEliminar');
            if (cbxEliminar.checked) {
                eliminarInput(ruta3, rutaDestino)
            } else {
                alert("Error:no hay ninguna checkbox activa")
            }
        }
    }
    console.timeEnd("ingresarInputs");
}

function procesarInputs() {
    var inputs = document.querySelectorAll('input');
    var inputsArray = Array.from(inputs);
    inputs = inputsArray.filter(elemento => !elemento.id.includes("cbx"));
    var datosInputs = inputs.map(input => input.value);
    if (datosInputs.some(valor => valor === "")) {
        alert("Error: Por favor, rellene todos los campos");
        return null;
    }
    var validacion = 0;
    var inputNumero = document.querySelectorAll('input[type="number"]');
    inputNumero.forEach(function (numero) {
        if (numero > 9999999) {
            validacion = 1;
            return
        }
    })
    if (validacion != 0) {
        console.log(datosInputs);
        datosInputs=0;
    }
    return datosInputs;

}

function enviarDatos(ruta, datosInputs, rutaDestino) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const xhr = new XMLHttpRequest();
    xhr.open('POST', ruta);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', token);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var datos = JSON.parse(xhr.responseText);
            console.log(datos)
        } else {
            console.error('Error en la solicitud:', xhr.statusText);
            alert('Error en la solicitud:' + xhr.statusText + ", verifica los datos que ingresaste pedazo de un anormal");
        }
    };
    xhr.onerror = function () {
        console.error('Error en la solicitud:', xhr.statusText);
    };
    xhr.send(JSON.stringify(datosInputs));
    cargarTabla(rutaDestino)
}
function modificarDatos(ruta, datosInputs, rutaDestino) {
    if (identificador != null) {

        var idModificar = []
        idModificar = idModificar.concat(identificador, datosInputs);
        if(enviarDatos(ruta, idModificar, rutaDestino))
        alert("Elemento modificado")
    } else {
        alert('Error,por favor seleccione un dato de la lista para modificar')
    }
}

function eliminarInput(ruta, rutaDestino) {
    if (identificador != null) {
        if (window.confirm('¿Quieres eliminar el elemento de id?' + identificador + ", no podras recuperarlo")) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const xhr = new XMLHttpRequest();
            xhr.open('DELETE', (ruta));
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var datos = JSON.parse(xhr.responseText);
                    console.log(datos);
                } else {
                    console.error('Error en la solicitud:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error('Error en la solicitud:', xhr.statusText);
            };

            xhr.send(JSON.stringify({ 'identificador': identificador }));
            cargarTabla(rutaDestino);
            alert("Elemento borrado")

        } else {
            alert("Elemento NO borrado")
        }
    } else {
        alert("Error, por favor seleccione algun atributo de la tabla para eliminar")
    }
}

function cargarInputsProducto(datosFila) {
    identificador = datosFila[0];
    document.getElementById('nombre').value = datosFila[1];
    document.getElementById('precio').value = datosFila[2];
    document.getElementById('tipoMoneda').value = datosFila[3];
    document.getElementById('stock').value = datosFila[4];
}