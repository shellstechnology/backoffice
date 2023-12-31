<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Almacenes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/funciones.js')}}"> </script>
    <script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
  <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
</head>
  <body>
  <div class="barraDeNavegacion">
  <a href="{{ route('backoffice') }}" class="item">Menu Principal</a>
     <a href="{{ route('backoffice.almacen') }}" class="itemSeleccionado">Almacenes</a>
     <a href="{{ route('backoffice.camiones') }}" class="item">Camiones</a>
     <a href="{{ route('backoffice.marca') }}" class="item">Marcas(Camiones)</a>
     <a href="{{ route('backoffice.moneda') }}" class="item">Moneda</a>
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
        <fieldset>
               <legend>Selecciona una accion:</legend>
                 <div>
                  <input type="radio" id="agregar" name="accion" value="agregar" checked />
                  <label for="agregar">Agregar</label>
                 </div>
                 <div>
                   <input type="radio" id="modificar" name="accion" value="modificar" />
                   <label for="modificar">Modificar</label>
                </div>
                <div>
                 <input type="radio" id="eliminar" name="accion" value="eliminar" />
                 <label for="eliminar">Eliminar</label>
                </div>
                <div>
                 <input type="radio" id="recuperar" name="accion" value="recuperar" />
                 <label for="recuperar">Recuperar</label>
               </div >
             </fieldset>
        <div class="contenedorDatos">
          <div class="campo">
            <input type="text" id="direccion" name="direccion" maxlength="100" ></input>
           <label for="direccion" >Direccion</label>
         </div>
         <div class="campo">
            <input type="text" id="latitud" name="latitud" onkeydown="filtro(event)" 
            pattern="-?[0-9]*[.,]?[0-9]+" maxlength="16" >
          <label for="latitud" >Latitud</label>
            </div>
            <div class="campo">
            <input type="text" id="longitud" name="longitud" onkeydown="filtro(event)" 
            pattern="-?[0-9]*[.,]?[0-9]+" maxlength="16" >
          <label for="longitud" >Longitud</label>
          </div>
          <div id="map">

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
</div>
<x-mensaje-respuesta-component/>
  </body>
</html>