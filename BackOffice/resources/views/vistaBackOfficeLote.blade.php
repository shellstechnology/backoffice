<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Lote</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/funciones.js')}}"> </script>
  </head>
  <body>
    <div class="barraDeNavegacion">
    <a href="{{ route('backoffice') }}" class="item">Menu Principal</a>
     <a href="{{ route('backoffice.almacen') }}" class="item">Almacenes</a>
     <a href="{{ route('backoffice.camiones') }}" class="item">Camiones</a>
     <a href="{{ route('backoffice.paquete') }}" class="item">Paquetes</a>
     <a href="{{ route('backoffice.producto') }}" class="item">Productos</a>
     <a href="{{ route('backoffice.lote') }}" class="itemSeleccionado">Lotes</a>
    </div>
    <div class="container">
      <div class="cuerpo">
       <div id="contenedorTabla">
       <x-tabla-lote-component/>
       </div>
    </div>
    <div> 
    <a href="{{route('lote.paqueteContieneLote')}}">Cargar Paquetes-></a>
     <div class="cajaDatos"> 
        <form action="{{route('lote.realizarAccion')}}" method="POST">
        @csrf
        <input type="checkbox" id="cbxAgregar" name="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
        <input type="checkbox" id="cbxEliminar" name="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
        <input type="checkbox" id="cbxRecuperar" name="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
        <div class="contenedorDatos">
         <input type="hidden" name="identificador" id="identificador">
         <button type="submit" name="aceptar">Aceptar</button>
      </div>
     </form>
       <form action="{{route('lote.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar">Cargar Datos</button>
       </form>
    </div>
  </div>
</body>
</html>