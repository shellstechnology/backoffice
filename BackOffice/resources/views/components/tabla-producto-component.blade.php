@php
$datos = session('producto', []);
@endphp

<table class="tabla">
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Stock</th>
        <th>Precio</th>
        <th>Moneda</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    @foreach ($datos as $producto)
    <tr onclick="seleccionarFila({{ $producto['Id'] }}, '{{ $producto['Nombre'] }}',
             {{ $producto['Stock'] }}, {{ $producto['Precio'] }}, '{{ $producto['Moneda'] }}')">
        <td>{{ $producto['Id'] }}</td>
        <td>{{ $producto['Nombre'] }}</td>
        <td>{{ $producto['Stock'] }}</td>
        <td>{{ $producto['Precio'] }}</td>
        <td>{{ $producto['Moneda'] }}</td>
        <td>{{ $producto['created_at'] }}</td>
        <td>{{ $producto['updated_at'] }}</td>
        <td>{{ $producto['deleted_at'] }}</td>
</tr>
    @endforeach
</table>

<script>
    function seleccionarFila(id, nombre,stock, precio, moneda) {
        document.getElementById('identificador').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('stock').value = stock;
        document.getElementById('precio').value = precio;
        document.getElementById('tipoMoneda').value = moneda;
    }
</script>