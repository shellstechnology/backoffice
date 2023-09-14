<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Almacenes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <script src="{{asset('js/funciones.js')}}"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
  <body>
  <div class="barraDeNavegacion">
       <div class="item" onclick="redireccionar('{{route('backoffice')}}')"> Menu Principal</div>
       <div class="itemSeleccionado" onclick="redireccionar('{{route('backoffice.almacen')}}')">Almacenes</div>
       <div class="item" onclick="redireccionar('{{route('backoffice.camiones')}}')"> Camiones</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.paquete')}}')"> Paquetes</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.producto')}}')"> Productos</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.lote')}}')"> Lotes</div>
    </div>
    <div class="container">
     <div class="cuerpo">
     <div id="contenedorTabla"></div>
      </div>
      <div> 
      <button onclick="redireccionar('{{route('backoffice.almacen')}}')"><-Almacen</button>
      <div class="cajaDatos"> 
      <form action="{{route('lugarEntrega.realizarAccion')}}" method="POST">
        @csrf
        <input type="checkbox" name="cbxAgregar" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
            <input type="checkbox" name="cbxModificar" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
            <input type="checkbox" name="cbxEliminar" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
            <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
        <div class="contenedorDatos">
          <div class="campo">
            <input type="text" id="direccion" name="direccion" maxlength="25"></input>
           <label for="direccion" >Direccion</label>
         </div>
       <div class="campo">
           <input type="number" id="latitud" name="latitud" min="-90" max="90"  onkeydown="filtro(event)" oninput="limitarInput(this, 15) " onpaste="return false"></input>
           <label for="latitud" >Latitud</label>
        </div>
        <div class="campo">
          <input type="number" id="longitud" name="longitud" min="-180" max="180" onkeydown="filtro(event)" oninput="limitarInput(this, 15)" onpaste="return false" ></input>
          <label for="longitud" >Longitud</label>
          <div class="contenedorDatos">
          <input type="hidden" name="identificador" id="identificador">
          <input type="hidden" name="idAlmacenes" id="idAlmacenes" value="{{ json_encode(session('idAlmacenes', [])) }}"></input>
          <button type="submit" name="aceptar">Aceptar</button>
        </div>
          </form>
       </div>
      <form action="{{route('lugarEntrega.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       <button type="button" name="cargarTabla" id="cargarTabla" onclick="crearTabla(3, {{json_encode(session('lugaresEntrega', []))}})">Cargar Tabla</button>
     </div>
   </div>
  </body>
</html>