<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Paquetes</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/funciones.js')}}"> </script>
</head>

<body>
<div class="barraDeNavegacion">
    <a href="{{ route('backoffice') }}" class="item">Menu Principal</a>
     <a href="{{ route('backoffice.almacen') }}" class="item">Almacenes</a>
     <a href="{{ route('backoffice.camiones') }}" class="item">Camiones</a>
     <a href="{{ route('backoffice.paquete') }}" class="itemSeleccionado">Paquetes</a>
     <a href="{{ route('backoffice.producto') }}" class="item">Productos</a>
     <a href="{{ route('backoffice.lote') }}" class="item">Lotes</a>
   </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla">
    <x-tabla-paquete-component/>
    </div>
    </div>
    <div> 
    <div class="cajaDatos"> 

    <form action="{{route('paquete.realizarAccion')}}" method="POST">
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
        <duv class="campo">
          <input type="text" name="nombrePaquete" id="nombrePaquete" maxlength="50"></input>
          <label for="nombrePaquete">Nombre del Paquete</label>
        </div>
         <div class="campo">
         <x-select-fecha-component/>
        </div>
        <div class="campo">
        <x-select-lugares-entrega-component/>
        </div>
        <div class="campo">
        <x-select-estado-paquete-component/>
      </div>
      <div class="campo">
      <x-select-caracteristica-paquete-component/>
      </div>
      <div class="campo">
          <input type="text" name="nombreRemitente" id="nombreRemitente" maxlength="40"  ></input>
          <label for="nombreRemitente" >Nombre Remitente</label>
      </div>
      <div class="campo">
          <input type="text" name="nombreDestinatario" id="nombreDestinatario" maxlength="40"  ></input>
          <label for="nombreDestinatario" >Nombre Destinatario</label>
      </div>
      <div class="campo">
      <x-select-producto-component/>
      </div>
      <div class="campo">
          <input type="text" id="volumen" name="volumen" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="10"  >
          <label for="volumen" >Volumen(L)</label>
      </div>
      <div class="campo">
      <input type="text" id="peso" name="peso" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="10"  >
          <label for="peso" >Peso(Kg)</label>
</div>
<input type="hidden" name="identificador" id="identificador"></input>
          <button type="submit" name="aceptar">Aceptar</button>
</form>
<form action="{{route('paquete.cargarDatos')}}" method="GET">
         @csrf
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
      </div>
      </div>
    </div>
  </div>
</body>

</html>