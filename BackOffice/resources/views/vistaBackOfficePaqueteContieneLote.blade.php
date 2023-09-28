<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Lotes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/funciones.js')}}"> </script>
</head>
@include('header')
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
    <x-tabla-paquete-contiene-lote-component/>
    </div>
    </div>
    <div> 
    <a href="{{route('backoffice.lote')}}"><-Crear Lotes</a>    
    <div class="cajaDatos"> 
    <form action="{{route('paqueteContieneLote.realizarAccion')}}" method="POST">
        @csrf
       <input type="checkbox" name="cbxAgregar" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" name="cbxModificar" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" name="cbxEliminar" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
       <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
       
       <div class="contenedorDatos">
       <div class="campo">
       <x-select-paquete-component/>
        </div>
       <div class="campo">
       <x-select-lote-component/>
        </div>
        <div class="campo">
        <x-select-almacenes-component/>
          </div>
          <div class="contenedorDatos">
          <input type="hidden" name="identificador" id="identificador"></input>
          <button type="submit" name="aceptar">Aceptar</button>
          </form>
         </div>
      <form action="{{route('paqueteContieneLote.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
    </div>
  </div>
</div>
</div>
</body>
@include('footer')
</html>