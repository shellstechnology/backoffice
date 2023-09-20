@php
$datos = session('idAlmacenes', []);
@endphp

@if (!empty($datos))
    <select id="idAlmacen">
        @foreach ($datos as $Almacen)
            <option value="{{$Almacen}}">{{ $Almacen}}</option>
        @endforeach
    </select>
    <label for="almacenes">Almacenes</label>
@endif
