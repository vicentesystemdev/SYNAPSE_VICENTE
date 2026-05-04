<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTELECTA — Iniciar Sesión</title>
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
    background-position: center;
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
    color: var(--color-text-primary);
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
    color: var(--color-text-primary);
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
.letra{
    color: var(--color-text-primary);
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

.remember-me input[type="checkbox"] {
    width: auto;
    margin: 0;
}

.remember-me label {
    cursor: pointer;
}

form button:hover {
    background-color:rgb(255, 153, 0);
}

.banner {
    display: flex;
    align-items: center;
    justify-content: center;
}

.banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
    </style>
    
</head>
<body>
    <video autoplay loop muted playsinline id="video-background">
        <source src="/images/Fondo2.mp4" type="video/mp4">
    </video>
    <div class="container" id="container">
        <div class="forms-container">
            <form method="POST" action="{{ route('login') }}" id="sign-In">
        @csrf

                <h2>Iniciar Sesión</h2>

                <div class="input-container">
                    <label for="email" class= "letra">Correo Institucional:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Ingrese su correo institucional" required autofocus>
                    @error('email')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-container">
                    <div class="forget">
                        <label for="password" class= "letra">Contraseña:</label>
                        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    </div>

                    <div class="password-verify">
                        <input id="password" name="password" type="password" placeholder="Ingresa tu contraseña" required>
                        <span id="ojoPassword" class="ojo-password">
                            <i id="iconoPassword" class="fa fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    <small id="errorPassword" class="error-message" style="display: none;">La contraseña debe tener mínimo 8 caracteres.</small>
        </div>

                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me" class="letra">Recordarme</label>
                </div>

                <button type="submit">ACCEDER</button>

                <div class="line-width-text" >
                    <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
                </div>
            </form>
        </div>

        <div class="banner">
         <img src="/images/bbn2.png" alt="logo_login"/>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sign" id="btn-Sign-In">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Telecom_ParisTech.svg/1200px-Telecom_ParisTech.svg.png" alt="INTELECTA" style="width:2.5rem;filter:brightness(10)"/>
                <span style="font-weight:800; font-size:1rem; letter-spacing:2px;">INTELECTA</span>
                <span style="font-size:0.7rem; opacity:0.8;">Evaluación Lógico-Matemática</span>
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

        // Validación de contraseña
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const errorMessage = document.getElementById('errorPassword');
            
            if (password.length > 0 && password.length < 8) {
                errorMessage.style.display = 'block';
                this.classList.add('input-error');
            } else {
                errorMessage.style.display = 'none';
                this.classList.remove('input-error');
            }
        });
    </script>
</body>
</html>
