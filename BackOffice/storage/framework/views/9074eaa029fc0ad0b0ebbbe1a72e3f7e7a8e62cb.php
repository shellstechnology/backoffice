<?php
$datos = session('lugaresEntrega', []);
?>

<table class="tabla">
    <tr>
        <th>Id Lugar</th>
        <th>Direccion Lugar</th>
        <th>Lat Lugar</th>
        <th>Lng Lugar</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lugarEntrega): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr onclick="seleccionarFila(<?php echo e($lugarEntrega['Id Lugar']); ?>, '<?php echo e($lugarEntrega['Direccion Lugar']); ?>',
                 <?php echo e($lugarEntrega['Lat Lugar']); ?>, <?php echo e($lugarEntrega['Lng Lugar']); ?>)">
            <td><?php echo e($lugarEntrega['Id Lugar']); ?></td>
            <td><?php echo e($lugarEntrega['Direccion Lugar']); ?></td>
            <td><?php echo e($lugarEntrega['Lat Lugar']); ?></td>
            <td><?php echo e($lugarEntrega['Lng Lugar']); ?></td>
            <td><?php echo e($lugarEntrega['created_at']); ?></td>
            <td><?php echo e($lugarEntrega['updated_at']); ?></td>
            <td><?php echo e($lugarEntrega['deleted_at']); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>
    function seleccionarFila(id, direccion, latitud, longitud) {
        document.getElementById('identificador').value = id;
        document.getElementById('direccion').value = direccion;
        document.getElementById('latitud').value = latitud;
        document.getElementById('longitud').value = longitud;
    }
</script><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-lugar-entrega-component.blade.php ENDPATH**/ ?>