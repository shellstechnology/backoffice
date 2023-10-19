@php
$datos = session('idPaquetes', []);
@endphp

@if (!empty($datos))
    <select id="idPaquete" name="idPaquete">
        @foreach ($datos as $paquete)
            <option value="{{$paquete}}">{{ $paquete}}</option>
        @endforeach
    </select>
    <label for="paquete">Paquete</label>
@endif
