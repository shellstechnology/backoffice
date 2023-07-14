<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Menu Principal</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
</head>
<body>
<div class="barraDeNavegacion">
    <div class="item" onclick=almacenes()>Almacenes</div>
    <div class="item"> Almaceneros</div>
    <div class="item"> Camiones</div>
    <div class="item"> Camioneros</div>
    <div class="item"> Productos</div>
    <div class="item"> Paquetes</div>
    <div class="item"> Lotes</div>
</div>
    <br>
<form action="{{ route('producto.action') }}" method="POST">
    @csrf
    <button type="submit">Ejecutar</button>
</form>
    <button onclick="mostrarDato()">Ver dato</button>

        <script>
           function mostrarDato(){
                var x=@json($datos ?? []);
                console.log(x);
                <?php 
                    $valor = $datos
                ?>
           }

           function almacenes(){
            window.location.href = "{{ route('backoffice.almacenes') }}";
           }
         </script>
</body>
</html>