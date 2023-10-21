<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice:Producto</title>
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
     <a href="<?php echo e(route('backoffice.producto')); ?>" class="itemSeleccionado">Productos</a>
     <a href="<?php echo e(route('backoffice.lote')); ?>" class="item">Lotes</a>
   </div>
  <div class="container">
    <div class="cuerpo">
     <div id="contenedorTabla">
     <?php if (isset($component)) { $__componentOriginalac831d1eae03c1ad18e63ebd44b51ece28a24714 = $component; } ?>
<?php $component = App\View\Components\TablaProductoComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tabla-producto-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\TablaProductoComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalac831d1eae03c1ad18e63ebd44b51ece28a24714)): ?>
<?php $component = $__componentOriginalac831d1eae03c1ad18e63ebd44b51ece28a24714; ?>
<?php unset($__componentOriginalac831d1eae03c1ad18e63ebd44b51ece28a24714); ?>
<?php endif; ?>
     </div>
    </div>
    <div> 
      <div class="cajaDatos"> 
         <form action="<?php echo e(route('producto.realizarAccion')); ?>" method="POST">
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
            <input type="text" id="nombre" name="nombre" maxlength="50" required></input>
            <label for="nombreProducto" >Nombre</label>
          </div>
          <div class="campo">
            <input type="number" id="precio" name="precio" min="1" max="99999999" onkeydown="filtro(event)" 
              oninput="limitarInput(this, 7)" onpaste="return false" required></input>
            <label for="precioProducto" >Precio </label>
          </div>
          <div class="campo">
          <?php if (isset($component)) { $__componentOriginal5ab4a7ffec67bd048f0a1208dcd4bb8965eea624 = $component; } ?>
<?php $component = App\View\Components\SelectMonedaComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select-moneda-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\SelectMonedaComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5ab4a7ffec67bd048f0a1208dcd4bb8965eea624)): ?>
<?php $component = $__componentOriginal5ab4a7ffec67bd048f0a1208dcd4bb8965eea624; ?>
<?php unset($__componentOriginal5ab4a7ffec67bd048f0a1208dcd4bb8965eea624); ?>
<?php endif; ?>
          </div>
          <div class="campo">
            <input type="number" id="stock" name="stock" min="0" max="999999" onkeydown="filtro(event)" 
            onpaste="return false"; required></input>
            <label for="stockProducto" >Stock</label>
            <input type="hidden" name="producto"> </input>
            <input type="hidden" name="identificador" id="identificador"> </input>
          </div>
          <div class="campo">
          <button type="submit">Aceptar</button>
          </div>
        </form>
       </div>
       <form action="<?php echo e(route('producto.cargarDatos')); ?>" method="GET">
         <?php echo csrf_field(); ?>
         <button type="submit" name="cargar" id="cargar">Cargar Datos</button>
       </form>
       </div>
     </div>
    </div>
  </body>
  <?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/vistaBackOfficeProducto.blade.php ENDPATH**/ ?>