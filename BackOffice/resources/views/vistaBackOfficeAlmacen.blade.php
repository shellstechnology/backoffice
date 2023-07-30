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
      <div class="item" onclick="redireccionar('{{route('backoffice.lote')}}')"> Lotes</div>
   </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla"></div>
    </div>
    <div> 
    <button onclick="redireccionar('{{route('almacen.lugarEntrega')}}')">Luares de entrega-></button>
    <div class="cajaDatos"> 
      <form  action="{{route('almacen.realizarAccion')}}" method="POST"> 
      @csrf
       <input type="checkbox" name="cbxAgregar" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" name="cbxModificar" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" name="cbxEliminar" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
       <div class="contenedorDatos">
    <div class="campo">
        <input type="text" name="direccion" id="direccion" maxlength="25">
        <label for="direccion">Direccion</label>
    </div>
    <div class="campo">
        <input type="number" name="latitud" id="latitud" min="-90" max="90" onkeydown="filtro(event)" oninput="limitarInput(this, 15)" onpaste="return false">
        <label for="latitud">Latitud</label>
    </div>
    <div class="campo">
        <input type="number" name="longitud" id="longitud" min="-180" max="180" onkeydown="filtro(event)" oninput="limitarInput(this, 15)" onpaste="return false">
        <label for="longitud">Longitud</label>
    </div>
    <input type="hidden" name="identificador" id="identificador">
    <button type="submit" name='aceptar'>Aceptar</button>
    </form>
    <form action="{{route('almacen.cargarDatos')}}" method="GET">
    <button type="submit" name="cargar">Cargar</button>
    </form>
    <button type="button" onclick="crearTabla(1, {{ json_encode($almacenes) }})">boton</button>
    <button onclick="recuperarDatos('{{route('almacen.recuperar')}}',
                                    '{{route('almacen.cargarDatos')}}')">Reestablecer Dato</button>
      </div>
    </div>
  </div>
</body>
</html>