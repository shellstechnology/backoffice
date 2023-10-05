@php
$datos = session('idAlmacenes', []);
@endphp


    <select id="idAlmacen" name="idAlmacen">
    @if (!empty($datos))
        @foreach ($datos as $Almacen)
            <option value="{{$Almacen}}">{{ $Almacen}}</option>
        @endforeach
    @endif
    </select>
    <label for="almacenes">Almacenes</label>

