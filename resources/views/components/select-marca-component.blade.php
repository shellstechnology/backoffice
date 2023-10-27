@php
$datos = session('listaMarcas', []);
@endphp

@if (!empty($datos))
    <select id="marcaCamion" name="marcaCamion">
        @foreach ($datos as $marca)
            <option value="{{$marca}}">{{ $marca}}</option>
        @endforeach
    </select>
    <label for="marcaCamion">Marca</label>
@endif
