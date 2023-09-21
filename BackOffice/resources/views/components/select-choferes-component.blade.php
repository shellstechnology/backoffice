@php
$datos = session('listaChoferes', []);
@endphp

@if (!empty($datos))
    <select id="chofer"  name="chofer">
        @foreach ($datos as $camion)
            <option value="{{$camion}}">{{ $camion}}</option>
        @endforeach
    </select>
    <label for="choferesCamion">Chofer del Camion</label>
@endif
