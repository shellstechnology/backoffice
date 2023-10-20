<?php
$datos = session('listaMarcaModelo', []);
?>

<?php if(!empty($datos)): ?>
    <select id="marcaModeloCamion" name="marcaModeloCamion">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marcaModelo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($marcaModelo); ?>"><?php echo e($marcaModelo); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="marcaModeloCamion">Marca/Modelo</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-marca-modelo-component.blade.php ENDPATH**/ ?>