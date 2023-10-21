<?php
$datos = session('idProductos', []);
?>

<?php if(!empty($datos)): ?>
    <select id="idProducto" name="idProducto">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($producto); ?>"><?php echo e($producto); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="producto">Id del Producto</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-producto-component.blade.php ENDPATH**/ ?>