
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

function redireccionar(ruta) {
    window.location.href = ruta;
}
