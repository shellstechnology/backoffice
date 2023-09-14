<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Paquetes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <script src="{{asset('js/funciones.js')}}"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="barraDeNavegacion">
      <div class="item" onclick="redireccionar('{{route('backoffice')}}')"> Menu Principal</div>
      <div class="item" onclick="redireccionar('{{route('backoffice.almacen')}}')">Almacenes</div>
      <div class="item" onclick="redireccionar('{{route('backoffice.camiones')}}')"> Camiones</div>
    <div class="itemSeleccionado" onclick="redireccionar('{{route('backoffice.paquete')}}')"> Paquetes</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.producto')}}')"> Productos</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.lote')}}')"> Lotes</div>
   </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla"></div>
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
         <select name="anio" id="anio"> </select>
          <label for="anio" >Año</label>
          <select name="mes" id="mes"> </select>
          <label for="mes" >Mes</label>
          <select name="dia" id="dia"> </select>
          <label for="dia" >Dia</label>
        </div>
        <div class="campo">
        <select name="idLugarEntrega" id="idLugarEntrega"> <select>
          <label for="idLugarEntrega" >Lugar de Entrega</label>
        </div>
        <div class="campo">
          <select name="estado" id="estado"></select>
          <label for="estado" >Estado</label>
      </div>
      <div class="campo">
          <select name="caracteristica" id="caracteristica"></select>
          <label for="caracteristica" >Caracteristica</label>
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
      <select name="idProducto" id="idProducto"> </select>
          <label for="idProducto" >Id Del Producto</label>
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
          <input type="hidden" name="idLugaresEntrega" id="idLugaresEntrega" value="{{ json_encode(session('idLugaresEntrega', [])) }}"></input>
          <input type="hidden" name="idPaquete" id="idPaquete" value="{{ json_encode(session('paquete', [])) }}"></input>
          <input type="hidden" name="idProductos" id="idProductos" value="{{ json_encode(session('idProductos', [])) }}"></input>
          <input type="hidden" name="estadoPaquete" id="estadoPaquete" value="{{ json_encode(session('estadoPaquete', [])) }}"></input>
          <input type="hidden" name="descripcionCaracteristica" id="descripcionCaracteristica" value="{{ json_encode(session('descripcionCaracteristica', [])) }}"></input>
          <button type="submit" name="aceptar">Aceptar</button>
</form>
<form action="{{route('paquete.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       <button type="button" name="cargarTabla" id="cargarTabla" onclick="crearTabla(5, {{json_encode(session('paquete', []))}})">Cargar Tabla</button>
      </div>
      </div>
    </div>
  </div>
</body>
</html>