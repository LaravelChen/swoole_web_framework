<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template Test</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link href="//cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
</body>
</html>