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
function validarInputs(ruta1,ruta2,ruta3) {
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
    var inputs = document.querySelectorAll('input');
    var inputsArray = Array.from(inputs);
    var validarInputs = inputsArray.filter(elemento => !elemento.id.includes(""));
    console.log(validarInputs)
    if (validarInputs.length == 0) {
        inputs = inputsArray.filter(elemento => !elemento.id.includes("cbx"));
        var datosInputs = [];
        inputs.forEach(input => {
            datosInputs.push(input.value);
        });
        console.log(datosInputs)
        enviarDatos(ruta,datosInputs)
    } else {
        alert("Error:Por favor, rellene todos los campos")
    }
}

function enviarDatos(ruta,datosInputs){
    fetch(ruta, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datosInputs)
    })
    .then(response => response.json())
    .then(data => {
        alert("TA BIEN")
        console.log(data)
    })
    .catch(error => {
        alert("TA MAL")
        console.log(error)
    });
}

function eliminarInput() {
    var inputs = document.querySelectorAll('input');
    var inputsArray = Array.from(inputs);
    inputs = inputsArray.filter(elemento => elemento.id.includes("id"));
    var datosInputs=[];
    inputs.forEach(input => {
        datosInputs.push(input.value);
    });
    console.log(datosInputs)
    if(datosInputs!=""){
    }else{
        alert("Error:Por favor, ingrese un Id")
    }

}