@php
$datos = session('lugaresEntrega', []);
@endphp

<table class="tabla">
    <tr>
        <th>Id Lugar</th>
        <th>Direccion Lugar</th>
        <th>Lat Lugar</th>
        <th>Lng Lugar</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $lugarEntrega)
    <tr onclick="seleccionarFila({{ $lugarEntrega['Id Lugar'] }}, '{{ $lugarEntrega['Direccion Lugar'] }}',
                 {{ $lugarEntrega['Lat Lugar'] }}, {{ $lugarEntrega['Lng Lugar'] }})">
            <td>{{ $lugarEntrega['Id Lugar'] }}</td>
            <td>{{ $lugarEntrega['Direccion Lugar'] }}</td>
            <td>{{ $lugarEntrega['Lat Lugar'] }}</td>
            <td>{{ $lugarEntrega['Lng Lugar'] }}</td>
            <td>{{ $lugarEntrega['created_at'] }}</td>
            <td>{{ $lugarEntrega['updated_at'] }}</td>
            <td>{{ $lugarEntrega['deleted_at'] }}</td>
        </tr>
    @endforeach
</table>

<script>
    function seleccionarFila(id, direccion, latitud, longitud) {
        document.getElementById('identificador').value = id;
        document.getElementById('direccion').value = direccion;
        document.getElementById('latitud').value = latitud;
        document.getElementById('longitud').value = longitud;
    }
</script>