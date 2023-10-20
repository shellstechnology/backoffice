<?php
$datos = session('telefonosUsuario', []);
?>

<table class="tabla">
    <tr>
        <th>Id del Usuario</th>
        <th>Nombre de Usuario</th>
        <th>Telefono</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr onclick="seleccionarFila(<?php echo e($usuario['Id del Usuario']); ?>,'<?php echo e($usuario['Telefono']); ?>')">
            <td><?php echo e($usuario['Id del Usuario']); ?></td>
            <td><?php echo e($usuario['Nombre de Usuario']); ?></td>
            <td><?php echo e($usuario['Telefono']); ?></td>
            <td><?php echo e($usuario['created_at']); ?></td>
            <td><?php echo e($usuario['updated_at']); ?></td>
            <td><?php echo e($usuario['deleted_at']); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>
    function seleccionarFila(id, telefono) {
    document.getElementById('identificadorId').value = id;
    document.getElementById('identificadorTelefono').value = telefono
    document.getElementById('datoUsuario').value = id;
    document.getElementById('telefono').value = telefono;
    }
</script><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-telefono-usuario-component.blade.php ENDPATH**/ ?>