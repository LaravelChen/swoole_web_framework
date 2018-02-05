<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
                <img src="<?php echo e($qroce_url); ?>">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>