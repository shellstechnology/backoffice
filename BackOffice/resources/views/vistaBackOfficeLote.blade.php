<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Lote</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <script src="{{asset('js/funciones.js')}}"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="barraDeNavegacion">
      <div class="item" onclick="redireccionar('{{route('backoffice')}}')"> Menu Principal</div>
      <div class="item" onclick="redireccionar('{{route('backoffice.almacen')}}')">Almacenes</div>
      <div class="item" onclick="redireccionar('{{route('backoffice.paquete')}}')"> Paquetes</div>
      <div class="item" onclick="redireccionar('{{route('backoffice.producto')}}')"> Productos</div>
   </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla"></div>
    </div>
    <div> 
    <button onclick="redireccionar('{{route('lote.paqueteContieneLote')}}')">Cargar Paquetes-></button>
    <div class="cajaDatos"> 
       <input type="checkbox" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
       <div class="contenedorDatos">
    <button id="cargar"onclick="cargarTabla('{{route('lote.cargarDatos')}}'), 8">Cargar Tabla</button>
    <button onclick="modificarLotes('{{ route('lote.crearLote') }}',
                                   '{{ route('lote.eliminar')}}',
                                   '{{route('lote.cargarDatos')}}')">Aceptar</button>
    <button onclick="recuperarDatos('{{route('lote.recuperar')}}',
                                    '{{route('lote.cargarDatos')}}')">Reestablecer Dato</button>
      </div>
    </div>
  </div>
</body>
</html>