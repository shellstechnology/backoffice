<div>
<?php
    use Illuminate\Support\Facades\Session;
    $mensaje = session('respuesta', '');
?>
<?php if(!empty($mensaje)): ?>
    <script>
        window.addEventListener('load', () => {
            alert("<?php echo e($mensaje); ?>");
        });
    </script>
    <?php
        Session::put('respuesta', ''); // Esto está bien para limpiar la sesión después de mostrar el mensaje
    ?>
<?php endif; ?>
<?php /**PATH C:\Users\Mati\PROYECTO\Backoffice\backoffice\BackOffice\resources\views/components/mensaje-respuesta-component.blade.php ENDPATH**/ ?>