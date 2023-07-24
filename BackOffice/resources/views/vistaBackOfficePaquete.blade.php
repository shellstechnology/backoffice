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
    <button onclick="redireccionar('{{route('almacen.lugarEntrega')}}')">Luares de entrega-></button>
    <div class="cajaDatos"> 
       <input type="checkbox" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
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
          <input type="number" id="volumen" min=0 max=999></input>
          <label for="volumen" >Volumen(L)</label>
      </div>
      <div class="campo">
          <input type="number" id="peso" min=0 max=999></input>
          <label for="peso" >Peso(Kg)</label>
      </div>
      <button id="cargar" onclick="cargarFechasPaquete('{{route('producto.cargarDatos')}}','{{route('lugarEntrega.cargarDatos')}}');cargarTabla('{{route('paquete.cargarDatos')}}', 6)">Cargar Tabla</button>
    <button onclick="validarInputs('{{ route('paquete.agregar') }}',
                                   '{{ route('paquete.modificar') }}',
                                   '{{ route('paquete.eliminar')}}',
                                   '{{route('paquete.cargarDatos')}}')">Aceptar</button>
    <button onclick="recuperarDatos('{{route('paquete.recuperar')}}',
                                    '{{route('paquete.cargarDatos')}}')">Reestablecer Dato</button>
      </div>
    </div>
  </div>
</body>
</html>