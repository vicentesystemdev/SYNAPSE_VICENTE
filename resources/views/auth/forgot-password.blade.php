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
</body>
</html>
