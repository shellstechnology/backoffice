@php
$datos = session('almacenes', []);
@endphp

<table class="tabla">
    <tr>
        <th>Id Almacen</th>
        <th>Id Lugar</th>
        <th>Direccion Almacen</th>
        <th>Lat Almacen</th>
        <th>Lng Almacen</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $almacen)

    <tr onclick="seleccionarFila({{ $almacen['Id Almacen'] }}, '{{ $almacen['Id Lugar'] }}')">
            <td>{{ $almacen['Id Almacen'] }}</td>
            <td>{{ $almacen['Id Lugar'] }}</td>
            <td>{{ $almacen['Direccion Almacen'] }}</td>
            <td>{{ $almacen['Lat Almacen'] }}</td>
            <td>{{ $almacen['Lng Almacen'] }}</td>
            <td>{{ $almacen['created_at'] }}</td>
            <td>{{ $almacen['updated_at'] }}</td>
            <td>{{ $almacen['deleted_at'] }}</td>
        </tr>
    @endforeach
</table>

<script>

    function seleccionarFila(id, lugar) {
        document.getElementById('identificador').value = id;
        document.getElementById('idLugarEntrega').value = lugar
    }
</script>
