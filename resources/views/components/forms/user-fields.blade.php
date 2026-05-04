{{-- Componente reutilizable para campos comunes de usuario
     Parámetros:
     - user: Modelo del usuario (opcional, para edición)
     - emailPrefix: 'lpze', 'doc', o 'both' (default: 'both')
     - showPassword: true/false (default: true si no hay user, false si hay)
     - requiredApp: true/false (default: true)
     - requiredApm: true/false (default: false)
--}}
@php
    $emailPrefix = $emailPrefix ?? 'both';
    $showPassword = $showPassword ?? (!isset($user));
    $requiredApp = $requiredApp ?? true;
    $requiredApm = $requiredApm ?? false;
    $emailPattern = $emailPrefix === 'lpze' ? "lpze\\.[a-zA-Z0-9._%+\\-]+@unifranz\\.edu\\.bo" : 
                   ($emailPrefix === 'doc' ? "doc\\.[a-zA-Z0-9._%+\\-]+@unifranz\\.edu\\.bo" : 
                   "^(lpze\\.|doc\\.)[a-zA-Z0-9._%+\\-]+@unifranz\\.edu\\.bo$");
    $emailTitle = $emailPrefix === 'lpze' ? "Debe comenzar con 'lpze.' y terminar con '@unifranz.edu.bo'" : 
                  ($emailPrefix === 'doc' ? "Debe comenzar con 'doc.' y terminar con '@unifranz.edu.bo'" : 
                  "Debe comenzar con 'lpze.' o 'doc.' y terminar con '@unifranz.edu.bo'");
    $emailPrefixMessage = $emailPrefix === 'lpze' ? "El correo electrónico debe empezar con 'lpze.'" : 
                         ($emailPrefix === 'doc' ? "El correo electrónico debe empezar con 'doc.'" : 
                         "El correo electrónico debe empezar con 'lpze.' o 'doc.'");
@endphp

<div class="form-group">
    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
           value="{{ old('name', $user->name ?? '') }}" required 
           oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ ]/g, '')">
    @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="app_usu">Apellido Paterno:</label>
    <input type="text" name="app_usu" id="app_usu" class="form-control @error('app_usu') is-invalid @enderror" 
           value="{{ old('app_usu', $user->app_usu ?? '') }}" {{ $requiredApp ? 'required' : '' }} 
           oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ ]/g, '')">
    @error('app_usu')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="apm_usu">Apellido Materno:</label>
    <input type="text" name="apm_usu" id="apm_usu" class="form-control @error('apm_usu') is-invalid @enderror" 
           value="{{ old('apm_usu', $user->apm_usu ?? '') }}" {{ $requiredApm ? 'required' : '' }} 
           oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ ]/g, '')">
    @error('apm_usu')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="email">Correo Electrónico:</label>
    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
           value="{{ old('email', $user->email ?? '') }}" required 
           pattern="{{ $emailPattern }}" title="{{ $emailTitle }}" maxlength="160">
    @error('email')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
    <span id="email-prefix-feedback" class="invalid-feedback" role="alert" style="display: none;">
        <strong>{{ $emailPrefixMessage }}</strong>
    </span>
    <span id="email-suffix-feedback" class="invalid-feedback" role="alert" style="display: none;">
        <strong>El correo electrónico debe terminar con '@unifranz.edu.bo'</strong>
    </span>
</div>

@if($showPassword)
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
               {{ isset($user) ? '' : 'required' }}>
        @error('password')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <div id="password-requirements" class="mt-2">
            <p class="mb-1" id="length-check"><i class="fas fa-times-circle text-danger"></i> Mínimo 8 caracteres</p>
            <p class="mb-1" id="uppercase-check"><i class="fas fa-times-circle text-danger"></i> Al menos una mayúscula</p>
            <p class="mb-1" id="lowercase-check"><i class="fas fa-times-circle text-danger"></i> Al menos una minúscula</p>
            <p class="mb-1" id="number-check"><i class="fas fa-times-circle text-danger"></i> Al menos un número</p>
        </div>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmar Contraseña:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
               {{ isset($user) ? '' : 'required' }}>
        <span id="password-match-feedback" class="invalid-feedback" role="alert" style="display: none;">
            <strong>Las contraseñas no coinciden.</strong>
        </span>
    </div>
@endif

