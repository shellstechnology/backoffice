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
@include('header')
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
        <div class="campo">
          <input type="text" name="nombre" id="nombre" maxlength="50" required></input>
          <label for="nombre" >Nombre de Usuario</label>
        </div>
        <div class="campo">
          <input type="text" name="contrasenia" id="contrasenia" maxlength="25" required></input>
          <label for="contrasenia" >Contraseña</label>
        </div>
        <div class="campo">
          <input type="text" name="mail" id="mail" maxlength="50" required></input>
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
@include('footer')
</html>