<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Almacenes</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>"> 
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="<?php echo e(asset('js/funciones.js')); ?>"> </script>
</head>
<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <body>
  <div class="barraDeNavegacion">
  <a href="<?php echo e(route('backoffice')); ?>" class="item">Menu Principal</a>
     <a href="<?php echo e(route('backoffice.almacen')); ?>" class="itemSeleccionado">Almacenes</a>
     <a href="<?php echo e(route('backoffice.camiones')); ?>" class="item">Camiones</a>
     <a href="<?php echo e(route('backoffice.paquete')); ?>" class="item">Paquetes</a>
     <a href="<?php echo e(route('backoffice.producto')); ?>" class="item">Productos</a>
     <a href="<?php echo e(route('backoffice.lote')); ?>" class="item">Lotes</a>
    </div>
    <div class="container">
     <div class="cuerpo">
     <div id="contenedorTabla">
     <?php if (isset($component)) { $__componentOriginal6bcb06632ac9be76c44d250300dc48c409d0eb44 = $component; } ?>
<?php $component = App\View\Components\TablaLugarEntregaComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tabla-lugar-entrega-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\TablaLugarEntregaComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6bcb06632ac9be76c44d250300dc48c409d0eb44)): ?>
<?php $component = $__componentOriginal6bcb06632ac9be76c44d250300dc48c409d0eb44; ?>
<?php unset($__componentOriginal6bcb06632ac9be76c44d250300dc48c409d0eb44); ?>
<?php endif; ?>
     </div>
      </div>
      <div> 
      <a href="<?php echo e(route('backoffice.almacen')); ?>"><-Almacen</a>
      <div class="cajaDatos"> 
      <form action="<?php echo e(route('lugarEntrega.realizarAccion')); ?>" method="POST">
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
            <input type="text" id="direccion" name="direccion" maxlength="100" required></input>
           <label for="direccion" >Direccion</label>
         </div>
         <div class="campo">
            <input type="text" id="latitud" name="latitud" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="16" required>
          <label for="latitud" >Latitud</label>
            </div>
            <div class="campo">
            <input type="text" id="longitud" name="longitud" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="16" required>
          <label for="longitud" >Longitud</label>
          </div>
          <div class="contenedorDatos">
          <input type="hidden" name="identificador" id="identificador">
          <button type="submit" name="aceptar">Aceptar</button>
        </div>
          </form>
       </div>
      <form action="<?php echo e(route('lugarEntrega.cargarDatos')); ?>" method="GET">
         <?php echo csrf_field(); ?>
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
     </div>
   </div>
</div>
  </body>
  <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/vistaBackOfficeLugarEntrega.blade.php ENDPATH**/ ?>