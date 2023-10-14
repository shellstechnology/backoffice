@php
$datos = session('camionLlevaLote', []);
@endphp

<table class="tabla">
    <tr>
        <th>Id Lote</th>
        <th>Matricula Camion</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $camionLlevaLote)
        <tr onclick="seleccionarFila({{ $camionLlevaLote['Id Lote'] }}, '{{ $camionLlevaLote['Matricula Camion'] }}')">
            <td>{{ $camionLlevaLote['Id Lote'] }}</td>
            <td>{{ $camionLlevaLote['Matricula Camion'] }}</td>
            <td>{{ $camionLlevaLote['created_at'] }}</td>
            <td>{{ $camionLlevaLote['updated_at'] }}</td>
            <td>{{ $camionLlevaLote['deleted_at'] }}</td>
        </tr>
    @endforeach
</table>

<script>
    function seleccionarFila(lote, camion) {
        document.getElementById('identificador').value = lote;
        document.getElementById('idLote').value = lote;
        document.getElementById('idCamion').value = camion;
    }
</script>
