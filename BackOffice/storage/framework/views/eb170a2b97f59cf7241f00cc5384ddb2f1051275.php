<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Camiones</title>
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
     <?php if (isset($component)) { $__componentOriginal918cff40c428c0f25a6edd5e50af677c3b429813 = $component; } ?>
<?php $component = App\View\Components\TablaCamionesComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tabla-camiones-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\TablaCamionesComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal918cff40c428c0f25a6edd5e50af677c3b429813)): ?>
<?php $component = $__componentOriginal918cff40c428c0f25a6edd5e50af677c3b429813; ?>
<?php unset($__componentOriginal918cff40c428c0f25a6edd5e50af677c3b429813); ?>
<?php endif; ?>
     </div>
    </div>
    <div> 
    <a href="<?php echo e(route('camion.camionLlevaLote')); ?>">Asignar Lotes a Camiones-></a>
      <div class="cajaDatos"> 
         <form action="<?php echo e(route('camiones.realizarAccion')); ?>" method="POST">
          <?php echo csrf_field(); ?>
            <fieldset>
               <legend>Selecciona una accion:</legend>
                 <div>
                  <input type="radio" id="agregar" name="accion" value="agregar" checked />
                  <label for="agregar">Agregar</label>
                 </div>
                 <div>
                   <input type="radio" id="modificar" name="accion" value="modificar" />
                   <label for="modificar">Modificar</label>
                </div>
                <div>
                 <input type="radio" id="eliminar" name="accion" value="eliminar" />
                 <label for="eliminar">Eliminar</label>
                </div>
                <div>
                 <input type="radio" id="recuperar" name="accion" value="recuperar" />
                 <label for="recuperar">Recuperar</label>
               </div >
             </fieldset>
          <div class="contenedorDatos">
            <div class="campo">
            <input type="text" id="matricula" name="matricula" maxlength="10"></input>
            <label for="matricula" >Matricula</label>
          </div>
          <div class="campo">
          <?php if (isset($component)) { $__componentOriginale84329a119a4c10145f91df92e04e8853c2c100f = $component; } ?>
<?php $component = App\View\Components\SelectEstadoCamionComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-estado-camion-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectEstadoCamionComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale84329a119a4c10145f91df92e04e8853c2c100f)): ?>
<?php $component = $__componentOriginale84329a119a4c10145f91df92e04e8853c2c100f; ?>
<?php unset($__componentOriginale84329a119a4c10145f91df92e04e8853c2c100f); ?>
<?php endif; ?>
          </div>
          <div class="campo">
          <?php if (isset($component)) { $__componentOriginala78669e27615b95d9a5bfb9790440d01001aa9f0 = $component; } ?>
<?php $component = App\View\Components\SelectMarcaModeloComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-marca-modelo-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectMarcaModeloComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala78669e27615b95d9a5bfb9790440d01001aa9f0)): ?>
<?php $component = $__componentOriginala78669e27615b95d9a5bfb9790440d01001aa9f0; ?>
<?php unset($__componentOriginala78669e27615b95d9a5bfb9790440d01001aa9f0); ?>
<?php endif; ?>
          </div>
          <div class="campo">
          <?php if (isset($component)) { $__componentOriginalbd7e8ca10d30cd69ff9ef960cb5a86fa6560cc83 = $component; } ?>
<?php $component = App\View\Components\SelectChoferesComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-choferes-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectChoferesComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd7e8ca10d30cd69ff9ef960cb5a86fa6560cc83)): ?>
<?php $component = $__componentOriginalbd7e8ca10d30cd69ff9ef960cb5a86fa6560cc83; ?>
<?php unset($__componentOriginalbd7e8ca10d30cd69ff9ef960cb5a86fa6560cc83); ?>
<?php endif; ?>
          </div>
          <div class="campo">
          <input type="text" id="volumen" name="volumen" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="9" required>
          <label for="volumen" >Volumen(L)</label>
      </div>
      <div class="campo">
      <input type="text" id="peso" name="peso" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="9" required>
          <label for="peso" >Peso(Kg)</label>
</div>
          <div class="campo">
            <input type="hidden" name="identificador" id="identificador"> </input>
          </div>
          <div class="campo">
          <button type="submit">Aceptar</button>
          </div>
        </form>
       </div>
       <form action="<?php echo e(route('camiones.cargarDatos')); ?>" method="GET">
         <?php echo csrf_field(); ?>
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       </div>
     </div>
    </div>
    <?php if (isset($component)) { $__componentOriginalf234d685a623fd18d9c27d1d49bc223ee7408adf = $component; } ?>
<?php $component = App\View\Components\MensajeRespuestaComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('mensaje-respuesta-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\MensajeRespuestaComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf234d685a623fd18d9c27d1d49bc223ee7408adf)): ?>
<?php $component = $__componentOriginalf234d685a623fd18d9c27d1d49bc223ee7408adf; ?>
<?php unset($__componentOriginalf234d685a623fd18d9c27d1d49bc223ee7408adf); ?>
<?php endif; ?>
  </body>
  
  <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/vistaBackOfficeCamiones.blade.php ENDPATH**/ ?>