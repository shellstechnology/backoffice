<?php
$datos = session('idUsuarios', []);
?>

<?php if(!empty($datos)): ?>
    <select id="datoUsuario" name="datoUsuario">
        <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($usuario); ?>"><?php echo e($usuario); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <label for="datoUsuario">Id del Usuario</label>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/select-usuario-component.blade.php ENDPATH**/ ?>