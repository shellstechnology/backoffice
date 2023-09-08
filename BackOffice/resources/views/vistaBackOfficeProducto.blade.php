<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Producto</title>
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
    <div class="itemSeleccionado" onclick="redireccionar('{{route('backoffice.producto')}}')"> Productos</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.lote')}}')"> Lotes</div>
   </div>
  <div class="container">
    <div class="cuerpo">
     <div id="contenedorTabla"></div>
    </div>
    <div> 
      <div class="cajaDatos"> 
         <form action="{{route('producto.realizarAccion')}}" method="POST">
          @csrf
          <input type="checkbox" id="cbxAgregar" name="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
          <input type="checkbox" id="cbxModificar" name="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
          <input type="checkbox" id="cbxEliminar" name="cbxEliminar"onclick="comprobarCbxEliminar()">Eliminar </input>
          <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
          <div class="contenedorDatos">
            <div class="campo">
            <input type="text" id="nombre" name="nombre" maxlength="20"></input>
            <label for="nombreProducto" >Nombre</label>
          </div>
          <div class="campo">
            <input type="number" id="precio" name="precio" min="1" max="9999999" onkeydown="filtro(event)" oninput="limitarInput(this, 7)" onpaste="return false"></input>
            <label for="precioProducto" >Precio </label>
          </div>
          <div class="campo">
            <select id="tipoMoneda" name="tipoMoneda"> <select>
            <label for="tipoMoneda" >Tipo de moneda</label>
          </div>
          <div class="campo">
            <input type="number" id="stock" name="stock" min="0" max="9999999" onkeydown="filtro(event)" onpaste="return false";></input>
            <label for="stockProducto" >Stock</label>
            <input type="hidden" name="producto"> </input>
            <input type="hidden" name="identificador" id="identificador"> </input>
            <input type="hidden" id="moneda" name="moneda"  value="{{ json_encode(session('monedas', [])) }}"> </input>
          </div>
          <div class="campo">
          <button type="submit">Aceptar</button>
          </div>
        </form>
       </div>
       <form action="{{route('producto.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       <button type="button" name="cargarTabla" id="cargarTabla" onclick="crearTabla(6, {{json_encode(session('producto', []))}})">Cargar Tabla</button>
       </div>
     </div>
    </div>
  </body>
</html>