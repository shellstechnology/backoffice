<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Usuario</title>
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
    <div class="item" onclick="redireccionar('{{route('backoffice.lote')}}')"> Lotes</div>
    </div>
    <div class="container">
     <div class="cuerpo">
     <div id="contenedorTabla"></div>
      </div>
      <div> 
      <button onclick="redireccionar('{{route('backoffice.usuarios')}}')"><-Usuarios</button>
      <div class="cajaDatos"> 
      <form action="{{route('telefonosUsuario.realizarAccion')}}" method="POST">
        @csrf
        <input type="checkbox" name="cbxAgregar" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
        <div class="item" onclick="redireccionar('{{route('backoffice.camiones')}}')"> Camiones</div>
            <input type="checkbox" name="cbxModificar" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
            <input type="checkbox" name="cbxEliminar" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
            <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
        <div class="contenedorDatos">
          <div class="campo">
        <select name="datoUsuario" id="datoUsuario"></select>
           <label for="datoUsuario" >Id del Usuario</label>
         </div>
       <div class="campo">
           <input type="text" id="telefono" name="telefono" onpaste="return false"></input>
           <label for="latitud" >Numero de telefono</label>
        </div>
          <div class="contenedorDatos">
          <input type="hidden" name="identificadorId" id="identificadorId">
          <input type="hidden" name="identificadorTelefono" id="identificadorTelefono">
          <input type="hidden" name="idUsuarios" id="idUsuarios" value="{{ json_encode(session('idUsuarios', [])) }}"></input>
          <button type="submit" name="aceptar">Aceptar</button>
        </div>
          </form>
       </div>
      <form action="{{route('telefonosUsuario.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       <button type="button" name="cargarTabla" id="cargarTabla" onclick="crearTabla(8, {{json_encode(session('telefonosUsuario', []))}})">Cargar Tabla</button>
     </div>
   </div>
  </body>
</html>