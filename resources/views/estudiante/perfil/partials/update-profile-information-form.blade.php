<section>
    <header class="profile-header">
        <h2 class="section-title">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="profile-description">
            {{ __("Visualiza la información de tu perfil.") }}
        </p>
    </header>

    <!-- Se mantiene el formulario de verificación de correo si es necesario -->
    

    <div class="profile-details-view">
        <div class="form-field">
            <label for="name" class="input-label">{{ __('Nombre') }}</label>
            <p class="text-display">{{ $user->name }}</p>
        </div>

        <div class="form-field">
            <label for="app_usu" class="input-label">{{ __('Apellido Paterno') }}</label>
            <p class="text-display">{{ $user->app_usu }}</p>
        </div>

        <div class="form-field">
            <label for="apm_usu" class="input-label">{{ __('Apellido Materno') }}</label>
            <p class="text-display">{{ $user->apm_usu }}</p>
        </div>

        <div class="form-field">
            <label for="email" class="input-label">{{ __('Correo Electrónico') }}</label>
            <p class="text-display">{{ $user->email }}</p>
        </div>
    </div>
</section>

<style>
    .profile-details-view .form-field {
        margin-bottom: 1.5rem;
    }
    .profile-details-view .input-label {
        font-size: 0.875rem; /* text-sm */
        font-weight: 500; /* font-medium */
        color: #94a3b8; /* slate-400 */
        margin-bottom: 0.5rem;
        display: block;
    }
    .profile-details-view .text-display {
        font-size: 1rem; /* text-base */
        color: #f8fafc; /* slate-50 */
        background-color: #1e293b; /* slate-800 */
        padding: 0.75rem 1rem; /* py-3 px-4 */
        border-radius: 0.5rem; /* rounded-lg */
        border: 1px solid #334155; /* border-slate-700 */
        width: 100%;
    }
    .verification-notice {
        margin-top: 1rem;
        padding: 0.75rem;
        background-color: #16a34a; /* bg-green-500 */
        color: #dcfce7; /* text-green-100 */
        border-radius: 0.5rem;
    }
    .notice-text {
        font-size: 0.875rem;
    }
    .verification-button {
        text-decoration: underline;
        color: #dcfce7; /* text-green-100 */
        margin-left: 0.25rem;
    }
    .verification-success {
        font-size: 0.75rem; /* text-xs */
        color: #22c55e; /* text-green-500 */
        margin-top: 0.5rem;
    }
</style>
