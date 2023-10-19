@php
$datos = session('descripcionCaracteristica', []);
@endphp

@if (!empty($datos))
    <select id="caracteristica" name="caracteristica">
        @foreach ($datos as $caracteristica)
            <option value="{{$caracteristica}}">{{ $caracteristica}}</option>
        @endforeach
    </select>
    <label for="caracteristica">Caracteristica</label>
@endif