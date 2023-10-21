<?php
$datos = session('producto', []);
?>

<table class="tabla">
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Stock</th>
        <th>Precio</th>
        <th>Moneda</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr onclick="seleccionarFila(<?php echo e($producto['Id']); ?>, '<?php echo e($producto['Nombre']); ?>',
             <?php echo e($producto['Stock']); ?>, <?php echo e($producto['Precio']); ?>, '<?php echo e($producto['Moneda']); ?>')">
        <td><?php echo e($producto['Id']); ?></td>
        <td><?php echo e($producto['Nombre']); ?></td>
        <td><?php echo e($producto['Stock']); ?></td>
        <td><?php echo e($producto['Precio']); ?></td>
        <td><?php echo e($producto['Moneda']); ?></td>
        <td><?php echo e($producto['created_at']); ?></td>
        <td><?php echo e($producto['updated_at']); ?></td>
        <td><?php echo e($producto['deleted_at']); ?></td>
</tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>
    function seleccionarFila(id, nombre,stock, precio, moneda) {
        document.getElementById('identificador').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('stock').value = stock;
        document.getElementById('precio').value = precio;
        document.getElementById('tipoMoneda').value = moneda;
    }
</script><?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-producto-component.blade.php ENDPATH**/ ?>