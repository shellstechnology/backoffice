<?php
$datos = session('idLugaresEntrega', []);
?>

<?php if(!empty($datos)): ?>
    <select id="idLugarEntrega" name="idLugarEntrega">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lugarEntrega): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($lugarEntrega); ?>"><?php echo e($lugarEntrega); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="lugarEntrega">Lugar de Entrega</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-lugares-entrega-component.blade.php ENDPATH**/ ?>