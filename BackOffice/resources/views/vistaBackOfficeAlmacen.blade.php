<!DOCTYPE html>
<<<<<<< HEAD
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
        <div class="item"> Almaceneros</div>
        <div class="item"> Camiones</div>
        <div class="item"> Camioneros</div>
        <div class="item"> Paquetes</div>
        <div class="item" onclick="redireccionar('{{route('backoffice.producto')}}')"> Productos</div>
        <div class="item"> Lotes</div>
    </div>
    <div class="container">
        <div class="cuerpo">
            <div id="contenedorTabla"></div>
        </div>
        <div>
            <div class="cajaDatos">
                <input type="checkbox" id="cbxAgregar" onclick="comprobarCbxAgregar()">Agregar</input>
                <input type="checkbox" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
                <input type="checkbox" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
                <div class="contenedorDatos">
                    <div class="campo">
                        <input type="text" id="nombre" maxlength="20" onpaste="return false;" placeholder="Nombre del producto:"></input>

                    </div>
                    <div class="campo">
                        <input type="number" id="precio" min="1" max="9999999" onkeydown="filtro(event)" onpaste="return false" ; placeholder="Precio:"></input>

                    </div>
                    <div class="campo">
                        <input type="text" id="tipoMoneda" maxlength="3" onpaste="return false;" placeholder="Tipo de Moneda:"></input>

                    </div>
                    <div class="campo">
                        <input type="number" id="stock" min="0" max="9999999" onkeydown="filtro(event) onpaste=" return false;" placeholder="Stock del Producto:"></input>

                    </div>
                    <button onclick="cargarTabla('{{route('producto.cargarDatos')}}'), 5">Cargar Tabla</button>
                    <button onclick="validarInputs('{{ route('producto.agregar') }}',
                                   '{{ route('producto.modificar') }}',
                                   '{{ route('producto.eliminar')}}',
                                   '{{route('producto.cargarDatos')}}')">Aceptar</button>
                    <button onclick="recuperarDatos('{{route('producto.recuperar')}}',
                                    '{{route('producto.cargarDatos')}}')">Reestablecer Dato</button>
                </div>
            </div>
        </div>
</body>
</html>
=======
  <html lang="en">
  <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>BackOffice:Almacenes</title>
     <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <script src="{{asset('js/funciones.js')}}"> </script>

  </head>
  @include('header')
  <body>
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
       <a href="{{ route('almacen.lugarEntrega') }}">Luares de entrega-></a>
        <div class="cajaDatos"> 
         <form  action="{{route('almacen.realizarAccion')}}" method="POST"> 
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
            <x-select-lugares-entrega-component/>
            </div>
           <div class="campo">
           <input type="hidden" name="identificador" id="identificador">
             <button type="submit" name='aceptar'>Aceptar</button>
           </div>
          </form>
          <form action="{{route('almacen.cargarDatos')}}" method="GET">
            <button type="submit" name="cargar">Cargar Datos</button>
          </form>
       </div>
     </div>
   </div>
</div>
<x-mensaje-respuesta-component/>
  </body>
  @include('footer')
</html>
>>>>>>> 122f52c10f8cc85aed1e76066cf82b26c9c38683
