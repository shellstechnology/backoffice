@php
$datos = session('lotes', []);
@endphp

<table class="tabla">
    <tr>
        <th>Id Lote</th>
        <th>Volumen (L)</th>
        <th>Peso (Kg)</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $lote)
        <tr onclick="seleccionarFila({{ $lote['Id Lote'] }}, '{{ $lote['Volumen(L)'] }}',
                     {{ $lote['Peso(Kg)'] }}, '{{ $lote['created_at'] }}',
                     '{{ $lote['updated_at'] }}', '{{ $lote['deleted_at'] }}')">
            <td>{{ $lote['Id Lote'] }}</td>
            <td>{{ $lote['Volumen(L)'] }}</td>
            <td>{{ $lote['Peso(Kg)'] }}</td>
            <td>{{ $lote['created_at'] }}</td>
            <td>{{ $lote['updated_at'] }}</td>
            <td>{{ $lote['deleted_at'] }}</td>
        </tr>
    @endforeach
</table>

<script>
    function seleccionarFila(id) {
        document.getElementById('identificador').value = id;
    }
</script>
