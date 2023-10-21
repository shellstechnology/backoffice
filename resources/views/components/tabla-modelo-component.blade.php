@php
$datos = session('modelo', []);
@endphp

<table class="tabla"> <tr>
    <th>Id</th>
    <th>Modelo</th>
    <th>Marca</th>
    <th>Fecha de creacion</th>
    <th>Ultima actualizacion</th>
    <th>Fecha de borrado</th>
    </tr>
    
    @foreach ($datos as $modelo)
    <tr onclick="seleccionarFila({{ $modelo['Id'] }}, '{{ $modelo['Modelo'] }}',
                                '{{ $modelo['Marca'] }}')">
    <td>{{ $modelo['Id'] }}</td>
    <td>{{ $modelo['Modelo'] }}</td>
    <td>{{ $modelo['Marca'] }}</td>
    <td>{{ $modelo['created_at'] }}</td>
    <td>{{ $modelo['updated_at'] }}</td>
    <td>{{ $modelo['deleted_at'] }}</td>
    </tr>
    @endforeach
    </table>

    <script> 
    function seleccionarFila(id, modelo,marca) {
        document.getElementById('identificador').value=id;
        document.getElementById('modelo').value=modelo;
        document.getElementById('marcaCamion').value=marca}
    </script>