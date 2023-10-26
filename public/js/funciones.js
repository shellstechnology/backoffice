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
var puntos = [];
var nombres = [];
var ruta = [];
var planRuta = [];
var point;
var lastpoint;
var r = null;
var ubicacion = null;
var map;
var circulo = null;
var marcador = null;
var controlBoton = 1;
var markers = [];
var ubicacionSeleccionada = null;


document.addEventListener("DOMContentLoaded", function () {
    var mapElement = document.getElementById("map");
    if (mapElement) {
        var x = "-34.89945,-56.13177";
        map = L.map("map").setView([-34.89963, -56.13176], 13);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; OpenStreetMap contributors"
        }).addTo(map);
        var ubicacion = document.getElementById('latitud');
        if (ubicacion) {
            map.on('click', function (e) {
                asignarValores(e);
            });
        }
        var lugar = document.getElementById('idLugarEntrega');
        if (lugar) {
                asignarLugares(map);
        }
    }
});
function asignarValores(e) {
    var lat = e.latlng.lat.toString().slice(0, 16);
    var lon = e.latlng.lng.toString().slice(0, 16);
    if (ubicacionSeleccionada != null) {
        ubicacionSeleccionada.remove();
        ubicacionSeleccionada = null;
    }
    ubicacionSeleccionada = L.marker([lat, lon]).addTo(map);
    document.getElementById('latitud').value = lat
    document.getElementById('longitud').value = lon
}

function asignarLugares(map) {
    lugarEntrega.forEach(function (lugar) {
        var lat = lugar['Latitud'];
        var lon = lugar['Longitud'];
        var id = lugar['Id'];
        var marker = L.marker([lat, lon]).addTo(map);
        marker.on('click', function (e) {
            console.log(id)
            document.getElementById('idLugarEntrega').value = id;
        });
    });
}