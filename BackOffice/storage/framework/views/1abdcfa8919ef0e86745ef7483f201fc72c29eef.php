<?php
$datos = session('descripcionCaracteristica', []);
?>

<?php if(!empty($datos)): ?>
    <select id="caracteristica" name="caracteristica">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caracteristica): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($caracteristica); ?>"><?php echo e($caracteristica); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="caracteristica">Caracteristica</label>
<?php endif; ?><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-caracteristica-paquete-component.blade.php ENDPATH**/ ?>