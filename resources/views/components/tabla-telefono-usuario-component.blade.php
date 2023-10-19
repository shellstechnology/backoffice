@php
$datos = session('telefonosUsuario', []);
@endphp

<table class="tabla">
    <tr>
        <th>Id del Usuario</th>
        <th>Nombre de Usuario</th>
        <th>Telefono</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $usuario)
    <tr onclick="seleccionarFila({{ $usuario['Id del Usuario'] }},'{{ $usuario['Telefono'] }}')">
            <td>{{ $usuario['Id del Usuario'] }}</td>
            <td>{{ $usuario['Nombre de Usuario'] }}</td>
            <td>{{ $usuario['Telefono'] }}</td>
            <td>{{ $usuario['created_at'] }}</td>
            <td>{{ $usuario['updated_at'] }}</td>
            <td>{{ $usuario['deleted_at'] }}</td>
        </tr>
    @endforeach
</table>

<script>
    function seleccionarFila(id, telefono) {
    document.getElementById('identificadorId').value = id;
    document.getElementById('identificadorTelefono').value = telefono
    document.getElementById('datoUsuario').value = id;
    document.getElementById('telefono').value = telefono;
    }
</script>