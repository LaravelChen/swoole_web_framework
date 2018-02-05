<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <h2 class="color">Hello This is Swoole!</h2>
            <h5>
                <ul>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($user->phone . ' : ' .$user->name); ?> </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </h5>
            <div>
                <?php echo paginator($users); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>