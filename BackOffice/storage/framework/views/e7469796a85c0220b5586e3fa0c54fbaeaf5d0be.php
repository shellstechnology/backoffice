<?php
$datos = session('listaChoferes', []);
?>

<?php if(!empty($datos)): ?>
    <select id="chofer"  name="chofer">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $camion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($camion); ?>"><?php echo e($camion); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="choferesCamion">Chofer del Camion</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-choferes-component.blade.php ENDPATH**/ ?>