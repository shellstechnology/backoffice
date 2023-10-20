<?php
$datos = session('matriculaCamiones', []);
?>

<?php if(!empty($datos)): ?>
    <select id="idCamion" name="idCamion">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Matricula): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($Matricula); ?>"><?php echo e($Matricula); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="idCamion">Matricula</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-camiones-component.blade.php ENDPATH**/ ?>