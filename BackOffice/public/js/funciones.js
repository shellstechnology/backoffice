var idTabla = 0;
var arrayUsuarios = ["Administrador", "Almacenero", "Chofer", "Cliente"];
var arrayDia = [];
var arrayMes = [];
var arrayAnio = [];


window.addEventListener("DOMContentLoaded", (event) => {

    var botonCargar = document.getElementById('cargarTabla')
    if (botonCargar != null) {
        botonCargar.click()
        var descripcionCaracteristica = document.getElementById('descripcionCaracteristica')
        var idLugaresEntrega = document.getElementById('idLugaresEntrega')
        var idAlmacenes = document.getElementById('idAlmacenes')
        var idPaquetes = document.getElementById('idPaquetes')
        var idProducto = document.getElementById('idProductos')
        var estado = document.getElementById('estadoPaquete')
        var usuario = document.getElementById('tipoUsuario')
        var idLotes = document.getElementById('idLotes')
        var moneda = document.getElementById('moneda')
        var dia = document.getElementById('dia');

        if (descripcionCaracteristica != null) {
            crearCaracteristica(descripcionCaracteristica.value.replace('[', '').replace(']', '').split(','));
        }
        if (idAlmacenes != null) {
            crearIdAlmacenes(idAlmacenes.value.replace('[', '').replace(']', '').split(','))
        }
        if (idLugaresEntrega != null) {
            crearIdLugarEntrega(idLugaresEntrega.value.replace('[', '').replace(']', '').split(','))
        }
        if (idPaquetes != null) {
            crearIdPaquetes(idPaquetes.value.replace('[', '').replace(']', '').split(','))
        }
        if (usuario != null) {
            crearTipoUsuario();
        }
        if (idLotes != null) {
            crearIdLotes(idLotes.value.replace('[', '').replace(']', '').split(','))
        }
        if (idProducto != null) {
            crearIdProducto(idProducto.value.replace('[', '').replace(']', '').split(','))
        }
        if (moneda != null) {
            console.log(moneda.value);
            crearTipoMoneda(moneda.value.replace('[', '').replace(']', '').split(','))
        }
        if (estado != null) {
            crearEstado(estado.value.replace('[', '').replace(']', '').split(','));
        }
        if (dia != null) {
            crearFechasPaquete()
        }
    }
}
);


function crearCaracteristica(infoCaracteristica) {
    var inputCaracteristica = document.getElementById('caracteristica');
    infoCaracteristica.forEach(function (datoCaracteristica) {
        datoCaracteristica = datoCaracteristica.replace('"', '').replace('"', '')
        console.log(datoCaracteristica)
        var caracteristica = document.createElement('option');
        caracteristica.value = datoCaracteristica;
        caracteristica.textContent = datoCaracteristica;
        inputCaracteristica.appendChild(caracteristica);
    });
}

function crearIdAlmacenes(infoAlmacenes) {
    var inputIdAlmacen = document.getElementById('idAlmacen');
    infoAlmacenes.forEach(function (datoAlmacen) {
        console.log(datoAlmacen)
        var almacen = document.createElement('option');
        almacen.value = datoAlmacen;
        almacen.textContent = datoAlmacen;
        inputIdAlmacen.appendChild(almacen);
    });
}
function crearIdLugarEntrega(infoLugaresEntrega) {
    var inputIdLugares = document.getElementById('idLugarEntrega');
    infoLugaresEntrega.forEach(function (datoLugar) {
        console.log(datoLugar)
        var lugar = document.createElement('option');
        lugar.value = datoLugar;
        lugar.textContent = datoLugar;
        inputIdLugares.appendChild(lugar);
    });
}
function crearIdPaquetes(infoPaquete) {
    var inputIdPaquete = document.getElementById('idPaquete');
    infoPaquete.forEach(function (datoPaquete) {
        console.log(datoPaquete)
        var paquete = document.createElement('option');
        paquete.value = datoPaquete;
        paquete.textContent = datoPaquete;
        inputIdPaquete.appendChild(paquete);
    });
}

function crearIdProducto(infoProducto) {
    var inputIdProducto = document.getElementById('idProducto');
    infoProducto.forEach(function (datoProducto) {
        console.log(datoProducto)
        var producto = document.createElement('option');
        producto.value = datoProducto;
        producto.textContent = datoProducto;
        inputIdProducto.appendChild(producto);
    });
}

function crearIdLotes(infoLote) {
    var inputIdLote = document.getElementById('idLote');
    infoLote.forEach(function (datoLote) {
        console.log(datoLote)
        var lote = document.createElement('option');
        lote.value = datoLote;
        lote.textContent = datoLote;
        inputIdLote.appendChild(lote);
    });
}

function crearEstado(estado) {
    var inputEstado = document.getElementById('estado');
    estado.forEach(function (datoEstado) {
        datoEstado = datoEstado.replace('"', '').replace('"', '')
        var state = document.createElement('option');
        state.value = datoEstado;
        state.textContent = datoEstado;
        inputEstado.appendChild(state);
    });
}

function crearTipoMoneda(tipoMoneda) {
    var inputTipoMoneda = document.getElementById('tipoMoneda');
    tipoMoneda.forEach(function (datoMoneda) {
        datoMoneda = datoMoneda.replace('"', '').replace('"', '')
        var moneda = document.createElement('option');
        moneda.value = datoMoneda;
        moneda.textContent = datoMoneda;
        inputTipoMoneda.appendChild(moneda);
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

function cargarSelectsLote(rutaLote, rutaPaquete, rutaAlmacen, rutaDestino) {
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

function crearPaquetes(infoPaquete) {
    var inputIdPaquete = document.getElementById('idPaquete');
    infoPaquete.forEach(function (datoPaquete) {
        var paquete = document.createElement('option');
        paquete.value = datoPaquete['Id Paquete'];
        paquete.textContent = datoPaquete['Id Paquete'];
        inputIdPaquete.appendChild(paquete);
    });
}



function crearFechasPaquete() {
    var inputDia = document.getElementById('dia');
    var inputMes = document.getElementById('mes');
    var inputAnio = document.getElementById('anio');
    for (var dia = 1; dia <= 31; dia++) {
        var day = document.createElement('option');
        day.value = dia;
        day.textContent = dia;
        inputDia.appendChild(day);
    }
    for (var mes = 1; mes <= 12; mes++) {
        var month = document.createElement('option');
        month.value = mes;
        month.textContent = mes;
        inputMes.appendChild(month);
    }
    for (var anio = 1; anio <= 2023; anio++) {
        var year = document.createElement('option');
        year.value = anio;
        year.textContent = anio;
        inputAnio.appendChild(year);
    }
}
function crearTipoUsuario() {
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
    console.log(infoProducto);
    if (idTabla != idTablaPagina) {
        console.log(infoProducto)
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
        case 'vistaBackOfficeUsuarios':
            cargarInputsUsuarios(datosFila);
            break;
    }
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
        cbxAgregar.checked = false
        cbxEliminar.checked = false
        cbxRecuperar.checked = false
    }
}

function comprobarCbxEliminar() {
    if (cbxEliminar.checked) {
        cbxAgregar.checked = false;
        cbxRecuperar.checked = false
        var checkbox = document.getElementById('cbxModificar');
        if (checkbox)
            cbxModificar.checked = false
    }
}

function comprobarCbxRecuperar() {
    if (cbxEliminar.checked) {
        cbxAgregar.checked = false;
        cbxEliminar.checked = false;
        var checkbox = document.getElementById('cbxModificar');
        if (checkbox)
            cbxModificar.checked = false
    }
}

function filtro(event) {
    var texto = event.key;
    if ([',', 'e', 'E'].includes(texto))
        event.preventDefault()
}
function limitarInput(input, maxLength) {
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}
/****************************************************/

function cargarInputsAlmacen(datosFila) {
    console.log(datosFila)
    document.getElementById('identificador').value = datosFila[0];
    document.getElementById('direccion').value = datosFila[1];
    document.getElementById('latitud').value = datosFila[2];
    document.getElementById('longitud').value = datosFila[3];
}

function cargarInputsLugarEntrega(datosFila) {
    document.getElementById('identificador').value = datosFila[0];
    document.getElementById('direccion').value = datosFila[1];
    document.getElementById('latitud').value = datosFila[2];
    document.getElementById('longitud').value = datosFila[3];
}
function cargarInputsPaquete(datosFila) {
    document.getElementById('identificador').value = datosFila[0];
    document.getElementById('nombrePaquete').value = datosFila[1];
    var arrayFecha = datosFila[2].split('-');
    document.getElementById('anio').value = parseInt(arrayFecha[0], 10);
    document.getElementById('mes').value = parseInt(arrayFecha[1], 10);
    document.getElementById('dia').value = parseInt(arrayFecha[2], 10);
    document.getElementById('idLugarEntrega').value = datosFila[3];
    document.getElementById('estado').value = datosFila[5];
    document.getElementById('caracteristica').value = datosFila[6];
    document.getElementById('nombreRemitente').value = datosFila[7];
    document.getElementById('nombreDestinatario').value = datosFila[8];
    document.getElementById('idProducto').value = datosFila[9];
    document.getElementById('volumen').value = datosFila[12];
    document.getElementById('peso').value = datosFila[12];
}
function cargarInputsProducto(datosFila) {
    document.getElementById('identificador').value = datosFila[0];
    document.getElementById('nombre').value = datosFila[1];
    document.getElementById('stock').value = datosFila[2];
    document.getElementById('precio').value = datosFila[3];
    document.getElementById('tipoMoneda').value = datosFila[4];
}
function cargarInputsLote(datosFila) {
    document.getElementById('identificador').value = datosFila[0];
    document.getElementById('identificarId').value = datosFila[0];
}
function cargarInputsPaqueteContieneLote(datosFila) {
    document.getElementById('identificador').value = datosFila[0];
    document.getElementById('idPaquete').value = datosFila[0];
    document.getElementById('idLote').value = datosFila[1];
    document.getElementById('idAlmacen').value = datosFila[4];
}
function cargarInputsUsuarios(datosFila) {
    identificador = datosFila[0];
    document.getElementById('nombre').value = datosFila[1];
    document.getElementById('contraseña').value = datosFila[2];
    document.getElementById('mail').value = datosFila[3];
    document.getElementById('tipoUsuario').value = obtenerTipoUsuario(datosFila[5]);
}

function obtenerTipoUsuario(datosFila) {
    datosFila = datosFila.split('/')
    datosFila.forEach(function (palabra) {
        palabra = palabra.trim();
        switch (palabra) {
            case "Administrador":
                document.getElementById("usuarioAdministrador").checked = true;
                break;
            case "Almacenero":
                document.getElementById("usuarioAlmacenero").checked = true;
                break;
            case "Chofer":
                document.getElementById("usuarioChofer").checked = true;
                break;
            case "Cliente":
                document.getElementById("usuarioCliente").checked = true;
                break;
        }
    });
}





