@php
$datos = session('listaChoferes', []);
@endphp

@if (!empty($datos))
    <select id="choferesCamion">
        @foreach ($datos as $camion)
            <option value="{{$camion}}">{{ $camion}}</option>
        @endforeach
    </select>
    <label for="choferesCamion">Chofer del Camion</label>
@endif
