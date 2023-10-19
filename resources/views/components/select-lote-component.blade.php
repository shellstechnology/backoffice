@php
$datos = session('idLotes', []);
@endphp

@if (!empty($datos))
    <select id="idLote" name="idLote">
        @foreach ($datos as $lote)
            <option value="{{$lote}}">{{ $lote}}</option>
        @endforeach
    </select>
    <label for="lote">Lote</label>
@endif
