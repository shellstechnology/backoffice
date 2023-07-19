
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
      <div class="item" onclick=almacenes()>Almacenes</div>
      <div class="item"> Almaceneros</div>
      <div class="item"> Camiones</div>
      <div class="item"> Camioneros</div>
      <div class="item"> Paquetes</div>
      <div class="item"> Lotes</div>
   </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedor-tabla"></div>
    </div>
    <div> 
    <div class="cajaDatos"> 
       <input type="checkbox" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
       <div class="contenedorDatos">
         <div class="campo">
          <input type="text" id="nombre" maxlength="20" onpaste="return false;"></input>
          <label for="nombreProducto" >Nombre</label>
        </div>
        <div class="campo">
          <input type="number" id="precio" min="1" max="9999999" onkeydown="filtro(event)" onpaste="return false";></input>
          <label for="precioProducto" >Precio </label>
        </div>
       <div class="campo">
          <input type="text" id="tipoMoneda" maxlength="3" onpaste="return false;"></input>
          <label for="monedaProducto" >Tipo de moneda</label>
       </div>
      <div class="campo">
          <input type="number" id="stock" min="0" max="9999999" onkeydown="filtro(event) onpaste="return false;""></input>
          <label for="stockProducto" >Stock</label>
      </div>
      <button onclick="validarInputs('{{ route('producto.agregar') }}',
                                   '{{ route('producto.modificar') }}',
                                   '{{ route('producto.eliminar')}}',
                                   '{{route('producto.cargarDatos')}}')">Aceptar</button>
    <button onclick="cargarTabla('{{route('producto.cargarDatos')}}'), 5">cargarTabla</button>
      </div>
    </div>
  </div>
</body>
</html>