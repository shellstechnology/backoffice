<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Menu Principal</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <script src="{{asset('js/funciones.js')}}"> </script>
</head>
<body>
<div class="barraDeNavegacion">
<a href="{{ route('backoffice') }}" class="itemSeleccionado">Menu Principal</a>
     <a href="{{ route('backoffice.almacen') }}" class="item">Almacenes</a>
     <a href="{{ route('backoffice.camiones') }}" class="item">Camiones</a>
     <a href="{{ route('backoffice.marca') }}" class="item">Marcas(Camiones)</a>
     <a href="{{ route('backoffice.moneda') }}" class="item">Moneda</a>
     <a href="{{ route('backoffice.paquete') }}" class="item">Paquetes</a>
     <a href="{{ route('backoffice.producto') }}" class="item">Productos</a>
     <a href="{{ route('backoffice.lote') }}" class="item">Lotes</a>
</div>
<a href="{{ route('backoffice.usuarios') }}" class="enlaceCajaUsuario">
<div class="cajaUsuario">
<div class="head"></div>
<div class="body"></div>
</div>
</a>
<header>
        <h1>Instrucciones de uso</h1>
    </header>
    <main>
        <section>
            <h2>Use la barra de navegación para desplazarse entre las distintas ventanas para ingresar datos</h2>
        </section>
        <section>
            <h2>Algunas paginas tienen un boton para acceder a una pagina anexada</h2>
        </section>
        <section>
            <h2>Use la ventana de la derecha para crear/modificar usuarios</h2>
        </section>
        <section>
            <h2>Cuando esté en una página, seleccione las checkbox para la acción que desee</h2>
        </section>
        <section>
            <h2>El botón "Restaurar" sirve para restaurar los datos borrados</h2>
        </section>
        <section>
            <h2>En caso de que quiera modificar, borrar o restaurar un dato,
                seleccione el dato en la tabla de la izquierda</h2>
        </section>
        <section>
            <h2>Las tablas no se cargarán si no tienen ningún dato dentro</h2>
        </section>
        <section>
            <h2>Debe llenar todos los campos para agregar/modificar un dato</h2>
        </section>
        <section>
            <h2>Los datos numéricos decimales deben ser ingresados con un punto como separador</h2>
        </section>
        <section>
            <h2>Los valores de latitud van desde -90 a 90 y los valores de longitud desde -180 a 180</h2>
        </section>
    </main>
</body>
@include('footer')
</html>