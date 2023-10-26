@php
$datos = session('idLugaresEntrega', []);
@endphp

@if (!empty($datos))
    <select id="idLugarEntrega" name="idLugarEntrega">
        @foreach ($datos as $lugarEntrega)
            <option value="{{$lugarEntrega['Id']}}">{{ $lugarEntrega['Id']}}</option>
        @endforeach
    </select>
    <label for="lugarEntrega">Lugar de Entrega</label>
@endif

<script>
    var lugarEntrega = @json($datos);
</script>

<div id="map">

</div>