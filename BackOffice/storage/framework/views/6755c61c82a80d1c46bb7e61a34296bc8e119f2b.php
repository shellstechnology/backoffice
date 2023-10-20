<?php
$datos = session('paquete', []);
?>

<table class="tabla">
    <tr>
        <th>Id Paquete</th>
        <th>Nombre del Paquete</th>
        <th>Fecha de Entrega</th>
        <th>Id Lugar Entrega</th>
        <th>Direccion</th>
        <th>Estado</th>
        <th>Caracteristicas</th>
        <th>Nombre del Remitente</th>
        <th>Nombre del Destinatario</th>
        <th>Id del Producto</th>
        <th>Producto</th>
        <th>Volumen(L)</th>
        <th>Peso(Kg)</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paquete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr onclick="seleccionarFila('<?php echo e($paquete['Id Paquete']); ?>','<?php echo e($paquete['Nombre del Paquete']); ?>',
    '<?php echo e($paquete['Fecha de Entrega']); ?>','<?php echo e($paquete['Id Lugar Entrega']); ?>','<?php echo e($paquete['Estado']); ?>',
    '<?php echo e($paquete['Caracteristicas']); ?>','<?php echo e($paquete['Nombre del Remitente']); ?>','<?php echo e($paquete['Nombre del Destinatario']); ?>',
    '<?php echo e($paquete['Id del Producto']); ?>','<?php echo e($paquete['Volumen(L)']); ?>','<?php echo e($paquete['Peso(Kg)']); ?>'
)">
            <td><?php echo e($paquete['Id Paquete']); ?></td>
            <td><?php echo e($paquete['Nombre del Paquete']); ?></td>
            <td><?php echo e($paquete['Fecha de Entrega']); ?></td>
            <td><?php echo e($paquete['Id Lugar Entrega']); ?></td>
            <td><?php echo e($paquete['Direccion']); ?></td>
            <td><?php echo e($paquete['Estado']); ?></td>
            <td><?php echo e($paquete['Caracteristicas']); ?></td>
            <td><?php echo e($paquete['Nombre del Remitente']); ?></td>
            <td><?php echo e($paquete['Nombre del Destinatario']); ?></td>
            <td><?php echo e($paquete['Id del Producto']); ?></td>
            <td><?php echo e($paquete['Producto']); ?></td>
            <td><?php echo e($paquete['Volumen(L)']); ?></td>
            <td><?php echo e($paquete['Peso(Kg)']); ?></td>
            <td><?php echo e($paquete['created_at']); ?></td>
            <td><?php echo e($paquete['updated_at']); ?></td>
            <td><?php echo e($paquete['deleted_at']); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>
    function seleccionarFila(id, nombre,fecha,lugarEntrega,estado,caracteristica,nombreRemitente,
                                nombreDestinatario,producto,volumen,peso) {
    document.getElementById('identificador').value = id;
    document.getElementById('nombrePaquete').value = nombre;
    var arrayFecha = fecha.split('-');
    document.getElementById('anio').value = parseInt(arrayFecha[0], 10);
    document.getElementById('mes').value = parseInt(arrayFecha[1], 10);
    document.getElementById('dia').value = parseInt(arrayFecha[2], 10);
    document.getElementById('idLugarEntrega').value = lugarEntrega;
    document.getElementById('estadoPaquete').value = estado;
    document.getElementById('caracteristica').value = caracteristica;
    document.getElementById('nombreRemitente').value = nombreRemitente;
    document.getElementById('nombreDestinatario').value = nombreDestinatario;
    document.getElementById('idProducto').value = producto;
    document.getElementById('volumen').value = volumen;
    document.getElementById('peso').value = peso;
    }
</script><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-paquete-component.blade.php ENDPATH**/ ?>