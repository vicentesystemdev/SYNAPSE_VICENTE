
<?php
    $emailPrefix = $emailPrefix ?? 'both';
    $emailId = $emailId ?? 'email';
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.getElementById('<?php echo e($emailId); ?>');
        if (!emailInput) return;

        const emailPrefixFeedback = document.getElementById('<?php echo e($emailId); ?>-prefix-feedback');
        const emailSuffixFeedback = document.getElementById('<?php echo e($emailId); ?>-suffix-feedback');

        function validateEmail() {
            const email = emailInput.value;
            let startsWithValid = false;
            
            <?php if($emailPrefix === 'lpze'): ?>
                startsWithValid = email.startsWith('lpze.');
            <?php elseif($emailPrefix === 'doc'): ?>
                startsWithValid = email.startsWith('doc.');
            <?php else: ?>
                startsWithValid = email.startsWith('lpze.') || email.startsWith('doc.');
            <?php endif; ?>

            const endsWithUnifranz = email.endsWith('@unifranz.edu.bo');

            if (email.length > 0 && !startsWithValid) {
                emailInput.classList.add('is-invalid');
                if (emailPrefixFeedback) emailPrefixFeedback.style.display = 'block';
            } else {
                if (emailPrefixFeedback) emailPrefixFeedback.style.display = 'none';
            }

            if (email.length > 0 && !endsWithUnifranz) {
                emailInput.classList.add('is-invalid');
                if (emailSuffixFeedback) emailSuffixFeedback.style.display = 'block';
            } else {
                if (emailSuffixFeedback) emailSuffixFeedback.style.display = 'none';
            }

            if (startsWithValid && endsWithUnifranz) {
                emailInput.classList.remove('is-invalid');
            } else if (email.length === 0) {
                emailInput.classList.remove('is-invalid');
                if (emailPrefixFeedback) emailPrefixFeedback.style.display = 'none';
                if (emailSuffixFeedback) emailSuffixFeedback.style.display = 'none';
            }
        }

        emailInput.addEventListener('keyup', validateEmail);
        emailInput.addEventListener('change', validateEmail);
        validateEmail();
    });
</script>

<?php /**PATH C:\laragon\www\synapse\resources\views/components/scripts/email-validation.blade.php ENDPATH**/ ?>