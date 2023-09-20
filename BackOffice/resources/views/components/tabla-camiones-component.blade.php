@php
$datos = session('camiones', []);
@endphp
@if (!empty($datos))
<table class="tabla">
    <tr>
        <th>Matricula</th>
        <th>Marca y Modelo</th>
        <th>Estado</th>
        <th>Chofer</th>
        <th>Volumen Maximo</th>
        <th>Peso Maximo</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $camiones)
    <tr onclick="seleccionarFila('{{ $camiones['Matricula'] }}', '{{ $camiones['Marca y Modelo'] }}',
                 '{{ $camiones['Estado'] }}', '{{ $camiones['Chofer'] }}',{{ $camiones['Volumen Maximo'] }},
                 {{ $camiones['Peso Maximo'] }})">
        <td>{{ $camiones['Matricula'] }}</td>
        <td>{{ $camiones['Marca y Modelo'] }}</td>
        <td>{{ $camiones['Estado'] }}</td>
        <td>{{ $camiones['Chofer'] }}</td>
        <td>{{ $camiones['Volumen Maximo'] }}</td>
        <td>{{ $camiones['Peso Maximo'] }}</td>
        <td>{{ $camiones['created_at'] }}</td>
        <td>{{ $camiones['updated_at'] }}</td>
        <td>{{ $camiones['deleted_at'] }}</td>
    </tr>
@endforeach
</table>
@endif

<script>
    function seleccionarFila(matricula, marcaModelo, estado,choferes, volumen,peso) {
        document.getElementById('identificador').value = matricula;
        document.getElementById('matricula').value = matricula;
        document.getElementById('marcaModeloCamion').value = marcaModelo;
        document.getElementById('estadoCamion').value =  estado;
        document.getElementById('choferesCamion').value =  choferes;
        document.getElementById('volumen').value = volumen;
        document.getElementById('peso').value = peso;
    }
</script>
