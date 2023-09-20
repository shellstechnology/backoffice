<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Paquetes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/funciones.js')}}"> </script>
</head>
<body>
<div class="barraDeNavegacion">
    <a href="{{ route('backoffice') }}" class="item">Menu Principal</a>
     <a href="{{ route('backoffice.almacen') }}" class="item">Almacenes</a>
     <a href="{{ route('backoffice.camiones') }}" class="item">Camiones</a>
     <a href="{{ route('backoffice.paquete') }}" class="itemSeleccionado">Paquetes</a>
     <a href="{{ route('backoffice.producto') }}" class="item">Productos</a>
     <a href="{{ route('backoffice.lote') }}" class="item">Lotes</a>
   </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla">
    <x-tabla-paquete-component/>
    </div>
    </div>
    <div> 
    <div class="cajaDatos"> 

    <form action="{{route('paquete.realizarAccion')}}" method="POST">
      @csrf
       <input type="checkbox" id="cbxAgregar" name="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" id="cbxModificar" name="cbxModificar"onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" id="cbxEliminar" name="cbxEliminar"onclick="comprobarCbxEliminar()">Eliminar </input>
       <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
       <div class="contenedorDatos">
        <duv class="campo">
          <input type="text" name="nombrePaquete" id="nombrePaquete"></input>
          <label for="nombrePaquete">Nombre del Paquete</label>
        </div>
         <div class="campo">
         <x-select-fecha-component/>
        </div>
        <div class="campo">
        <select name="idLugarEntrega" id="idLugarEntrega"> <select>
          <label for="idLugarEntrega" >Lugar de Entrega</label>
        </div>
        <div class="campo">
        <x-select-estado-paquete-component/>
      </div>
      <div class="campo">
      <x-select-caracteristica-paquete-component/>
      </div>
      <div class="campo">
          <input type="text" name="nombreRemitente" id="nombreRemitente" maxlength="50"></input>
          <label for="nombreRemitente" >Nombre Remitente</label>
      </div>
      <div class="campo">
          <input type="text" name="nombreDestinatario" id="nombreDestinatario" maxlength="50"></input>
          <label for="nombreDestinatario" >Nombre Destinatario</label>
      </div>
      <div class="campo">
      <x-select-producto-component/>
      </div>
      <div class="campo">
          <input type="text" id="volumen" name="volumen" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="9" required>
          <label for="volumen" >Volumen(L)</label>
      </div>
      <div class="campo">
      <input type="text" id="peso" name="peso" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="9" required>
          <label for="peso" >Peso(Kg)</label>
</div>
<input type="hidden" name="identificador" id="identificador"></input>
          <button type="submit" name="aceptar">Aceptar</button>
</form>
<form action="{{route('paquete.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
      </div>
      </div>
    </div>
  </div>


</body>
</html>