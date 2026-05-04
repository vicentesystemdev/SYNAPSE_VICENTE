{{-- Componente reutilizable para validación de email
     Parámetros:
     - emailPrefix: 'lpze', 'doc', o 'both' (default: 'both')
     - emailId: ID del input de email (default: 'email')
--}}
@php
    $emailPrefix = $emailPrefix ?? 'both';
    $emailId = $emailId ?? 'email';
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.getElementById('{{ $emailId }}');
        if (!emailInput) return;

        const emailPrefixFeedback = document.getElementById('{{ $emailId }}-prefix-feedback');
        const emailSuffixFeedback = document.getElementById('{{ $emailId }}-suffix-feedback');

        function validateEmail() {
            const email = emailInput.value;
            let startsWithValid = false;
            
            @if($emailPrefix === 'lpze')
                startsWithValid = email.startsWith('lpze.');
            @elseif($emailPrefix === 'doc')
                startsWithValid = email.startsWith('doc.');
            @else
                startsWithValid = email.startsWith('lpze.') || email.startsWith('doc.');
            @endif

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

