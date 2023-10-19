@php
$datos = session('idProductos', []);
@endphp

@if (!empty($datos))
    <select id="idProducto" name="idProducto">
        @foreach ($datos as $producto)
            <option value="{{$producto}}">{{ $producto}}</option>
        @endforeach
    </select>
    <label for="producto">Id del Producto</label>
@endif
