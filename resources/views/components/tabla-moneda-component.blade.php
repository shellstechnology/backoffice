@php
$datos = session('datosMonedas', []);
@endphp

<table class="tabla">
    <tr>
        <th>Id</th>
        <th>Nombre de la Moneda</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $moneda)
        <tr onclick="seleccionarFila({{ $moneda['Id'] }},
                     '{{ $moneda['Nombre'] }}')">
            <td>{{ $moneda['Id'] }}</td>
            <td>{{ $moneda['Nombre'] }}</td>
            <td>{{ $moneda['created_at'] }}</td>
            <td>{{ $moneda['updated_at'] }}</td>
            <td>{{ $moneda['deleted_at'] }}</td>
        </tr>
    @endforeach
</table>

<script>
    function seleccionarFila(id,nombre) {
        document.getElementById('identificador').value = id;
        document.getElementById('nombre').value = nombre;
    }
</script>
