
<?php
    $formSelector = $formSelector ?? '.toggle-status-form';
    $message = $message ?? "Cambiarás de estado al usuario";
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('<?php echo e($formSelector); ?>').forEach(formElement => {
            formElement.addEventListener('submit', function (e) {
                e.preventDefault();
                const formId = formElement.id;
                const form = formId ? document.getElementById(formId) : formElement;
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "<?php echo e($message); ?>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, cambiar estado!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

<?php /**PATH C:\laragon\www\synapse\resources\views/components/scripts/toggle-status.blade.php ENDPATH**/ ?>