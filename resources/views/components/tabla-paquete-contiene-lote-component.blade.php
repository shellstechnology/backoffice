@php
$datos = session('paqueteContieneLote', []);
@endphp

<table class="tabla">
    <tr>
        <th>Id Paquete</th>
        <th>Lote</th>
        <th>Volumen(L)</th>
        <th>Peso(Kg)</th>
        <th>Almacen</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $paqueteLote)
    <tr onclick="seleccionarFila('{{ $paqueteLote['Id Paquete'] }}', '{{ $paqueteLote['Lote'] }}', '{{ $paqueteLote['Almacen'] }}')">
    <td>{{ $paqueteLote['Id Paquete'] }}</td>
    <td>{{ $paqueteLote['Lote'] }}</td>
    <td>{{ $paqueteLote['Volumen(L)'] }}</td>
    <td>{{ $paqueteLote['Peso(Kg)'] }}</td>
    <td>{{ $paqueteLote['Almacen'] }}</td>
    <td>{{ $paqueteLote['created_at'] }}</td>
    <td>{{ $paqueteLote['updated_at'] }}</td>
    <td>{{ $paqueteLote['deleted_at'] }}</td>
</tr>

    @endforeach
</table>

<script>
    function seleccionarFila(id, lote, almacen) {
        document.getElementById('identificador').value = id;
    document.getElementById('idPaquete').value = id;
    document.getElementById('idLote').value = lote;
    document.getElementById('idAlmacen').value = almacen;
    }
</script>