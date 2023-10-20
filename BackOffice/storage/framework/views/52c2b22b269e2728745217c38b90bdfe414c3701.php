<?php
$datos = session('usuarios', []);
?>
<?php if(!empty($datos)): ?>
<table class="tabla">
    <tr>
        <th>Id Usuario</th>
        <th>Nombre de Usuario</th>
        <th>Contraseña</th>
        <th>Mail</th>
        <th>Telefono/s</th>
        <th>Tipo de Usuario</th>
        <th>Fecha de creacion</th>
        <th>Ultima actualizacion</th>
        <th>Fecha de borrado</th>
    </tr>
    <?php $__currentLoopData = $datos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr onclick="seleccionarFila('<?php echo e($usuario['Id Usuario']); ?>', '<?php echo e($usuario['Nombre de Usuario']); ?>', '<?php echo e($usuario['contrasenia']); ?>', '<?php echo e($usuario['Mail']); ?>', '<?php echo e($usuario['Tipo de Usuario']); ?>')">
    <td><?php echo e($usuario['Id Usuario']); ?></td>
    <td><?php echo e($usuario['Nombre de Usuario']); ?></td>
    <td><?php echo e($usuario['contrasenia']); ?></td>
    <td><?php echo e($usuario['Mail']); ?></td>
    <td><?php echo e($usuario['Telefono/s']); ?></td>
    <td><?php echo e($usuario['Tipo de Usuario']); ?></td>
    <td><?php echo e($usuario['created_at']); ?></td>
    <td><?php echo e($usuario['updated_at']); ?></td>
    <td><?php echo e($usuario['deleted_at']); ?></td>
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php endif; ?>

<script>
    function seleccionarFila(id,nombre,contrasenia,mail,tipoUsuario) {
        document.getElementById('identificador').value =id ;
    document.getElementById('nombre').value = nombre;
    document.getElementById('contrasenia').value = contrasenia;
    document.getElementById('mail').value = mail;
    obtenerTipoUsuario(tipoUsuario);

    }

    function obtenerTipoUsuario(tipoUsuario){
        document.getElementById("usuarioAdministrador").checked = false;
    document.getElementById("usuarioAlmacenero").checked = false;
    document.getElementById("usuarioChofer").checked = false;
    document.getElementById("usuarioCliente").checked = false;
    tipoUsuario = tipoUsuario.split('/')
    console.log(tipoUsuario)
    tipoUsuario.forEach(function (palabra) {
        palabra = palabra.trim();
        switch (palabra) {
            case "Administrador":
                document.getElementById("usuarioAdministrador").checked = true;
                break;
            case "Almacenero":
                document.getElementById("usuarioAlmacenero").checked = true;
                break;
            case "Chofer":
                document.getElementById("usuarioChofer").checked = true;
                break;
            case "Cliente":
                document.getElementById("usuarioCliente").checked = true;
                break;
        }
    });
    }
    
</script>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/tabla-usuarios-component.blade.php ENDPATH**/ ?>