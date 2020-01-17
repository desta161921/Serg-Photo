<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
    <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="container__search">
        <div class="wrapper__search">
            <div class="search__users">
                <h1>Users:</h1>
                <?php if($userquery != 'empty'): ?>
                    <?php
                        $users = $userquery->get();
                    ?>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="btn btn-searchResult" href="<?php echo e(route('profile')); ?>/<?php echo e($user->user_Id); ?>"><?php echo e($user->first_Name); ?> <?php echo e($user->last_Name); ?><br></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    Empty search
                <?php endif; ?>
            </div>
            <div class="search__events">
                <h1 class="search__events-heading">Events:</h1>
                 
                <?php if($eventquery != 'empty'): ?>
                    <?php
                        $events = $eventquery->get();
                    ?>
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="btn btn-searchResult" href="<?php echo e(route('events')); ?>/<?php echo e($event->event_Id); ?>"><?php echo e($event->event_Name); ?> <br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    Empty search
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
