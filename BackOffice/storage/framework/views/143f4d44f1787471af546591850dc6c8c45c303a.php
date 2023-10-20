<?php
$datos = session('camiones', []);
?>
<?php if(!empty($datos)): ?>
<table class="tabla">
    <tr>
        <th>Matricula</th>
        <th>Marca y Modelo</th>
        <th>Estado</th>
        <th>Chofer</th>
        <th>Volumen Maximo</th>
        <th>Peso Maximo</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $camiones): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr onclick="seleccionarFila('<?php echo e($camiones['Matricula']); ?>', '<?php echo e($camiones['Marca y Modelo']); ?>',
                 '<?php echo e($camiones['Estado']); ?>', '<?php echo e($camiones['Chofer']); ?>',<?php echo e($camiones['Volumen Maximo']); ?>,
                 <?php echo e($camiones['Peso Maximo']); ?>)">
        <td><?php echo e($camiones['Matricula']); ?></td>
        <td><?php echo e($camiones['Marca y Modelo']); ?></td>
        <td><?php echo e($camiones['Estado']); ?></td>
        <td><?php echo e($camiones['Chofer']); ?></td>
        <td><?php echo e($camiones['Volumen Maximo']); ?></td>
        <td><?php echo e($camiones['Peso Maximo']); ?></td>
        <td><?php echo e($camiones['created_at']); ?></td>
        <td><?php echo e($camiones['updated_at']); ?></td>
        <td><?php echo e($camiones['deleted_at']); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php endif; ?>

<script>
    function seleccionarFila(matricula, marcaModelo, estado,choferes, volumen,peso) {
        document.getElementById('identificador').value = matricula;
        document.getElementById('matricula').value = matricula;
        document.getElementById('marcaModeloCamion').value = marcaModelo;
        document.getElementById('estadoCamion').value =  estado;
        document.getElementById('chofer').value =  choferes;
        document.getElementById('volumen').value = volumen;
        document.getElementById('peso').value = peso;
    }
</script>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-camiones-component.blade.php ENDPATH**/ ?>