

<?php $__env->startSection('title', 'Nueva Evaluación'); ?>

<?php $__env->startSection('sidebar_menu'); ?>
    <?php echo $__env->make('layouts.partials.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_header'); ?>
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-bold tracking-tight text-white/90">
            Nueva Evaluación
        </h1>
        <p class="text-sm text-gray-400">
            Crea un nuevo desafío Evaluación lógico-matemática para los estudiantes.
        </p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('evaluaciones.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo $__env->make('admin.evaluaciones._form', ['evaluacion' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\synapse\resources\views/admin/evaluaciones/create.blade.php ENDPATH**/ ?>