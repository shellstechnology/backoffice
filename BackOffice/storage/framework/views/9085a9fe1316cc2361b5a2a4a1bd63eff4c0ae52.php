<?php
$datos = session('idPaquetes', []);
?>

<?php if(!empty($datos)): ?>
    <select id="idPaquete" name="idPaquete">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paquete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($paquete); ?>"><?php echo e($paquete); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="paquete">Paquete</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-paquete-component.blade.php ENDPATH**/ ?>