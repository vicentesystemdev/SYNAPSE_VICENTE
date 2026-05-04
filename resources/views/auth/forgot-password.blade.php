<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
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
    --color-primary:rgb(255, 119, 0);
    --color-secondary: rgb(246, 121, 19);
    --color-background: #e9dfd2;
    --color-background-from:rgb(22, 22, 22);
    --color-text-primary:rgb(255, 255, 255);
    --color-text-secondary:rgb(255, 255, 255);
    --color-border: #CDCDCD;
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
}

.banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
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
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="sign-In">
                @csrf
                
                <h2>Recuperar Contraseña</h2>

                @if (session('status'))
                    <div class="mb-4 text-sm text-white" style="color: white !important;">
                        {{ session('status') }}
                    </div>
                @endif

                @error('email')
                    <div class="mb-4 text-sm text-danger" style="color: red !important;">
                        {{ $message }}
                    </div>
                @enderror

                <div class="input-container">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Ingrese su correo electrónico" required autofocus>
                    @error('email')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-register">ENVIAR ENLACE DE RESTABLECIMIENTO</button>

                <div class="line-width-text">
                    <p><a href="{{ route('login') }}">Volver al Inicio de Sesión</a></p>
                </div>
            </form>
        </div>

        <div class="banner">
            <img src="/images/bbn2.png" alt="logo_login"/>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sign" id="btn-Sign-In">
                <img src="https://e7.pngegg.com/pngimages/779/61/png-clipart-logo-idea-cute-eagle-leaf-logo.png" alt="Sign In">
                <span>Synapse CTF</span>
            </div>
        </div>
    </div>
</body>
</html>
