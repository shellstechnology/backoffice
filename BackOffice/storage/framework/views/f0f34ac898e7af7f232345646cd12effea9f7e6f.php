<?php
$datos = session('idLotes', []);
?>

<?php if(!empty($datos)): ?>
    <select id="idLote" name="idLote">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($lote); ?>"><?php echo e($lote); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="lote">Lote</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-lote-component.blade.php ENDPATH**/ ?>