<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Paquetes</title>
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
     <a href="<?php echo e(route('backoffice.paquete')); ?>" class="itemSeleccionado">Paquetes</a>
     <a href="<?php echo e(route('backoffice.producto')); ?>" class="item">Productos</a>
     <a href="<?php echo e(route('backoffice.lote')); ?>" class="item">Lotes</a>
   </div>
  <div class="container">
    <div class="cuerpo">
    <div id="contenedorTabla">
    <?php if (isset($component)) { $__componentOriginaled6b2cce6f32104b1ecde83b45c00c28d5714a4a = $component; } ?>
<?php $component = App\View\Components\TablaPaqueteComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tabla-paquete-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\TablaPaqueteComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled6b2cce6f32104b1ecde83b45c00c28d5714a4a)): ?>
<?php $component = $__componentOriginaled6b2cce6f32104b1ecde83b45c00c28d5714a4a; ?>
<?php unset($__componentOriginaled6b2cce6f32104b1ecde83b45c00c28d5714a4a); ?>
<?php endif; ?>
    </div>
    </div>
    <div> 
    <div class="cajaDatos"> 

    <form action="<?php echo e(route('paquete.realizarAccion')); ?>" method="POST">
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
        <duv class="campo">
          <input type="text" name="nombrePaquete" id="nombrePaquete" maxlength="50"></input>
          <label for="nombrePaquete">Nombre del Paquete</label>
        </div>
         <div class="campo">
         <?php if (isset($component)) { $__componentOriginalf5bff054331c494562c89c7b99bb5cae2ab178ad = $component; } ?>
<?php $component = App\View\Components\SelectFechaComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-fecha-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectFechaComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf5bff054331c494562c89c7b99bb5cae2ab178ad)): ?>
<?php $component = $__componentOriginalf5bff054331c494562c89c7b99bb5cae2ab178ad; ?>
<?php unset($__componentOriginalf5bff054331c494562c89c7b99bb5cae2ab178ad); ?>
<?php endif; ?>
        </div>
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
        <?php if (isset($component)) { $__componentOriginal058795eed2c1bff1771617fe06c25e64368fb4ab = $component; } ?>
<?php $component = App\View\Components\SelectEstadoPaqueteComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-estado-paquete-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectEstadoPaqueteComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal058795eed2c1bff1771617fe06c25e64368fb4ab)): ?>
<?php $component = $__componentOriginal058795eed2c1bff1771617fe06c25e64368fb4ab; ?>
<?php unset($__componentOriginal058795eed2c1bff1771617fe06c25e64368fb4ab); ?>
<?php endif; ?>
      </div>
      <div class="campo">
      <?php if (isset($component)) { $__componentOriginal7dd39eff40fec467c3807498b1028299db01801d = $component; } ?>
<?php $component = App\View\Components\SelectCaracteristicaPaqueteComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-caracteristica-paquete-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectCaracteristicaPaqueteComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7dd39eff40fec467c3807498b1028299db01801d)): ?>
<?php $component = $__componentOriginal7dd39eff40fec467c3807498b1028299db01801d; ?>
<?php unset($__componentOriginal7dd39eff40fec467c3807498b1028299db01801d); ?>
<?php endif; ?>
      </div>
      <div class="campo">
          <input type="text" name="nombreRemitente" id="nombreRemitente" maxlength="40" required></input>
          <label for="nombreRemitente" >Nombre Remitente</label>
      </div>
      <div class="campo">
          <input type="text" name="nombreDestinatario" id="nombreDestinatario" maxlength="40" required></input>
          <label for="nombreDestinatario" >Nombre Destinatario</label>
      </div>
      <div class="campo">
      <?php if (isset($component)) { $__componentOriginal5c1b9c3c1f185917d0467cbae680691400e1b943 = $component; } ?>
<?php $component = App\View\Components\SelectProductoComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-producto-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectProductoComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c1b9c3c1f185917d0467cbae680691400e1b943)): ?>
<?php $component = $__componentOriginal5c1b9c3c1f185917d0467cbae680691400e1b943; ?>
<?php unset($__componentOriginal5c1b9c3c1f185917d0467cbae680691400e1b943); ?>
<?php endif; ?>
      </div>
      <div class="campo">
          <input type="text" id="volumen" name="volumen" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="10" required>
          <label for="volumen" >Volumen(L)</label>
      </div>
      <div class="campo">
      <input type="text" id="peso" name="peso" onkeydown="filtro(event)" 
                pattern="[0-9]*[.,]?[0-9]+" maxlength="10" required>
          <label for="peso" >Peso(Kg)</label>
</div>
<input type="hidden" name="identificador" id="identificador"></input>
          <button type="submit" name="aceptar">Aceptar</button>
</form>
<form action="<?php echo e(route('paquete.cargarDatos')); ?>" method="GET">
         <?php echo csrf_field(); ?>
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
      </div>
      </div>
    </div>
  </div>
</body>
<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/vistaBackOfficePaquete.blade.php ENDPATH**/ ?>