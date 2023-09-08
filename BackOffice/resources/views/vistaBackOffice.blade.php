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
    <div class="item" onclick="redireccionar('{{route('backoffice.almacen')}}')">Almacenes</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.paquete')}}')"> Paquetes</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.producto')}}')"> Productos</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.lote')}}')"> Lotes</div>
</div>
<div class="cajaUsuario"  onclick="redireccionar('{{route('backoffice.usuarios')}}')">
<div class="head"></div>
<div class="body"></div>
</div>
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
</html>