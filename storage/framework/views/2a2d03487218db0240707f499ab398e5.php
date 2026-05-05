

<?php $__env->startSection('title', 'Editar Evaluación'); ?>

<?php $__env->startSection('sidebar_menu'); ?>
    <?php echo $__env->make('layouts.partials.sidebar_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_header'); ?>
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-bold tracking-tight text-white/90">
            Editar Evaluación
        </h1>
        <p class="text-sm text-gray-400">
            Modificando: <span class="font-mono text-orange-400"><?php echo e($evaluacion->titulo_eval); ?></span>
        </p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('evaluaciones.update', $evaluacion)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo method_field('PATCH'); ?>
        <?php echo $__env->make('admin.evaluaciones._form', ['evaluacion' => $evaluacion], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\synapse\resources\views/admin/evaluaciones/edit.blade.php ENDPATH**/ ?>