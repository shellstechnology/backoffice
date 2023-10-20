<?php
$datos = session('monedas', []);
?>

<?php if(!empty($datos)): ?>
    <select id="tipoMoneda"  name="tipoMoneda">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monedas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($monedas); ?>"><?php echo e($monedas); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="tipoMoneda">Moneda</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-moneda-component.blade.php ENDPATH**/ ?>