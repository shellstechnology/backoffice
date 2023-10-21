<?php
$datos = session('almacenes', []);
?>

<table class="tabla">
    <tr>
        <th>Id Almacen</th>
        <th>Id Lugar</th>
        <th>Direccion Almacen</th>
        <th>Lat Almacen</th>
        <th>Lng Almacen</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $almacen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <tr onclick="seleccionarFila(<?php echo e($almacen['Id Almacen']); ?>, '<?php echo e($almacen['Id Lugar']); ?>')">
            <td><?php echo e($almacen['Id Almacen']); ?></td>
            <td><?php echo e($almacen['Id Lugar']); ?></td>
            <td><?php echo e($almacen['Direccion Almacen']); ?></td>
            <td><?php echo e($almacen['Lat Almacen']); ?></td>
            <td><?php echo e($almacen['Lng Almacen']); ?></td>
            <td><?php echo e($almacen['created_at']); ?></td>
            <td><?php echo e($almacen['updated_at']); ?></td>
            <td><?php echo e($almacen['deleted_at']); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>

    function seleccionarFila(id, lugar) {
        document.getElementById('identificador').value = id;
        document.getElementById('idLugarEntrega').value = lugar
    }
</script>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-almacenes-component.blade.php ENDPATH**/ ?>