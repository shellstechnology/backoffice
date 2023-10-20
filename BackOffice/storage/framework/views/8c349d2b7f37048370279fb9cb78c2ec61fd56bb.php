<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Camion</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>"> 
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="<?php echo e(asset('js/funciones.js')); ?>"> </script>
</head>
<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <body>
  <div class="barraDeNavegacion">
  <a href="<?php echo e(route('backoffice')); ?>" class="item">Menu Principal</a>
     <a href="<?php echo e(route('backoffice.almacen')); ?>" class="item">Almacenes</a>
     <a href="<?php echo e(route('backoffice.camiones')); ?>" class="itemSeleccionado">Camiones</a>
     <a href="<?php echo e(route('backoffice.paquete')); ?>" class="item">Paquetes</a>
     <a href="<?php echo e(route('backoffice.producto')); ?>" class="item">Productos</a>
     <a href="<?php echo e(route('backoffice.lote')); ?>" class="item">Lotes</a>
    </div>
    <div class="container">
     <div class="cuerpo">
     <div id="contenedorTabla">
     <?php if (isset($component)) { $__componentOriginal3eb7bc0c70dfa6909c80e08eed4831702cff9d3b = $component; } ?>
<?php $component = App\View\Components\TablaCamionLlevaLoteComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tabla-camion-lleva-lote-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\TablaCamionLlevaLoteComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3eb7bc0c70dfa6909c80e08eed4831702cff9d3b)): ?>
<?php $component = $__componentOriginal3eb7bc0c70dfa6909c80e08eed4831702cff9d3b; ?>
<?php unset($__componentOriginal3eb7bc0c70dfa6909c80e08eed4831702cff9d3b); ?>
<?php endif; ?>
     </div>
      </div>
      <div> 
      <a href="<?php echo e(route('backoffice.camiones')); ?>"><-Crear Camiones</a>
      <div class="cajaDatos"> 
      <form action="<?php echo e(route('camionLlevaLote.realizarAccion')); ?>" method="POST">
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
        <?php if (isset($component)) { $__componentOriginal7ad9d271364d27e47a58b17c6734b6fe8d9df74b = $component; } ?>
<?php $component = App\View\Components\SelectCamionesComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-camiones-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectCamionesComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ad9d271364d27e47a58b17c6734b6fe8d9df74b)): ?>
<?php $component = $__componentOriginal7ad9d271364d27e47a58b17c6734b6fe8d9df74b; ?>
<?php unset($__componentOriginal7ad9d271364d27e47a58b17c6734b6fe8d9df74b); ?>
<?php endif; ?>
         </div>
         <div class="contenedorDatos">
        <?php if (isset($component)) { $__componentOriginaleecb2f147be379fa7e14616b6a701adcb1c6c77b = $component; } ?>
<?php $component = App\View\Components\SelectLoteComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-lote-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectLoteComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleecb2f147be379fa7e14616b6a701adcb1c6c77b)): ?>
<?php $component = $__componentOriginaleecb2f147be379fa7e14616b6a701adcb1c6c77b; ?>
<?php unset($__componentOriginaleecb2f147be379fa7e14616b6a701adcb1c6c77b); ?>
<?php endif; ?>
         </div>
          <div class="contenedorDatos">
          <input type="hidden" name="identificador" id="identificador">
          <button type="submit" name="aceptar">Aceptar</button>
        </div>
          </form>
          <form action="<?php echo e(route('camionLlevaLote.cargarDatos')); ?>" method="GET">
         <?php echo csrf_field(); ?>
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       </div>
     </div>
   </div>
</div>
  </body>
  <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/vistaBackOfficeCamionLlevaLote.blade.php ENDPATH**/ ?>