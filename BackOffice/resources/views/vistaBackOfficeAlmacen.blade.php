<!DOCTYPE html>
  <html lang="en">
  <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>BackOffice:Almacenes</title>
     <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
     <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    @include('header')
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
        <x-tabla-almacenes-component/>
        </div>
       </div>
       <div> 
        <button onclick="redireccionar('{{route('almacen.lugarEntrega')}}')">Luares de entrega-></button>
        <div class="cajaDatos"> 
         <form  action="{{route('almacen.realizarAccion')}}" method="POST"> 
            @csrf
            <input type="checkbox" name="cbxAgregar" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
            <input type="checkbox" name="cbxModificar" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
            <input type="checkbox" name="cbxEliminar" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
            <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
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
            <button type="submit" name="cargar">Cargar Datos</button>
          </form>
       </div>
     </div>
   </div>
</div>

  </body>
  @include('footer')
</html>