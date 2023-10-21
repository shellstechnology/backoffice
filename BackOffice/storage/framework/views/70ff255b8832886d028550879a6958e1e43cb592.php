<?php
$datos = session('listaEstado', []);
?>

<?php if(!empty($datos)): ?>
    <select id="estadoCamion" name="estadoCamion">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($estado); ?>"><?php echo e($estado); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="estadoCamion">Estado del Camion</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-estado-camion-component.blade.php ENDPATH**/ ?>