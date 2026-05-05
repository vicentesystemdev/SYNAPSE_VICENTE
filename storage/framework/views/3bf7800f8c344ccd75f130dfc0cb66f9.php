

<?php $__env->startSection('title', 'Crear Nuevo Estudiante'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Crear Nuevo Estudiante</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar_menu'); ?>
    <?php echo $__env->make('layouts.partials.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Creación de Estudiante</h3>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.estudiantes.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <?php echo $__env->make('components.forms.user-fields', ['emailPrefix' => 'lpze'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar Estudiante</button>
                <a href="<?php echo e(route('admin.estudiantes.index')); ?>" class="btn btn-secondary"><i class="fas fa-ban"></i> Cancelar</a>
            </form>

            <div class="mt-4 p-3 border rounded" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24;">
                <p class="font-weight-bold">NOTA:</p>
                <p>SE PROPORCIONARÁ UNA CONTRASEÑA SIMPLE A CADA NUEVO USUARIO QUE SEA REGISTRADO POR UN ADMINISTRADOR, SI EL USUARIO DESEA PUEDE CAMBIAR SU CONTRASEÑA DESDE SU PERFIL.</p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <?php echo $__env->make('components.scripts.email-validation', ['emailPrefix' => 'lpze'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.scripts.password-validation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\synapse\resources\views/admin/usuarios/estudiantes/create.blade.php ENDPATH**/ ?>