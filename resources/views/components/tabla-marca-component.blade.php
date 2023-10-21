@php
$datos = session('marca', []);
@endphp

<table class="tabla"> <tr>
    <th>Id</th>
    <th>Marca</th>
    <th>Fecha de creacion</th>
    <th>Ultima actualizacion</th>
    <th>Fecha de borrado</th>
    </tr>
    
    @foreach ($datos as $marca)
    <tr onclick="seleccionarFila({{ $marca['Id'] }}, '{{ $marca['Marca'] }}')">
    <td>{{ $marca['Id'] }}</td>
    <td>{{ $marca['Marca'] }}</td>
    <td>{{ $marca['created_at'] }}</td>
    <td>{{ $marca['updated_at'] }}</td>
    <td>{{ $marca['deleted_at'] }}</td>
    </tr>
    @endforeach
    </table>

    <script> 
    function seleccionarFila(id, marca) {
        document.getElementById('identificador').value=id;
        document.getElementById('marca').value=marca}
    </script>