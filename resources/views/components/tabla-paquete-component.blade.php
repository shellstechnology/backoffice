@php
$datos = session('paquete', []);
@endphp

<table class="tabla">
    <tr>
        <th>Id Paquete</th>
        <th>Nombre del Paquete</th>
        <th>Direccion</th>
        <th>Latitud</th>
        <th>Longitud</th>
        <th>Estado</th>
        <th>Caracteristicas</th>
        <th>Nombre del Remitente</th>
        <th>Nombre del Destinatario</th>
        <th>Id del Producto</th>
        <th>Producto</th>
        <th>Volumen(L)</th>
        <th>Peso(Kg)</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @if($datos)
    @foreach ($datos as $paquete)
    <tr onclick="seleccionarFila('{{ $paquete['Id Paquete'] }}','{{ $paquete['Nombre del Paquete'] }}','{{ $paquete['Direccion'] }}','{{ $paquete['Latitud'] }}','{{ $paquete['Longitud'] }}','{{ $paquete['Estado'] }}',
    '{{ $paquete['Caracteristicas'] }}','{{ $paquete['Nombre del Remitente'] }}','{{ $paquete['Nombre del Destinatario'] }}',
    '{{ $paquete['Id del Producto'] }}','{{ $paquete['Volumen(L)'] }}','{{ $paquete['Peso(Kg)'] }}'
)">
            <td>{{ $paquete['Id Paquete'] }}</td>
            <td>{{ $paquete['Nombre del Paquete'] }}</td>
            <td>{{ $paquete['Direccion'] }}</td>
            <td>{{ $paquete['Longitud'] }}</td>
            <td>{{ $paquete['Latitud'] }}</td>
            <td>{{ $paquete['Estado'] }}</td>
            <td>{{ $paquete['Caracteristicas'] }}</td>
            <td>{{ $paquete['Nombre del Remitente'] }}</td>
            <td>{{ $paquete['Nombre del Destinatario'] }}</td>
            <td>{{ $paquete['Id del Producto'] }}</td>
            <td>{{ $paquete['Producto'] }}</td>
            <td>{{ $paquete['Volumen(L)'] }}</td>
            <td>{{ $paquete['Peso(Kg)'] }}</td>
            <td>{{ $paquete['created_at'] }}</td>
            <td>{{ $paquete['updated_at'] }}</td>
            <td>{{ $paquete['deleted_at'] }}</td>
        </tr>
    @endforeach
    @endif
</table>

<script>
    function seleccionarFila(id, nombre,direccion,latitud,longitud,estado,caracteristica,nombreRemitente,
                                nombreDestinatario,producto,volumen,peso) {
    document.getElementById('identificador').value = id;
    document.getElementById('nombrePaquete').value = nombre;
    document.getElementById('direccion').value = direccion;
    document.getElementById('latitud').value = latitud;
    document.getElementById('longitud').value = longitud;
    document.getElementById('estadoPaquete').value = estado;
    document.getElementById('caracteristica').value = caracteristica;
    document.getElementById('nombreRemitente').value = nombreRemitente;
    document.getElementById('nombreDestinatario').value = nombreDestinatario;
    document.getElementById('idProducto').value = producto;
    document.getElementById('volumen').value = volumen;
    document.getElementById('peso').value = peso;
    }
</script>