@php
$datos = session('idLugaresEntrega', []);
@endphp

@if (!empty($datos))
    <select id="idlugarEntrega" name="idlugarEntrega">
        @foreach ($datos as $lugarEntrega)
            <option value="{{$lugarEntrega}}">{{ $lugarEntrega}}</option>
        @endforeach
    </select>
    <label for="lugarEntrega">Lugar de Entrega</label>
@endif
