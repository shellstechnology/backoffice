@php
$datos = session('idUsuarios', []);
@endphp

@if (!empty($datos))
    <select id="datoUsuario" name="datoUsuario">
        @foreach ($datos as $usuario)
            <option value="{{$usuario}}">{{ $usuario}}</option>
        @endforeach
    </select>
    <label for="datoUsuario">Id del Usuario</label>
@endif
