{{-- Componente reutilizable para confirmación de cambio de estado
     Parámetros:
     - formSelector: Selector CSS del formulario (default: '.toggle-status-form')
     - message: Mensaje personalizado (opcional)
--}}
@php
    $formSelector = $formSelector ?? '.toggle-status-form';
    $message = $message ?? "Cambiarás de estado al usuario";
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('{{ $formSelector }}').forEach(formElement => {
            formElement.addEventListener('submit', function (e) {
                e.preventDefault();
                const formId = formElement.id;
                const form = formId ? document.getElementById(formId) : formElement;
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "{{ $message }}",
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

