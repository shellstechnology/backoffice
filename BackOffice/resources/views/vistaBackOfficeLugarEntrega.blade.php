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
      <div class="item" onclick="redireccionar('{{route('backoffice.paquete')}}')"> Paquetes</div>
      <div class="item" onclick="redireccionar('{{route('backoffice.producto')}}')"> Productos</div>
      <div class="item"> Lotes</div>
   </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla"></div>
    </div>
    <div> 
    <button onclick="redireccionar('{{route('backoffice.almacen')}}')"><-Almacen</button>
    <div class="cajaDatos"> 
       <input type="checkbox" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
       
       <div class="contenedorDatos">
       <div class="campo">
        <select id="idAlmacen"> <select>
          <label for="idAlmacen" >Id del Almacen</label>
        </div>
         <div class="campo">
          <input type="text" id="direccion" maxlength="25"></input>
          <label for="nombreProducto" >Direccion</label>
        </div>
      <div class="campo">
          <input type="text" id="latitud" maxlength="20"></input>
          <label for="stockProducto" >Latitud</label>
      </div>
      <div class="campo">
          <input type="text" id="longitud" maxlength="20"></input>
          <label for="stockProducto" >Longitud</label>
      </div>
    <button id="cargar" onclick="cargarAlmacenes('{{route('almacen.cargarDatos')}}');cargarTabla('{{route('lugarEntrega.cargarDatos')}}', 2)">Cargar Tabla</button>
    <button onclick="validarInputs('{{ route('lugarEntrega.agregar') }}',
                                   '{{ route('lugarEntrega.modificar') }}',
                                   '{{ route('lugarEntrega.eliminar')}}',
                                   '{{route('lugarEntrega.cargarDatos')}}')">Aceptar</button>
    <button onclick="recuperarDatos('{{route('lugarEntrega.recuperar')}}',
                                    '{{route('lugarEntrega.cargarDatos')}}')">Reestablecer Dato</button>
      </div>
    </div>
  </div>
</body>
</html>