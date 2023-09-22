<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Almacenes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/funciones.js')}}"> </script>
</head>
  <body>
  <div class="barraDeNavegacion">
  <a href="{{ route('backoffice') }}" class="item">Menu Principal</a>
     <a href="{{ route('backoffice.almacen') }}" class="itemSeleccionado">Almacenes</a>
     <a href="{{ route('backoffice.camiones') }}" class="item">Camiones</a>
     <a href="{{ route('backoffice.paquete') }}" class="item">Paquetes</a>
     <a href="{{ route('backoffice.producto') }}" class="item">Productos</a>
     <a href="{{ route('backoffice.lote') }}" class="item">Lotes</a>
    </div>
    <div class="container">
     <div class="cuerpo">
     <div id="contenedorTabla">
     <x-tabla-lugar-entrega-component/>
     </div>
      </div>
      <div> 
      <a href="{{route('backoffice.almacen')}}"><-Almacen</a>
      <div class="cajaDatos"> 
      <form action="{{route('lugarEntrega.realizarAccion')}}" method="POST">
        @csrf
        <input type="checkbox" name="cbxAgregar" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
            <input type="checkbox" name="cbxModificar" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
            <input type="checkbox" name="cbxEliminar" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
            <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
        <div class="contenedorDatos">
          <div class="campo">
            <input type="text" id="direccion" name="direccion" maxlength="100"></input>
           <label for="direccion" >Direccion</label>
         </div>
         <div class="campo">
            <input type="text" id="latitud" name="latitud" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="16" required>
          <label for="latitud" >Latitud</label>
            </div>
            <div class="campo">
            <input type="text" id="longitud" name="longitud" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="16" required>
          <label for="longitud" >Longitud</label>
          </div>
          <div class="contenedorDatos">
          <input type="hidden" name="identificador" id="identificador">
          <button type="submit" name="aceptar">Aceptar</button>
        </div>
          </form>
       </div>
      <form action="{{route('lugarEntrega.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
     </div>
   </div>
  </body>
</html>