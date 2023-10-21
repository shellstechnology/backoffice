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
        <?php if (isset($component)) { $__componentOriginal6ff09980168b3c0566bf4b0f94fb2eb79600eb0a = $component; } ?>
<?php $component = App\View\Components\TablaAlmacenesComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tabla-almacenes-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\TablaAlmacenesComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6ff09980168b3c0566bf4b0f94fb2eb79600eb0a)): ?>
<?php $component = $__componentOriginal6ff09980168b3c0566bf4b0f94fb2eb79600eb0a; ?>
<?php unset($__componentOriginal6ff09980168b3c0566bf4b0f94fb2eb79600eb0a); ?>
<?php endif; ?>
        </div>
       </div>
       <div> 
       <a href="<?php echo e(route('almacen.lugarEntrega')); ?>">Luares de entrega-></a>
        <div class="cajaDatos"> 
         <form  action="<?php echo e(route('almacen.realizarAccion')); ?>" method="POST"> 
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
            <?php if (isset($component)) { $__componentOriginalbb38c154e038f02122b150ada6c59fab196ade45 = $component; } ?>
<?php $component = App\View\Components\SelectLugaresEntregaComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-lugares-entrega-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectLugaresEntregaComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb38c154e038f02122b150ada6c59fab196ade45)): ?>
<?php $component = $__componentOriginalbb38c154e038f02122b150ada6c59fab196ade45; ?>
<?php unset($__componentOriginalbb38c154e038f02122b150ada6c59fab196ade45); ?>
<?php endif; ?>
            </div>
           <div class="campo">
           <input type="hidden" name="identificador" id="identificador">
             <button type="submit" name='aceptar'>Aceptar</button>
           </div>
          </form>
          <form action="<?php echo e(route('almacen.cargarDatos')); ?>" method="GET">
            <button type="submit" name="cargar">Cargar Datos</button>
          </form>
       </div>
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
</html><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/vistaBackOfficeAlmacen.blade.php ENDPATH**/ ?>