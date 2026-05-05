
<?php
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
?>

<div class="form-group">
    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
           value="<?php echo e(old('name', $user->name ?? '')); ?>" required 
           oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ ]/g, '')">
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="app_usu">Apellido Paterno:</label>
    <input type="text" name="app_usu" id="app_usu" class="form-control <?php $__errorArgs = ['app_usu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
           value="<?php echo e(old('app_usu', $user->app_usu ?? '')); ?>" <?php echo e($requiredApp ? 'required' : ''); ?> 
           oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ ]/g, '')">
    <?php $__errorArgs = ['app_usu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="apm_usu">Apellido Materno:</label>
    <input type="text" name="apm_usu" id="apm_usu" class="form-control <?php $__errorArgs = ['apm_usu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
           value="<?php echo e(old('apm_usu', $user->apm_usu ?? '')); ?>" <?php echo e($requiredApm ? 'required' : ''); ?> 
           oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ ]/g, '')">
    <?php $__errorArgs = ['apm_usu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="form-group">
    <label for="email">Correo Electrónico:</label>
    <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
           value="<?php echo e(old('email', $user->email ?? '')); ?>" required 
           pattern="<?php echo e($emailPattern); ?>" title="<?php echo e($emailTitle); ?>" maxlength="160">
    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <span id="email-prefix-feedback" class="invalid-feedback" role="alert" style="display: none;">
        <strong><?php echo e($emailPrefixMessage); ?></strong>
    </span>
    <span id="email-suffix-feedback" class="invalid-feedback" role="alert" style="display: none;">
        <strong>El correo electrónico debe terminar con '@unifranz.edu.bo'</strong>
    </span>
</div>

<?php if($showPassword): ?>
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
               <?php echo e(isset($user) ? '' : 'required'); ?>>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
               <?php echo e(isset($user) ? '' : 'required'); ?>>
        <span id="password-match-feedback" class="invalid-feedback" role="alert" style="display: none;">
            <strong>Las contraseñas no coinciden.</strong>
        </span>
    </div>
<?php endif; ?>

<?php /**PATH C:\laragon\www\synapse\resources\views/components/forms/user-fields.blade.php ENDPATH**/ ?>