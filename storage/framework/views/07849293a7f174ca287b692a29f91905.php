
<?php
    $passwordId = $passwordId ?? 'password';
    $confirmPasswordId = $confirmPasswordId ?? 'password_confirmation';
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('<?php echo e($passwordId); ?>');
        const confirmPasswordInput = document.getElementById('<?php echo e($confirmPasswordId); ?>');

        if (!passwordInput || !confirmPasswordInput) return;

        const lengthCheck = document.getElementById('length-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const numberCheck = document.getElementById('number-check');
        const passwordMatchFeedback = document.getElementById('password-match-feedback');

        function updatePasswordStrength() {
            const p = passwordInput.value;

            if (lengthCheck) {
                if (p.length >= 8) {
                    lengthCheck.innerHTML = '<i class="fas fa-check-circle text-success"></i> Mínimo 8 caracteres';
                } else {
                    lengthCheck.innerHTML = '<i class="fas fa-times-circle text-danger"></i> Mínimo 8 caracteres';
                }
            }

            if (uppercaseCheck) {
                if (/[A-Z]/.test(p)) {
                    uppercaseCheck.innerHTML = '<i class="fas fa-check-circle text-success"></i> Al menos una mayúscula';
                } else {
                    uppercaseCheck.innerHTML = '<i class="fas fa-times-circle text-danger"></i> Al menos una mayúscula';
                }
            }

            if (lowercaseCheck) {
                if (/[a-z]/.test(p)) {
                    lowercaseCheck.innerHTML = '<i class="fas fa-check-circle text-success"></i> Al menos una minúscula';
                } else {
                    lowercaseCheck.innerHTML = '<i class="fas fa-times-circle text-danger"></i> Al menos una minúscula';
                }
            }

            if (numberCheck) {
                if (/[0-9]/.test(p)) {
                    numberCheck.innerHTML = '<i class="fas fa-check-circle text-success"></i> Al menos un número';
                } else {
                    numberCheck.innerHTML = '<i class="fas fa-times-circle text-danger"></i> Al menos un número';
                }
            }
        }

        function validatePasswordMatch() {
            if (passwordInput.value === confirmPasswordInput.value) {
                confirmPasswordInput.classList.remove('is-invalid');
                if (passwordMatchFeedback) passwordMatchFeedback.style.display = 'none';
            } else {
                confirmPasswordInput.classList.add('is-invalid');
                if (passwordMatchFeedback) passwordMatchFeedback.style.display = 'block';
            }
        }

        passwordInput.addEventListener('keyup', updatePasswordStrength);
        passwordInput.addEventListener('change', updatePasswordStrength);
        confirmPasswordInput.addEventListener('keyup', validatePasswordMatch);
        confirmPasswordInput.addEventListener('change', validatePasswordMatch);
        
        updatePasswordStrength();
        validatePasswordMatch();
    });
</script>

<?php /**PATH C:\laragon\www\synapse\resources\views/components/scripts/password-validation.blade.php ENDPATH**/ ?>