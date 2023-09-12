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
    <button onclick="redireccionar('{{route('usuarios.telefonosUsuario')}}')">Telefonos-></button>
    <div class="cajaDatos"> 
       <div class="contenedorDatos">
       <form action="{{route('usuario.realizarAccion')}}" method="POST">
      @csrf
      <input type="checkbox" name="cbxAgregar" id="cbxAgregar" onclick="comprobarCbxAgregar()" >Agregar</input>
       <input type="checkbox" name="cbxModificar" id="cbxModificar" onclick="comprobarCbxModificar()">Modificar </input>
       <input type="checkbox" name="cbxEliminar" id="cbxEliminar" onclick="comprobarCbxEliminar()">Eliminar </input>
       <input type="checkbox" name="cbxRecuperar" id="cbxRecuperar" onclick="comprobarCbxRecuperar()">Recuperar </input>
        <div class="campo">
          <input type="text" name="nombre" id="nombre" maxlength="20"></input>
          <label for="nombre" >Nombre de Usuario</label>
        </div>
        <div class="campo">
          <input type="text" name="contraseña" id="contraseña" maxlength="20"></input>
          <label for="contraseña" >Contraseña</label>
        </div>
        <div class="campo">
          <input type="text" name="mail" id="mail" maxlength="40"></input>
          <label for="mail" >Correo electronico</label>
        </div>
        <div class="campo">
          <input type="checkbox" name="usuarioAdministrador" id="usuarioAdministrador">Administrador</input>
          <input type="checkbox" name="usuarioAlmacenero" id="usuarioAlmacenero">Almacenero</input>
          <input type="checkbox" name="usuarioChofer" id="usuarioChofer">Chofer</input>
          <input type="checkbox" name="usuarioCliente" id="usuarioCliente">Cliente</input>
        </div>
        <div class="campo">
          <input type="hidden" name="identificador" id="identificador"></input>
          <button type="submit">Aceptar</button>
        </div>

</form>
       </div>
       <form action="{{route('usuario.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       <button type="button" name="cargarTabla" id="cargarTabla" onclick="crearTabla(7, {{json_encode(session('usuarios', []))}})">Cargar Tabla</button>
      </div>
    </div>
  </div>
</body>
</html>