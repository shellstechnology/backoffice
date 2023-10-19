@php
$datos = session('matriculaCamiones', []);
@endphp

@if (!empty($datos))
    <select id="idCamion" name="idCamion">
        @foreach ($datos as $Matricula)
            <option value="{{$Matricula}}">{{ $Matricula}}</option>
        @endforeach
    </select>
    <label for="idCamion">Matricula</label>
@endif
