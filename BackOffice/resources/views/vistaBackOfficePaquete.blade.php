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
       <input type="checkbox" id="cbxAgregar" name="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" id="cbxModificar" name="cbxModificar"onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" id="cbxEliminar" name="cbxEliminar"onclick="comprobarCbxEliminar()">Eliminar </input>
       <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
       <div class="contenedorDatos">
         <div class="campo">
         <select id="anio"> <select>
          <label for="anio" >Año</label>
          <select id="mes"> <select>
          <label for="mes" >Mes</label>
          <select id="dia"> <select>
          <label for="dia" >Dia</label>
        </div>
        <div class="campo">
        <select id="idLugarEntrega"> <select>
          <label for="idLugarEntrega" >Lugar de Entrega</label>
        </div>
      <div class="campo">
          <input type="text" id="caracteristica" maxlength="100"></input>
          <label for="caracteristica" >Caracteristica</label>
      </div>
      <div class="campo">
          <input type="text" id="nombreRemitente" maxlength="20"></input>
          <label for="nombreRemitente" >Nombre Remitente</label>
      </div>
      <div class="campo">
          <input type="text" id="nombreDestinatario" maxlength="20"></input>
          <label for="nombreDestinatario" >Nombre Destinatario</label>
      </div>
      <div class="campo">
      <select id="idProducto"> <select>
          <label for="idProducto" >Id Del Producto</label>
      </div>
      <div class="campo">
          <input type="number" id="volumen" min=0 max=999  onkeydown="filtro(event)" oninput="limitarInput(this, 3)" onpaste="return false"></input>
          <label for="volumen" >Volumen(L)</label>
      </div>
      <div class="campo">
          <input type="number" id="peso" min=0 max=999  onkeydown="filtro(event)" oninput="limitarInput(this, 3)" onpaste="return false"></input>
          <label for="peso" >Peso(Kg)</label>
</div>
<input type="hidden" name="identificador" id="identificador">
          <input type="hidden" name="idLugaresEntrega" id="idLugaresEntrega" value="{{ json_encode(session('idLugaresEntrega', [])) }}"></input>
          <button type="submit" name="aceptar">Aceptar</button>
</form>
      </div>
      <form action="{{route('paquete.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       <button type="button" name="cargarTabla" id="cargarTabla" onclick="crearTabla(5, {{json_encode(session('paquete', []))}})">Cargar Tabla</button>
      </div>
    </div>
  </div>
</body>
</html>