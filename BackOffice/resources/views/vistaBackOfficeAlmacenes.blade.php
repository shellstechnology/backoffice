
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Almacenes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <script src="{{asset('js/funciones.js')}}"> </script>
</head>
<body>
<div class="barraDeNavegacion">
    <div class="item" onclick="menu()"> Menu Principal</div>
    <div class="item"> Almaceneros</div>
    <div class="item"> Camiones</div>
    <div class="item"> Camioneros</div>
    <div class="item"> Productos</div>
    <div class="item"> Paquetes</div>
    <div class="item"> Lotes</div>
</div>
<div class="cuerpo">
<div id="contenedor-tabla"></div>
</div>

<form id="formularioBackoffice"action="{{ route('producto.action') }}" method="POST">
    @csrf
    <button type="submit">Ejecutar</button>
</form>
<button onclick=crearTabla(@json(session('datoProducto')))> Crear tabla</button>
   
    <script>
  
    </script>
    </div>
       
</body>
</html>