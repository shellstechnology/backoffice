<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Camiones</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/funciones.js')}}"> </script>
</head>
<body>
  <div class="barraDeNavegacion">
  <a href="{{ route('backoffice') }}" class="item">Menu Principal</a>
     <a href="{{ route('backoffice.almacen') }}" class="item">Almacenes</a>
     <a href="{{ route('backoffice.camiones') }}" class="itemSeleccionado">Camiones</a>
     <a href="{{ route('backoffice.paquete') }}" class="item">Paquetes</a>
     <a href="{{ route('backoffice.producto') }}" class="item">Productos</a>
     <a href="{{ route('backoffice.lote') }}" class="item">Lotes</a>
   </div>
  <div class="container">
    <div class="cuerpo">
     <div id="contenedorTabla">
     <x-tabla-camiones-component/>
     </div>
    </div>
    <div> 
    <a href="{{ route('camion.camionLlevaLote') }}">Asignar Lotes a Camiones-></a>
      <div class="cajaDatos"> 
         <form action="{{route('camiones.realizarAccion')}}" method="POST">
          @csrf
          <input type="checkbox" id="cbxAgregar" name="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
          <input type="checkbox" id="cbxModificar" name="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
          <input type="checkbox" id="cbxEliminar" name="cbxEliminar"onclick="comprobarCbxEliminar()">Eliminar </input>
          <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
          <div class="contenedorDatos">
            <div class="campo">
            <input type="text" id="matricula" name="matricula" maxlength="10"></input>
            <label for="matricula" >Matricula</label>
          </div>
          <div class="campo">
          <x-select-estado-camion-component/>
          </div>
          <div class="campo">
          <x-select-marca-modelo-component/>
          </div>
          <div class="campo">
          <x-select-choferes-component/>
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
          <div class="campo">
            <input type="hidden" name="identificador" id="identificador"> </input>
          </div>
          <div class="campo">
          <button type="submit">Aceptar</button>
          </div>
        </form>
       </div>
       <form action="{{route('camiones.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       </div>
     </div>
    </div>
  </body>
</html>