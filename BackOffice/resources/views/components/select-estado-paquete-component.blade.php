@php
$datos = session('estadoPaquete', []);
@endphp

@if (!empty($datos))
    <select id="estado">
        @foreach ($datos as $estado)
            <option value="{{$estado}}">{{ $estado}}</option>
        @endforeach
    </select>
    <label for="estado">Estado</label>
@endif
