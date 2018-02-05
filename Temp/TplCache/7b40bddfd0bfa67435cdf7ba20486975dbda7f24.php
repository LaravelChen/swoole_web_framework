<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
                <?php if(isset($errors)): ?>
                        <ul class="list-group">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item list-group-item-danger"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                <?php endif; ?>
                <div class="well bs-component">
                    <form role="form" method="POST" action="<?php echo e(url('create_user')); ?>" class="form-horizontal">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <fieldset>
                            <legend class="text-center">创建用户</legend>
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1"><label for="phone"
                                                                              class="control-label">电话号码</label> <input
                                            id="phone" type="phone" name="phone" value=""
                                            required="required" autofocus="autofocus"
                                            class="form-control"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1"><label for="name"
                                                                              class="control-label">用户名</label>
                                    <input id="name" type="name" name="name"
                                           required="required"
                                           class="form-control"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <button type="submit" class="btn btn-success form-control">
                                        登录
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>