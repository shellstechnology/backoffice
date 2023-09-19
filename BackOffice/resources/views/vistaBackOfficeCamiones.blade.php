<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Camiones</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <script src="{{asset('js/funciones.js')}}"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="barraDeNavegacion">
      <div class="item" onclick="redireccionar('{{route('backoffice')}}')"> Menu Principal</div>
      <div class="item" onclick="redireccionar('{{route('backoffice.almacen')}}')">Almacenes</div>
      <div class="itemSeleccionado" onclick="redireccionar('{{route('backoffice.camiones')}}')"> Camiones</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.paquete')}}')"> Paquetes</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.producto')}}')"> Productos</div>
    <div class="item" onclick="redireccionar('{{route('backoffice.lote')}}')"> Lotes</div>
   </div>
  <div class="container">
    <div class="cuerpo">
     <div id="contenedorTabla"></div>
    </div>
    <div> 
      <div class="cajaDatos"> 
         <form action="{{route('camiones.realizarAccion')}}" method="POST">
          @csrf
          <input type="checkbox" id="cbxAgregar" name="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
          <input type="checkbox" id="cbxModificar" name="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
          <input type="checkbox" id="cbxEliminar" name="cbxEliminar"onclick="comprobarCbxEliminar()">Eliminar </input>
          <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
          <div class="contenedorDatos">
            <div class="campo">
            <input type="text" id="matricula" name="matricula" maxlength="20"></input>
            <label for="matricula" >Matricula</label>
          </div>
          <div class="campo">
          <select name="estadoCamion" id="estadoCamion"> <select>
          <label for="estadoCamion" >Estado del Camion</label>
          </div>
          <div class="campo">
          <select name="marcaModeloCamion" id="marcaModeloCamion"> <select>
          <label for="marcaModeloCamion" >Marca y Modelo del Camion</label>
          </div>
          <div class="campo">
          <select name="chofer" id="chofer"> <select>
          <label for="chofer" >Chofer del Camion</label>
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
            <input type="hidden" name="producto"> </input>
            <input type="hidden" name="identificador" id="identificador"> </input>
          </div>
          <div class="campo">
          <button type="submit">Aceptar</button>
          </div>
        </form>
        <input type="hidden" id="listaEstado" name="listaEstado"  value="{{ json_encode(session('listaEstado', [])) }}"> </input>
        <input type="hidden" id="listaMarcaModelo" name="listaMarcaModelo"  value="{{ json_encode(session('listaMarcaModelo', [])) }}"> </input>
        <input type="hidden" id="listaChoferes" name="listaChoferes"  value="{{ json_encode(session('listaChoferes', [])) }}"> </input>
       </div>
       <form action="{{route('camiones.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       <button type="button" name="cargarTabla" id="cargarTabla" onclick="crearTabla(9, {{json_encode(session('camiones', []))}})">Cargar Tabla</button>
       </div>
     </div>
    </div>
  </body>
</html>