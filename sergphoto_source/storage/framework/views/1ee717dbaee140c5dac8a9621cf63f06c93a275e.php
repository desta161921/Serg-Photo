<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body>
<?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container__album">
    <div class="wrapper__album">
        <div class="album__list">
            <h2 class="error-h">Error</h2>
        </div>
        
        <?php if(session('error')): ?>
            <center><h1 class="error-p"><?php echo e(session('error')); ?></h1></center>
        <?php endif; ?> 
        
    </div>
</div>

</body>
</html>