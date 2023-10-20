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
        Session::put('respuesta', ''); // Esto está bien para limpiar la sesión después de mostrar el mensaje
    @endphp
@endif
