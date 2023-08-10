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
       <button type="button"  name="cargarTabla" id="cargarTabla" onclick="crearTabla(2, {{ json_encode(session('lotes', [])) }})">CargarTabla</button>
    </div>
  </div>
</body>
</html>