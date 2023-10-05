<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Producto</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/funciones.js')}}"> </script>
</head>

<body>
  <div class="barraDeNavegacion">
  <a href="{{ route('backoffice') }}" class="item">Menu Principal</a>
     <a href="{{ route('backoffice.almacen') }}" class="item">Almacenes</a>
     <a href="{{ route('backoffice.camiones') }}" class="item">Camiones</a>
     <a href="{{ route('backoffice.paquete') }}" class="item">Paquetes</a>
     <a href="{{ route('backoffice.producto') }}" class="itemSeleccionado">Productos</a>
     <a href="{{ route('backoffice.lote') }}" class="item">Lotes</a>
   </div>
  <div class="container">
    <div class="cuerpo">
     <div id="contenedorTabla">
     <x-tabla-producto-component/>
     </div>
    </div>
    <div> 
      <div class="cajaDatos"> 
         <form action="{{route('producto.realizarAccion')}}" method="POST">
          @csrf
          <fieldset>
               <legend>Selecciona una accion:</legend>
                 <div>
                  <input type="radio" id="agregar" name="accion" value="agregar" checked />
                  <label for="agregar">Agregar</label>
                 </div>
                 <div>
                   <input type="radio" id="modificar" name="accion" value="modificar" />
                   <label for="dewey">Modificar</label>
                </div>
                <div>
                 <input type="radio" id="eliminar" name="accion" value="eliminar" />
                 <label for="louie">Eliminar</label>
                </div>
                <div>
                 <input type="radio" id="recuperar" name="accion" value="recuperar" />
                 <label for="louie">Recuperar</label>
               </div >
             </fieldset>
          <div class="contenedorDatos">
            <div class="campo">
            <input type="text" id="nombre" name="nombre" maxlength="50"  ></input>
            <label for="nombreProducto" >Nombre</label>
          </div>
          <div class="campo">
            <input type="number" id="precio" name="precio" min="1" max="99999999" onkeydown="filtro(event)" 
              oninput="limitarInput(this, 7)" onpaste="return false"  ></input>
            <label for="precioProducto" >Precio </label>
          </div>
          <div class="campo">
          <x-select-moneda-component/>
          </div>
          <div class="campo">
            <input type="number" id="stock" name="stock" min="0" max="999999" onkeydown="filtro(event)" 
            onpaste="return false";  ></input>
            <label for="stockProducto" >Stock</label>
            <input type="hidden" name="producto"> </input>
            <input type="hidden" name="identificador" id="identificador"> </input>
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
       </div>
     </div>
    </div>
  </body>
  
</html>