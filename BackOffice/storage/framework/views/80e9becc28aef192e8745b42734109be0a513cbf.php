<?php
$datos = session('paqueteContieneLote', []);
?>

<table class="tabla">
    <tr>
        <th>Id Paquete</th>
        <th>Lote</th>
        <th>Volumen(L)</th>
        <th>Peso(Kg)</th>
        <th>Almacen</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paqueteLote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr onclick="seleccionarFila('<?php echo e($paqueteLote['Id Paquete']); ?>', '<?php echo e($paqueteLote['Lote']); ?>', '<?php echo e($paqueteLote['Almacen']); ?>')">
    <td><?php echo e($paqueteLote['Id Paquete']); ?></td>
    <td><?php echo e($paqueteLote['Lote']); ?></td>
    <td><?php echo e($paqueteLote['Volumen(L)']); ?></td>
    <td><?php echo e($paqueteLote['Peso(Kg)']); ?></td>
    <td><?php echo e($paqueteLote['Almacen']); ?></td>
    <td><?php echo e($paqueteLote['created_at']); ?></td>
    <td><?php echo e($paqueteLote['updated_at']); ?></td>
    <td><?php echo e($paqueteLote['deleted_at']); ?></td>
</tr>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>
    function seleccionarFila(id, lote, almacen) {
        document.getElementById('identificador').value = id;
    document.getElementById('idPaquete').value = id;
    document.getElementById('idLote').value = lote;
    document.getElementById('idAlmacen').value = almacen;
    }
</script><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-paquete-contiene-lote-component.blade.php ENDPATH**/ ?>