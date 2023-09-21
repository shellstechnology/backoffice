<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Usuarios</title>
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
     <a href="{{ route('backoffice.producto') }}" class="item">Productos</a>
     <a href="{{ route('backoffice.lote') }}" class="item">Lotes</a>
    </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla">
    <x-tabla-usuarios-component/>
    </div>
    </div>
    <div> 
    <a href="{{route('usuarios.telefonosUsuario')}}">Asignar Telefonos Usuario-></a>    
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
          <input type="text" name="contrasenia" id="contrasenia" maxlength="20"></input>
          <label for="contrasenia" >Contraseña</label>
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
      </div>
    </div>
  </div>
</body>
</html>