<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Usuarios</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>"> 
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="<?php echo e(asset('js/funciones.js')); ?>"> </script>
</head>
<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body>
<div class="barraDeNavegacion">
     <a href="<?php echo e(route('backoffice')); ?>" class="item">Menu Principal</a>
     <a href="<?php echo e(route('backoffice.almacen')); ?>" class="item">Almacenes</a>
     <a href="<?php echo e(route('backoffice.camiones')); ?>" class="item">Camiones</a>
     <a href="<?php echo e(route('backoffice.paquete')); ?>" class="item">Paquetes</a>
     <a href="<?php echo e(route('backoffice.producto')); ?>" class="item">Productos</a>
     <a href="<?php echo e(route('backoffice.lote')); ?>" class="item">Lotes</a>
    </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla">
    <?php if (isset($component)) { $__componentOriginal875911d06a7b12bd13c16c33a4f936d14edc6958 = $component; } ?>
<?php $component = App\View\Components\TablaUsuariosComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tabla-usuarios-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\TablaUsuariosComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal875911d06a7b12bd13c16c33a4f936d14edc6958)): ?>
<?php $component = $__componentOriginal875911d06a7b12bd13c16c33a4f936d14edc6958; ?>
<?php unset($__componentOriginal875911d06a7b12bd13c16c33a4f936d14edc6958); ?>
<?php endif; ?>
    </div>
    </div>
    <div> 
    <a href="<?php echo e(route('usuarios.telefonosUsuario')); ?>">Asignar Telefonos Usuario-></a>    
    <div class="cajaDatos"> 
       <div class="contenedorDatos">
       <form action="<?php echo e(route('usuario.realizarAccion')); ?>" method="POST">
      <?php echo csrf_field(); ?>
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
       <form action="<?php echo e(route('usuario.cargarDatos')); ?>" method="GET">
         <?php echo csrf_field(); ?>
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
      </div>
    </div>
  </div>
</body>
<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/vistaBackOfficeUsuarios.blade.php ENDPATH**/ ?>