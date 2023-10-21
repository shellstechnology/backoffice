<?php
$datos = session('idAlmacenes', []);
?>

<?php if(!empty($datos)): ?>
    <select id="idAlmacen" name="idAlmacen">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Almacen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($Almacen); ?>"><?php echo e($Almacen); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="almacenes">Almacenes</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-almacenes-component.blade.php ENDPATH**/ ?>