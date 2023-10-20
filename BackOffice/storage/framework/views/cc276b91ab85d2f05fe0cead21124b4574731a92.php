<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Lotes</title>
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
     <a href="<?php echo e(route('backoffice.lote')); ?>" class="itemSeleccionado">Lotes</a>
    </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla">
    <?php if (isset($component)) { $__componentOriginal2871f0148ad173e4d6200b1b1269462c1eb993e1 = $component; } ?>
<?php $component = App\View\Components\TablaPaqueteContieneLoteComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tabla-paquete-contiene-lote-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\TablaPaqueteContieneLoteComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2871f0148ad173e4d6200b1b1269462c1eb993e1)): ?>
<?php $component = $__componentOriginal2871f0148ad173e4d6200b1b1269462c1eb993e1; ?>
<?php unset($__componentOriginal2871f0148ad173e4d6200b1b1269462c1eb993e1); ?>
<?php endif; ?>
    </div>
    </div>
    <div> 
    <a href="<?php echo e(route('backoffice.lote')); ?>"><-Crear Lotes</a>    
    <div class="cajaDatos"> 
    <form action="<?php echo e(route('paqueteContieneLote.realizarAccion')); ?>" method="POST">
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
       <?php if (isset($component)) { $__componentOriginal2d5cc4ef72dd099419a8697c4452f0db53027f1e = $component; } ?>
<?php $component = App\View\Components\SelectPaqueteComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-paquete-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectPaqueteComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2d5cc4ef72dd099419a8697c4452f0db53027f1e)): ?>
<?php $component = $__componentOriginal2d5cc4ef72dd099419a8697c4452f0db53027f1e; ?>
<?php unset($__componentOriginal2d5cc4ef72dd099419a8697c4452f0db53027f1e); ?>
<?php endif; ?>
        </div>
       <div class="campo">
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
        <div class="campo">
        <?php if (isset($component)) { $__componentOriginald5f1e03922e056f5e89da221149a7ca1d56f0af7 = $component; } ?>
<?php $component = App\View\Components\SelectAlmacenesComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-almacenes-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectAlmacenesComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald5f1e03922e056f5e89da221149a7ca1d56f0af7)): ?>
<?php $component = $__componentOriginald5f1e03922e056f5e89da221149a7ca1d56f0af7; ?>
<?php unset($__componentOriginald5f1e03922e056f5e89da221149a7ca1d56f0af7); ?>
<?php endif; ?>
          </div>
          <div class="contenedorDatos">
          <input type="hidden" name="identificador" id="identificador"></input>
          <button type="submit" name="aceptar">Aceptar</button>
          </form>
         </div>
      <form action="<?php echo e(route('paqueteContieneLote.cargarDatos')); ?>" method="GET">
         <?php echo csrf_field(); ?>
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
    </div>
  </div>
</div>
</div>
</body>
<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/vistaBackOfficePaqueteContieneLote.blade.php ENDPATH**/ ?>