@php
$datos = session('listaMarcaModelo', []);
@endphp

@if (!empty($datos))
    <select id="marcaModeloCamion" name="marcaModeloCamion">
        @foreach ($datos as $marcaModelo)
            <option value="{{$marcaModelo}}">{{ $marcaModelo}}</option>
        @endforeach
    </select>
    <label for="marcaModeloCamion">Marca/Modelo</label>
@endif
