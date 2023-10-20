@php
$datos = session('usuarios', []);
@endphp
@if (!empty($datos))
<table class="tabla">
    <tr>
        <th>Id Usuario</th>
        <th>Nombre de Usuario</th>
        <th>Contraseña</th>
        <th>Mail</th>
        <th>Telefono/s</th>
        <th>Tipo de Usuario</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $usuario)
    <tr onclick="seleccionarFila('{{ $usuario['Id Usuario'] }}', '{{ $usuario['Nombre de Usuario'] }}', '{{ $usuario['contrasenia'] }}', '{{ $usuario['Mail'] }}', '{{ $usuario['Tipo de Usuario'] }}')">
    <td>{{ $usuario['Id Usuario'] }}</td>
    <td>{{ $usuario['Nombre de Usuario'] }}</td>
    <td>{{ $usuario['contrasenia'] }}</td>
    <td>{{ $usuario['Mail'] }}</td>
    <td>{{ $usuario['Telefono/s'] }}</td>
    <td>{{ $usuario['Tipo de Usuario'] }}</td>
    <td>{{ $usuario['created_at'] }}</td>
    <td>{{ $usuario['updated_at'] }}</td>
    <td>{{ $usuario['deleted_at'] }}</td>
</tr>

@endforeach
</table>
@endif

<script>
    function seleccionarFila(id,nombre,contrasenia,mail,tipoUsuario) {
        document.getElementById('identificador').value =id ;
    document.getElementById('nombre').value = nombre;
    document.getElementById('contrasenia').value = contrasenia;
    document.getElementById('mail').value = mail;
    obtenerTipoUsuario(tipoUsuario);

    }

    function obtenerTipoUsuario(tipoUsuario){
        document.getElementById("usuarioAdministrador").checked = false;
    document.getElementById("usuarioAlmacenero").checked = false;
    document.getElementById("usuarioChofer").checked = false;
    document.getElementById("usuarioCliente").checked = false;
    tipoUsuario = tipoUsuario.split('/')
    console.log(tipoUsuario)
    tipoUsuario.forEach(function (palabra) {
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
    
</script>
