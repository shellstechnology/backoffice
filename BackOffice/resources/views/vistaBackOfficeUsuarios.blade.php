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
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla"></div>
    </div>
    <div> 
    <button onclick="redireccionar('{{route('backoffice.lote')}}')"><-Crear Lotes</button>
    <div class="cajaDatos"> 
       <input type="checkbox" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
       
       <div class="contenedorDatos">
       <div class="campo">
        <select id="idLote"> <select>
          <label for="idLote" >Id del Lote</label>
        </div>
        <div class="campo">
        <select id="idPaquete"> <select>
          <label for="idPaquete" >Id del Paquete</label>
        </div>
        <div class="campo">
        <select id="idAlmacen"> <select>
          <label for="idAlmacen" >Id del Almacen</label>
        </div>
        <button id="cargar"onclick="cargarSelectsLote('{{route('lote.cargarDatos')}}',
                                                 '{{route('paquete.cargarDatos')}}',
                                                 '{{route('almacen.cargarDatos')}}');
                                                  cargarTabla('{{route('paqueteContieneLote.cargarDatos')}}'), 9">Cargar Tabla</button>
    <button onclick="validarInputs('{{ route('paqueteContieneLote.agregar') }}',
                                   '{{ route('paqueteContieneLote.modificar') }}',
                                   '{{ route('paqueteContieneLote.eliminar')}}',
                                   '{{route('paqueteContieneLote.cargarDatos')}}')">Aceptar</button>
    <button onclick="recuperarDatos('{{route('paqueteContieneLote.recuperar')}}',
                                    '{{route('paqueteContieneLote.cargarDatos')}}')">Reestablecer Dato</button>
      </div>
    </div>
  </div>
</body>
</html>