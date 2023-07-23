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
    <div class="item"> Almaceneros</div>
    <div class="item"> Camiones</div>
    <div class="item"> Camioneros</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.paquete')}}')"> Paquetes</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.producto')}}')"> Productos</div>
    <div class="item"> Lotes</div>
</div>
    <br>
    <button onclick="mostrar()"> data</button>

    <script> 
    function mostrar(){
        console.log("{{ route('producto.cargarDatos') }}")
    }
</script>
</body>
</html>