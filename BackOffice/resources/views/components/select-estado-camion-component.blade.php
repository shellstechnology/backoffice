@php
$datos = session('listaEstado', []);
@endphp

@if (!empty($datos))
    <select id="estadoCamion" name="estadoCamion">
        @foreach ($datos as $estado)
            <option value="{{$estado}}">{{ $estado}}</option>
        @endforeach
    </select>
    <label for="estadoCamion">Estado del Camion</label>
@endif
