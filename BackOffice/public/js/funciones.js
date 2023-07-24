var identificador = null;
var idTabla = 0;
var tipoDeMoneda = ["USD", "EUR", "UYU"];
var arrayUsuarios = ["Administrador","Almacenero","Chofer","Cliente"];
var arrayDia = [];
var arrayMes = [];
var arrayAnio = [];
document.addEventListener('DOMContentLoaded', function () {
    var boton = document.getElementById('cargar');
    if(boton){
    boton.click();
    var nombrePagina = window.location.pathname.split('/').pop();
    switch (nombrePagina) {
        case 'vistaBackOfficeProducto':
            crearTipoMoneda(tipoDeMoneda)
            break;
    }
}
});
function cargarAlmacenes(ruta) {
    console.log('a')
    var xhr = new XMLHttpRequest();
    xhr.open('GET', ruta, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var infoAlmacenes = JSON.parse(xhr.responseText);
            console.log(infoAlmacenes);
            crearIdAlmacenes(infoAlmacenes);
        }
    };
    xhr.send();
}
function crearIdAlmacenes(infoAlmacenes) {
    var inputIdAlmacen = document.getElementById('idAlmacen');
    infoAlmacenes.forEach(function (datoAlmacen) {
        var almacen = document.createElement('option');
        almacen.value = datoAlmacen['Id Almacen'];
        almacen.textContent = datoAlmacen['Id Almacen'];
        inputIdAlmacen.appendChild(almacen);
    });
}

function cargarFechasPaquete(ruta, ruta2) {
    for (var i = 1; i <= 31; i++) {
        arrayDia.push(i)
    }
    for (var i = 1; i <= 12; i++) {
        arrayMes.push(i)
    }
    for (var i = 2023; i <= 2030; i++) {
        arrayAnio.push(i)
    }
    crearFechasPaquete()
    cargarIdProducto(ruta)
    cargarIdLugarEntrega(ruta2)
}

function cargarSelectsLote(rutaLote,rutaPaquete,rutaAlmacen,rutaDestino){
    cargarLotes(rutaLote)
    cargarPaquetes(rutaPaquete)
    cargarAlmacenes(rutaAlmacen)

}
function cargarPaquetes(ruta) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', ruta, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var infoPaquete = JSON.parse(xhr.responseText);
            console.log(infoPaquete);
            crearPaquetes(infoPaquete);
        }
    };
    xhr.send();
}
function cargarLotes(ruta) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', ruta, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var infoLotes = JSON.parse(xhr.responseText);
            console.log(infoLotes);
            crearLotes(infoLotes);
        }
    };
    xhr.send();
}

 function crearPaquetes(infoPaquete){
    var inputIdPaquete = document.getElementById('idPaquete');
    infoPaquete.forEach(function (datoPaquete) {
        var paquete = document.createElement('option');
        paquete.value = datoPaquete['Id Paquete'];
        paquete.textContent = datoPaquete['Id Paquete'];
        inputIdPaquete.appendChild(paquete);
    });
}
function crearLotes(infoLotes){
    var inputIdLote = document.getElementById('idLote');
    infoLotes.forEach(function (datoLote) {
        var lote = document.createElement('option');
        lote.value = datoLote['Id Lote'];
        lote.textContent = datoLote['Id Lote'];
        inputIdLote.appendChild(lote);
    });
}


function crearFechasPaquete() {
    var inputDia = document.getElementById('dia');
    var inputMes = document.getElementById('mes');
    var inputAnio = document.getElementById('anio');
    arrayDia.forEach(function (dia) {
        var day = document.createElement('option');
        day.value = dia;
        day.textContent = dia;
        inputDia.appendChild(day);
    });
    arrayMes.forEach(function (mes) {
        var month = document.createElement('option');
        month.value = mes;
        month.textContent = mes;
        inputMes.appendChild(month);
    });
    arrayAnio.forEach(function (anio) {
        var year = document.createElement('option');
        year.value = anio;
        year.textContent = anio;
        inputAnio.appendChild(year);
    });
}
function cargarIdProducto(ruta) {
    console.log('a')
    var xhr = new XMLHttpRequest();
    xhr.open('GET', ruta, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var infoProducto = JSON.parse(xhr.responseText);
            console.log(infoProducto);
            crearIdProducto(infoProducto);
        }
    };
    xhr.send();
}
function crearIdProducto(infoProducto) {
    var inputIdProducto = document.getElementById('idProducto');
    infoProducto.forEach(function (datoProducto) {
        var producto = document.createElement('option');
        producto.value = datoProducto['Id'];
        producto.textContent = datoProducto['Id'];
        inputIdProducto.appendChild(producto);
    });
}
function cargarIdLugarEntrega(ruta) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', ruta, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var infoLugar = JSON.parse(xhr.responseText);
            console.log(infoLugar);
            crearIdLugarEntrega(infoLugar);
        }
    };
    xhr.send();
}
function crearIdLugarEntrega(infoLugar) {
    var inputIdLugarEntrega = document.getElementById('idLugarEntrega');
    infoLugar.forEach(function (datoLugar) {
        var lugar = document.createElement('option');
        lugar.value = datoLugar['Id Lugar'];
        lugar.textContent = datoLugar['Id Lugar'];
        inputIdLugarEntrega.appendChild(lugar);
        console.log(datoLugar)
    });
}



function crearTipoMoneda(tipoDeMoneda) {
    var inputTipoMoneda = document.getElementById('tipoMoneda');
    if (inputTipoMoneda) {
        tipoDeMoneda.forEach(function (moneda) {
            var divisa = document.createElement('option');
            divisa.value = moneda;
            divisa.textContent = moneda;
            inputTipoMoneda.appendChild(divisa);
        });
    }
}
function cargarSelectUsuario() {
    var inputUsuarios = document.getElementById('tipoUsuario');
    if (inputUsuarios) {
        arrayUsuarios.forEach(function (datoUsuario) {
            var usuario = document.createElement('option');
            usuario.value = datoUsuario;
            usuario.textContent = datoUsuario;
            inputUsuarios.appendChild(usuario);
        });
    }
}

function crearTabla(idTablaPagina, infoProducto) {
    if (idTabla != idTablaPagina) {
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
    switch (nombrePagina) {
        case 'vistaBackOfficeAlmacen':
            cargarInputsAlmacen(datosFila);
            break;
        case 'vistaBackOfficeLugarEntrega':
            cargarInputsLugarEntrega(datosFila);
            break;
        case 'vistaBackOfficePaquete':
            cargarInputsPaquete(datosFila);
            break;
        case 'vistaBackOfficeProducto':
            cargarInputsProducto(datosFila);
            break;
        case 'vistaBackOfficeLote':
            cargarInputsLote(datosFila);
            break;
            case 'vistaBackOfficePaqueteContieneLote':
                cargarInputsPaqueteContieneLote(datosFila);
                break;
    }
}

function cargarTabla(rutaDestino, idTablaPagina) {
    console.time("tabla");
    var xhr = new XMLHttpRequest();
    xhr.open('GET', rutaDestino, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var datos = JSON.parse(xhr.responseText);
            console.log(datos)
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
        cbxEliminar.checked = false
        var checkbox = document.getElementById('cbxModificar');
        if (checkbox)
            cbxModificar.checked = false;
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
        var checkbox = document.getElementById('cbxModificar');
        if (checkbox)
            cbxModificar.checked = false
    }
}
function filtro(event) {
    var texto = event.key;
    if (['.', 'e'].includes(texto))
        event.preventDefault()
}
/****************************************************/
function validarInputs(ruta1, ruta2, ruta3, rutaDestino) {
    console.time("ingresarInputs");
    var cbxAgregar = document.getElementById('cbxAgregar');
    if (cbxAgregar.checked) {
        var inputsProcesados = procesarInputs()
        if (inputsProcesados != null)
            enviarDatos(ruta1, inputsProcesados, rutaDestino)
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
function modificarLotes(ruta1, ruta2, rutaDestino) {
    console.time("ingresarInputs");
    var cbxAgregar = document.getElementById('cbxAgregar');
    if (cbxAgregar.checked) {
        agregarLote(ruta1, rutaDestino)
    } else {
        var cbxEliminar = document.getElementById('cbxEliminar');
        if (cbxEliminar.checked) {
            eliminarInput(ruta2, rutaDestino)
        } else {
            alert("Error:no hay ninguna checkbox activa")
        }
    }

    console.timeEnd("ingresarInputs");
}

function procesarInputs() {
    var inputs = document.querySelectorAll('input,select');
    var inputsArray = Array.from(inputs);
    inputs = inputsArray.filter(elemento => !elemento.id.includes("cbx"));
    var datosInputs = inputs.map(input => input.value);
    if (datosInputs.some(valor => valor === "")) {
        alert("Error: Por favor, rellene todos los campos");
        return null;
    }
    return datosInputs;

}
function agregarLote(ruta, rutaDestino) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const xhr = new XMLHttpRequest();
    xhr.open('GET', ruta); // Utilizamos 'GET' en lugar de 'POST' para no enviar datos
    xhr.setRequestHeader('X-CSRF-TOKEN', token);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var datos = JSON.parse(xhr.responseText);
            console.log(datos);
        } else {
            console.error('Error en la solicitud:', xhr.statusText);
            alert('Error en la solicitud:' + xhr.statusText + "");
        }
    };
    xhr.onerror = function () {
        console.error('Error en la solicitud:', xhr.statusText);
    };
    xhr.send();
    cargarTabla(rutaDestino)
}

function enviarDatos(ruta, datosInputs, rutaDestino) {
    console.log(datosInputs);
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
            alert('Error en la solicitud:' + xhr.statusText + ", verifica los datos que ingresaste");
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
        enviarDatos(ruta, idModificar, rutaDestino)
    } else {
        alert('Error,por favor seleccione un dato de la lista para modificar')
    }
}

function eliminarInput(ruta, rutaDestino) {
    if (identificador != null) {
        if (window.confirm('¿Quieres eliminar el elemento de id ' + identificador + "?, podras recuperarlo mas tarde")) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const xhr = new XMLHttpRequest();
            xhr.open('DELETE', (ruta));
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var datos = JSON.parse(xhr.responseText);
                    alert(datos)
                } else {
                    console.error('Error en la solicitud:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error('Error en la solicitud:', xhr.statusText);
            };

            xhr.send(JSON.stringify({ 'identificador': identificador }));
            cargarTabla(rutaDestino);

        } else {
            alert("Elemento NO borrado")
        }
    } else {
        alert("Error, por favor seleccione algun elemento de la tabla para eliminar")
    }
}


function cargarInputsAlmacen(datosFila) {
    identificador = datosFila[0];
    document.getElementById('direccion').value = datosFila[1];
    document.getElementById('latitud').value = datosFila[2];
    document.getElementById('longitud').value = datosFila[3];
}

function cargarInputsLugarEntrega(datosFila) {
    identificador = datosFila[0];
    document.getElementById('direccion').value = datosFila[1];
    document.getElementById('idAlmacen').value = datosFila[2];
    document.getElementById('latitud').value = datosFila[4];
    document.getElementById('longitud').value = datosFila[5];
}
function cargarInputsPaquete(datosFila) {
    identificador = datosFila[0];
    var arrayFecha = datosFila[1].split('-');
    document.getElementById('anio').value = parseInt(arrayFecha[0], 10);
    document.getElementById('mes').value = parseInt(arrayFecha[1], 10);
    document.getElementById('dia').value = parseInt(arrayFecha[2], 10);
    document.getElementById('idLugarEntrega').value = datosFila[2];
    document.getElementById('caracteristica').value = datosFila[4];
    document.getElementById('nombreRemitente').value = datosFila[5];
    document.getElementById('nombreDestinatario').value = datosFila[6];
    document.getElementById('idProducto').value = datosFila[7];
    document.getElementById('volumen').value = datosFila[9];
    document.getElementById('peso').value = datosFila[10];
}
function cargarInputsProducto(datosFila) {
    identificador = datosFila[0];
    document.getElementById('nombre').value = datosFila[1];
    document.getElementById('precio').value = datosFila[2];
    document.getElementById('tipoMoneda').value = datosFila[3];
    document.getElementById('stock').value = datosFila[4];
}
function cargarInputsLote(datosFila){
    identificador=datosFila[0];
}
function cargarInputsPaqueteContieneLote(datosFila) {
    identificador = datosFila[1];
    document.getElementById('idLote').value = datosFila[0];
    document.getElementById('idPaquete').value = datosFila[1];
    document.getElementById('idAlmacen').value = datosFila[4];
}

function recuperarDatos(rutaRecuperar, rutaCargar) {
    if (identificador != null) {
        if (window.confirm('¿Quieres reestablecer el elemento de id ' + identificador + "?")) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const xhr = new XMLHttpRequest();
            xhr.open('POST', (rutaRecuperar));
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var datos = JSON.parse(xhr.responseText);
                    alert(datos);
                } else {
                    console.error('Error en la solicitud:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error('Error en la solicitud:', xhr.statusText);
            };

            xhr.send(JSON.stringify({ 'identificador': identificador }));
            cargarTabla(rutaCargar);
        } else {
        }
    } else {
        alert("Error, por favor seleccione algun elemento para recuperar")
    }
}