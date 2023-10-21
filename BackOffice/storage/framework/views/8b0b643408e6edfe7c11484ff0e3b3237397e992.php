<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Usuario</title>
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
     <?php if (isset($component)) { $__componentOriginalc8870d9d3a7da5f01f466e7205a69301fab08194 = $component; } ?>
<?php $component = App\View\Components\TablaTelefonoUsuarioComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tabla-telefono-usuario-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\TablaTelefonoUsuarioComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8870d9d3a7da5f01f466e7205a69301fab08194)): ?>
<?php $component = $__componentOriginalc8870d9d3a7da5f01f466e7205a69301fab08194; ?>
<?php unset($__componentOriginalc8870d9d3a7da5f01f466e7205a69301fab08194); ?>
<?php endif; ?>
     </div>
      </div>
      <div> 
      <a href="<?php echo e(route('backoffice.usuarios')); ?>"><-Usuario</a>    
      <div class="cajaDatos"> 
      <form action="<?php echo e(route('telefonosUsuario.realizarAccion')); ?>" method="POST">
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
        <div class="contenedorDatos">
          <div class="campo">
          <?php if (isset($component)) { $__componentOriginal2864f5632fbff802f7a29db4d443e1067e47d786 = $component; } ?>
<?php $component = App\View\Components\SelectUsuarioComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-usuario-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectUsuarioComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2864f5632fbff802f7a29db4d443e1067e47d786)): ?>
<?php $component = $__componentOriginal2864f5632fbff802f7a29db4d443e1067e47d786; ?>
<?php unset($__componentOriginal2864f5632fbff802f7a29db4d443e1067e47d786); ?>
<?php endif; ?>
         </div>
       <div class="campo">
           <input type="text" id="telefono" name="telefono" onpaste="return false" required></input>
           <label for="latitud" >Numero de telefono</label>
        </div>
          <div class="contenedorDatos">
          <input type="hidden" name="identificadorId" id="identificadorId">
          <input type="hidden" name="identificadorTelefono" id="identificadorTelefono">
          <button type="submit" name="aceptar">Aceptar</button>
        </div>
          </form>
       </div>
      <form action="<?php echo e(route('telefonosUsuario.cargarDatos')); ?>" method="GET">
         <?php echo csrf_field(); ?>
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
     </div>
   </div>
</div>
  </body>
  <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/vistaBackOfficeTelefonosUsuario.blade.php ENDPATH**/ ?>