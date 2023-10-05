@php
$datos = session('idLugaresEntrega', []);
@endphp

    <select id="idLugarEntrega" name="idLugarEntrega">
    @if (!empty($datos))
        @foreach ($datos as $lugarEntrega)
            <option value="{{$lugarEntrega}}">{{ $lugarEntrega}}</option>
        @endforeach
        @endif
    </select>
    <label for="lugarEntrega">Lugar de Entrega</label>
