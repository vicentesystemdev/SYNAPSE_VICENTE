<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Roboto", sans-serif;
}

:root {
    --color-primary: #3b5bdb;
    --color-secondary: #2f4ac2;
    --color-background: #eef2ff;
    --color-background-from: #1e2a45;
    --color-text-primary: rgb(255, 255, 255);
    --color-text-secondary: #adb5bd;
    --color-border: #748ffc;
    --color-button-text: #FFFFFF;
    --color-icon-google: #DB4437;
    --color-icon-facebook: #4267B2;
    --color-little: #F7F3FA;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100vh;
    background-color: var(--color-background);
}

/* Estilos para el video de fondo */
#video-background {
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    z-index: -100;
}

.container {
    display: grid;
    grid-template-columns: 3.3fr 3fr 0.8fr;
    align-items: center;
    width: 48.15rem;
    height: 34.5rem;
    border: 3px solid white;
    border-radius: 5px;
}


.forms-container {
    height: 100%;
    background-color: var(--color-background-from);
    overflow: hidden;
}

.forms {
    transition: transform 0.5s ease;
}

.forms.active {
    transform: translateY(-50%);
}

.alert-danger {
    color: #e3342f;
    font-size: 0.8rem;
    margin-top: 0.25rem;
}

form {
    padding: 1.8rem;
    padding-top: 2rem;
}

form h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--color-text-primary);
    margin-bottom: 2rem;
    text-align: center;
}

form p {
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--color-text-secondary);
    margin-top: 2rem; 
    margin-bottom: 1.8rem;
}

form p a {
    color: var(--color-primary);
    font-weight: 700;
    text-decoration: none;
}

.input-container {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.2rem;
    color: var(--color-text-secondary);
}

.input-container input {
    padding: 0.7rem;
    border: 2px solid var(--color-border);
    border-radius: 0.4rem;
    outline: none;
    font-size: 0.9rem;
}

.input-container input:focus {
    border-color: var(--color-primary);
}

.input-container a {
    color: var(--color-primary);
}

.input-container label,
.input-container a {
    font-size: 0.8rem;
    font-weight: 600;
}

.input-container .forget {
    display: flex;
    justify-content: space-between;
}

.remember-me {
    display: flex;
    gap: 0.3rem;
    margin-bottom: 1.7rem;
}

.remember-me label {
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--color-text-secondary);
}

form button {
    width: 100%;
    padding: 0.9rem 0;
    background-color: var(--color-secondary);
    color: var(--color-button-text);
    font-weight: 500;
    border: none;
    border-radius: 0.5rem;
    margin-bottom: 0.3rem;
    cursor: pointer;
}

form .btn-register {
    margin-top: 1.5rem;
}

.line-width-text {
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-text-secondary);
    font-size: 0.8rem;
    margin-top: 1rem;
    margin-bottom: 1.3rem;
}




.other-login img {
    width: 1rem;
}

.banner {
    position: relative;
    overflow: hidden;
    height: 100%;
    background-color: var(--color-primary);
}

.sidebar {
    background-color: var(--color-background-from);
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
    user-select: none;
}



.sidebar.active::after {
    top: 50%;
}

.sidebar .sign {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;  
    justify-content: center; 
    gap: 0.4rem;
    cursor: pointer;
}


.sidebar span {
    color: var(--color-text-secondary);
    font-size: 0.8rem;
}

.sidebar img {
    width: 1.5rem;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-100%); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes bounce-up {
    0% { transform: translateY(0); }
    20% { transform: translateY(-7px); }
    40% { transform: translateY(2px); }
    60% { transform: translateY(0); }
}

@keyframes bounce-down {
    0% { transform: translateY(0); }
    20% { transform: translateY(-7px); }
    40% { transform: translateY(2px); }
    60% { transform: translateY(0); }
}

#sign-In{
    overflow:hidden;
    overflow-y: scroll;
    height: 550px;
}


/* Contenedor con el input + ícono de ojo */
.password-verify {
    position: relative;
}

/* Estilo del input */
.password-verify input {
    width: 100%;
    padding: 0.7rem 2.5rem 0.7rem 0.7rem;
    font-size: 0.9rem;
    border: 2px solid var(--color-border);
    border-radius: 0.4rem;
    outline: none;
}

.password-verify input:focus {
    border-color: var(--color-primary);
}

/* Estilo del ícono de ojo */
.ojo-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    height: 100%;
    display: flex;
    align-items: center;
}

/* Cuando hay error en el campo */
.password-verify input.input-error {
    border: 2px solid #dc3545;
}

/* Mensaje de error */
.error-message {
    color: #dc3545;
    font-size: 0.8rem;
    margin-top: 5px;
    display: none;
}

.alert-danger {
    color: #dc3545;
    font-size: 0.8rem;
    margin-top: 5px;
}

/* Estilos para los requisitos de contraseña */
.invalid-requirement {
    color: #dc3545; /* Rojo */
    list-style: none; /* Quita viñetas */
}

.valid-requirement {
    color: #28a745; /* Verde */
    list-style: none; /* Quita viñetas */
}

form button:hover {
    background-color: rgb(255, 153, 0);
}

.banner {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(160deg, #1a2744 0%, #2d3f6e 50%, #1a2744 100%);
    position: relative;
    overflow: hidden;
}
.banner-math-symbols {
    position: absolute;
    inset: 0;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem;
    opacity: 0.08;
    font-size: 2rem;
    color: #748ffc;
    font-family: 'Georgia', serif;
    user-select: none;
    line-height: 1.4;
    word-break: break-all;
}
.banner-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1.5rem;
    text-align: center;
}
.banner-logo-icon {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, #3b5bdb, #748ffc);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 20px rgba(59,91,219,0.5);
    margin-bottom: 0.25rem;
}
.banner-title {
    color: #ffffff;
    font-size: 1.4rem;
    font-weight: 800;
    letter-spacing: 3px;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}
.banner-subtitle {
    color: rgba(255,255,255,0.75);
    font-size: 0.72rem;
    letter-spacing: 1px;
    font-weight: 500;
}
.banner-divider {
    width: 40px;
    height: 2px;
    background: linear-gradient(90deg, transparent, #748ffc, transparent);
    border-radius: 2px;
}

.input-container .forget {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Nuevos estilos para el campo de correo electrónico */
.email-input-wrapper-style {
    display: flex;
    align-items: center;
    padding: 0.7rem;
    border: 2px solid var(--color-border);
    border-radius: 0.4rem;
    overflow: hidden;
    width: 100%; /* Asegura que ocupe todo el ancho disponible en su contenedor */
}

.email-input-wrapper-style:focus-within {
    border-color: var(--color-primary);
}

.email-input-wrapper-style input {
    flex-grow: 1;
    border: none;
    outline: none;
    font-size: 0.9rem;
    padding: 0;
}

.email-prefix-suffix-style {
    color: var(--color-text-secondary);
    white-space: nowrap;
    padding: 0 0.2rem; /* Pequeño padding para separar del input */
}
    </style>
</head>
<body>
<video autoplay loop muted playsinline id="video-background">
        <source src="/images/Fondo2.mp4" type="video/mp4">
    </video>
    <div class="container" id="container">
        <div class="forms-container">
            <form method="POST" action="<?php echo e(route('register')); ?>" id="sign-In">
                <?php echo csrf_field(); ?>
                
                <h2>Registro de Usuario</h2>
                <p>¿Ya estás registrado? <a href="<?php echo e(route('login')); ?>" id="link-sign-up">Iniciar Sesión</a></p>

                <div class="input-container">
                    <label for="name">Nombre(s) Completo:</label>
                    <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ ]/g, '');" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="alert-danger"><?php echo e($message); ?></div> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="input-container">
                    <label for="app_usu">Apellido Paterno:</label>
                    <input type="text" id="app_usu" name="app_usu" value="<?php echo e(old('app_usu')); ?>" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ ]/g, '');" required>
                    <?php $__errorArgs = ['app_usu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="alert-danger"><?php echo e($message); ?></div> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="input-container">
                    <label for="apm_usu">Apellido Materno:</label>
                    <input type="text" id="apm_usu" name="apm_usu" value="<?php echo e(old('apm_usu')); ?>" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ ]/g, '');" required>
                    <?php $__errorArgs = ['apm_usu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="alert-danger"><?php echo e($message); ?></div> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="input-container">
                    <label for="email">Correo Institucional:</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Ingrese su correo institucional" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="alert-danger"><?php echo e($message); ?></div> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <small id="errorEmail" class="error-message" style="display: none;"></small>
                </div>

                <div class="input-container">
                    <div class="forget">
                        <label for="password">Contraseña</label>
                    </div>
                    <div class="password-verify">
                        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        <span id="ojoPassword" class="ojo-password">
                            <i id="iconoPassword" class="fa fa-eye"></i>
                        </span>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="alert-danger"><?php echo e($message); ?></div> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div id="passwordRequirements" style="font-size: 0.8rem; margin-top: 5px;">
                        <ul>
                            <li id="passLength" class="invalid-requirement">Mínimo 8 caracteres</li>
                            <li id="passUppercase" class="invalid-requirement">Al menos una mayúscula</li>
                            <li id="passLowercase" class="invalid-requirement">Al menos una minúscula</li>
                            <li id="passNumber" class="invalid-requirement">Al menos un número</li>
                        </ul>
                    </div>
                </div>

                <div class="input-container">
                    <div class="forget">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                    </div>
                    <div class="password-verify">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirma tu contraseña" required>
                        <span id="ojoPasswordConfirm" class="ojo-password">
                            <i id="iconoPasswordConfirm" class="fa fa-eye"></i>
                        </span>
                    </div>
                    <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <div class="alert-danger"><?php echo e($message); ?></div> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <small id="errorPasswordConfirm" class="error-message" style="display: none;">Las contraseñas no coinciden.</small>
                </div>
                <input type="hidden" name="COD_ROL" value="3">

                <button type="submit" class="btn-register">REGISTRARSE</button>
            </form>
        </div>

        <div class="banner">
            <!-- Fondo con símbolos matemáticos -->
            <div class="banner-math-symbols" aria-hidden="true">
                Σ ∫ √ π Δ α β θ λ μ ∞ ≤ ≥ ≠ ± × ÷ ∈ ⊂ ∩ ∪ ∀ ∃ ax²+bx+c f'(x) lim ∇ ⊥ ≡ Σ ∫ √ π Δ α β
            </div>
            <!-- Contenido del banner -->
            <div class="banner-content">
                <div class="banner-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19V5l8 7 8-7v14"/>
                        <path d="M12 12v7"/>
                    </svg>
                </div>
                <div class="banner-divider"></div>
                <span class="banner-title">INTELECTA</span>
                <span class="banner-subtitle">Evaluación Lógico-Matemática</span>
            </div>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sign" id="btn-Sign-In">
                <!-- Ícono SVG matemático inline - sin dependencias externas -->
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#748ffc" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="filter: drop-shadow(0 0 6px rgba(116,143,252,0.6));">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
                <span style="font-weight:800; font-size:1rem; letter-spacing:2px; color:#ffffff;">INTELECTA</span>
                <span style="font-size:0.65rem; opacity:0.75; color:#a5b4fc; text-align:center; line-height:1.3;">Evaluación<br>Lógico-Matemática</span>
            </div>
        </div>
    </div>

    <script>
        // Funcionalidad para mostrar/ocultar contraseña
        document.getElementById('ojoPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const iconoPassword = document.getElementById('iconoPassword');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                iconoPassword.classList.remove('fa-eye');
                iconoPassword.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                iconoPassword.classList.remove('fa-eye-slash');
                iconoPassword.classList.add('fa-eye');
            }
        });

        // Funcionalidad para mostrar/ocultar confirmación de contraseña
        document.getElementById('ojoPasswordConfirm').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const iconoPassword = document.getElementById('iconoPasswordConfirm');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                iconoPassword.classList.remove('fa-eye');
                iconoPassword.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                iconoPassword.classList.remove('fa-eye-slash');
                iconoPassword.classList.add('fa-eye');
            }
        });

        const emailInput = document.getElementById('email');
        const errorEmailMessage = document.getElementById('errorEmail');

        function validateEmail() {
            const emailValue = emailInput.value;
            let errorMessage = '';

            if (!emailValue.startsWith('lpze.')) {
                errorMessage = 'El correo electrónico debe comenzar con "lpze."';
            } else if (!emailValue.endsWith('@unifranz.edu.bo')) {
                errorMessage = 'El correo electrónico debe terminar con "@unifranz.edu.bo"';
            }

            if (errorMessage) {
                errorEmailMessage.textContent = errorMessage;
                errorEmailMessage.style.display = 'block';
                emailInput.classList.add('input-error');
            } else {
                errorEmailMessage.style.display = 'none';
                emailInput.classList.remove('input-error');
            }
            return !errorMessage;
        }

        emailInput.addEventListener('input', validateEmail);
        emailInput.addEventListener('blur', validateEmail);

        const passwordInput = document.getElementById('password');
        const passLength = document.getElementById('passLength');
        const passUppercase = document.getElementById('passUppercase');
        const passLowercase = document.getElementById('passLowercase');
        const passNumber = document.getElementById('passNumber');

        function validatePassword() {
            const passwordValue = passwordInput.value;
            let isValid = true;

            // Validar longitud
            if (passwordValue.length >= 8) {
                passLength.classList.remove('invalid-requirement');
                passLength.classList.add('valid-requirement');
            } else {
                passLength.classList.remove('valid-requirement');
                passLength.classList.add('invalid-requirement');
                isValid = false;
            }

            // Validar mayúscula
            if (/[A-Z]/.test(passwordValue)) {
                passUppercase.classList.remove('invalid-requirement');
                passUppercase.classList.add('valid-requirement');
            } else {
                passUppercase.classList.remove('valid-requirement');
                passUppercase.classList.add('invalid-requirement');
                isValid = false;
            }

            // Validar minúscula
            if (/[a-z]/.test(passwordValue)) {
                passLowercase.classList.remove('invalid-requirement');
                passLowercase.classList.add('valid-requirement');
            } else {
                passLowercase.classList.remove('valid-requirement');
                passLowercase.classList.add('invalid-requirement');
                isValid = false;
            }

            // Validar número
            if (/[0-9]/.test(passwordValue)) {
                passNumber.classList.remove('invalid-requirement');
                passNumber.classList.add('valid-requirement');
            } else {
                passNumber.classList.remove('invalid-requirement');
                passNumber.classList.add('invalid-requirement');
                isValid = false;
            }

            // Si no es válido, añadir la clase de error al input, sino removerla
            if (!isValid) {
                passwordInput.classList.add('input-error');
            } else {
                passwordInput.classList.remove('input-error');
            }

            return isValid;
        }

        passwordInput.addEventListener('input', function() {
            validatePassword();
            validatePasswordMatch();
        });
        passwordInput.addEventListener('blur', validatePassword);

        document.getElementById('password_confirmation').addEventListener('input', function() {
            validatePasswordMatch();
        });

        function validatePasswordMatch() {
            // Primero valida la contraseña principal
            const isPasswordValid = validatePassword();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const errorMessage = document.getElementById('errorPasswordConfirm');
            const confirmInput = document.getElementById('password_confirmation');
            
            if (!isPasswordValid) { // Si la primera contraseña no es válida, la confirmación tampoco puede serlo
                errorMessage.style.display = 'none';
                confirmInput.classList.remove('input-error');
                return false;
            }

            if (confirmPassword.length > 0 && password !== confirmPassword) {
                errorMessage.textContent = 'Las contraseñas no coinciden.';
                errorMessage.style.display = 'block';
                confirmInput.classList.add('input-error');
                return false;
            } else {
                errorMessage.style.display = 'none';
                confirmInput.classList.remove('input-error');
                return true;
            }
        }

        document.querySelector('form').addEventListener('submit', function(event) {
            if (!validateEmail() || !validatePassword() || !validatePasswordMatch()) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html><?php /**PATH C:\laragon\www\synapse\resources\views/auth/register.blade.php ENDPATH**/ ?>