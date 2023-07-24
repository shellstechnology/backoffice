<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Usuarios</title>
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
    <div class="item" onclick="redireccionar('{{route('backoffice.lote')}}')"> Lotes</div>
    </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla"></div>
    </div>
    <div> 
    <div class="cajaDatos"> 
       <input type="checkbox" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
       
       <div class="contenedorDatos">
        <div class="campo">
          <input type="text" id="nombre" maxlength="20"></input>
          <label for="nombre" >Nombre de Usuario</label>
        </div>
        <div class="campo">
          <input type="text" id="contraseña" maxlength="20"></input>
          <label for="contraseña" >Contraseña</label>
        </div>
        <div class="campo">
          <input type="text" id="mail" maxlength="40"></input>
          <label for="mail" >Correo electronico</label>
        </div>
      <div class="campo">
          <input type="number" id="telefono" min="0" max="999999999" onkeydown="filtro(event)" onpaste="return false";></input>
          <label for="telefono" >Numero de Telefono</label>
        </div>
        <div class="campo">
          <select id="tipoUsuario"> <select>
          <label for="tipoUsuario" >Tipo de Usuario</label>
       </div>
        <button id="cargar"onclick="cargarSelectUsuario();
                                cargarTabla('{{route('usuario.cargarDatos')}}'), 10">Cargar Tabla</button>
    <button onclick="validarInputs('{{ route('usuario.agregar') }}',
                                   '{{ route('usuario.modificar') }}',
                                   '{{ route('usuario.eliminar')}}',
                                   '{{route('usuario.cargarDatos')}}')">Aceptar</button>
    <button onclick="recuperarDatos('{{route('usuario.recuperar')}}',
                                    '{{route('usuario.cargarDatos')}}')">Reestablecer Dato</button>
      </div>
    </div>
  </div>
</body>
</html>