<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Lotes</title>
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
    <div class="itemSeleccionado" onclick="redireccionar('{{route('backoffice.lote')}}')"> Lotes</div>
</div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla"></div>
    </div>
    <div> 
    <button onclick="redireccionar('{{route('backoffice.lote')}}')"><-Crear Lotes</button>
    <div class="cajaDatos"> 
    <form action="{{route('paqueteContieneLote.realizarAccion')}}" method="POST">
        @csrf
       <input type="checkbox" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
       <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
       
       <div class="contenedorDatos">
       <div class="campo">
        <select id="idPaquete"> <select>
          <label for="idPaquete" >Id del Paquete</label>
        </div>
       <div class="campo">
        <select id="idLote"> <select>
          <label for="idLote" >Id del Lote</label>
        </div>
        <div class="campo">
        <select id="idAlmacen"> <select>
          <label for="idAlmacen" >Id del Almacen</label>
          </div>
          <div class="contenedorDatos">
          <input type="hidden" name="identificador" id="identificador"></input>
          <input type="hidden" name="idAlmacenes" id="idAlmacenes" value="{{ json_encode(session('idAlmacenes', [])) }}"></input>
          <input type="hidden" name="idPaquetes" id="idPaquetes" value="{{ json_encode(session('idPaquetes', [])) }}"></input>
          <input type="hidden" name="idLotes" id="idLotes" value="{{ json_encode(session('idLotes', [])) }}"></input>
          <button type="submit" name="aceptar">Aceptar</button>
          </form>
         </div>
      <form action="{{route('paqueteContieneLote.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       <button type="button" name="cargarTabla" id="cargarTabla" onclick="crearTabla(5, {{json_encode(session('paqueteContieneLote', []))}})">Cargar Tabla</button>
    </div>
  </div>
</body>
</html>