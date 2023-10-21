<?php
$datos = session('lotes', []);
?>

<table class="tabla">
    <tr>
        <th>Id Lote</th>
        <th>Volumen (L)</th>
        <th>Peso (Kg)</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr onclick="seleccionarFila(<?php echo e($lote['Id Lote']); ?>, '<?php echo e($lote['Volumen(L)']); ?>',
                     <?php echo e($lote['Peso(Kg)']); ?>, '<?php echo e($lote['created_at']); ?>',
                     '<?php echo e($lote['updated_at']); ?>', '<?php echo e($lote['deleted_at']); ?>')">
            <td><?php echo e($lote['Id Lote']); ?></td>
            <td><?php echo e($lote['Volumen(L)']); ?></td>
            <td><?php echo e($lote['Peso(Kg)']); ?></td>
            <td><?php echo e($lote['created_at']); ?></td>
            <td><?php echo e($lote['updated_at']); ?></td>
            <td><?php echo e($lote['deleted_at']); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>
    function seleccionarFila(id) {
        document.getElementById('identificador').value = id;
    }
</script>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-lote-component.blade.php ENDPATH**/ ?>