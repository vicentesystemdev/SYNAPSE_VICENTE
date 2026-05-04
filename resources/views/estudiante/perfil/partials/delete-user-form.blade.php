<section class="profile-form-group">
    <header class="profile-header">
        <h2 class="section-title">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="profile-description">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.') }}
        </p>
    </header>

    <button
        type="button"
        class="btn btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Eliminar Cuenta') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="profile-form-group">
            @csrf
            @method('delete')

            <h2 class="section-title">
                {{ __('¿Estás seguro de que quieres eliminar tu cuenta?') }}
            </h2>

            <p class="profile-description">
                {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Por favor, introduce tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
            </p>

            <div class="form-field">
                <label for="password" value="{{ __('Contraseña') }}" class="input-label sr-only" />

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="text-input"
                    placeholder="{{ __('Contraseña') }}"
                />

                @error('password', 'userDeletion')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions justify-end">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </button>

                <button type="submit" class="btn btn-danger ms-3">
                    {{ __('Eliminar Cuenta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
