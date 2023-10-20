<?php
$datos = session('camionLlevaLote', []);
?>

<table class="tabla">
    <tr>
        <th>Id Lote</th>
        <th>Matricula Camion</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $camionLlevaLote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr onclick="seleccionarFila(<?php echo e($camionLlevaLote['Id Lote']); ?>, '<?php echo e($camionLlevaLote['Matricula Camion']); ?>')">
            <td><?php echo e($camionLlevaLote['Id Lote']); ?></td>
            <td><?php echo e($camionLlevaLote['Matricula Camion']); ?></td>
            <td><?php echo e($camionLlevaLote['created_at']); ?></td>
            <td><?php echo e($camionLlevaLote['updated_at']); ?></td>
            <td><?php echo e($camionLlevaLote['deleted_at']); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>
    function seleccionarFila(lote, camion) {
        document.getElementById('identificador').value = lote;
        document.getElementById('idLote').value = lote;
        document.getElementById('idCamion').value = camion;
    }
</script>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-camion-lleva-lote-component.blade.php ENDPATH**/ ?>