<div>
@php
    use Illuminate\Support\Facades\Session;
    $mensaje = session('respuesta', '');
@endphp
@if(!empty($mensaje))
    <script>
        window.addEventListener('load', () => {
            alert("{{ $mensaje }}");
        });
    </script>
    @php
        Session::put('respuesta', '');
    @endphp
@endif
