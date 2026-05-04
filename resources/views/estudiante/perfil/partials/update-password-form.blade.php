<section>
    <header class="profile-header">
        <h2 class="section-title">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="profile-description">
            {{ __('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerla segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="profile-form-group">
        @csrf
        @method('put')

        <div class="form-field">
            <label for="update_password_current_password" class="input-label">{{ __('Contraseña Actual') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="text-input" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="update_password_password" class="input-label">{{ __('Nueva Contraseña') }}</label>
            <input id="update_password_password" name="password" type="password" class="text-input" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="update_password_password_confirmation" class="input-label">{{ __('Confirmar Contraseña') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="text-input" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="save-status-message"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
