<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
     <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="event__container">
             <div class="event__header">
                 <div class="event__info">
                     <?php
                        $eventCount = DB::table('participants')
                            ->where('user_Id', Auth::id())
                            ->orderBy('event_Id', 'desc')
                            ->get();
                     ?>
                <?php $__currentLoopData = $eventCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('events')); ?>/<?php echo e($event->event_Id); ?>"><?php echo e(\App\Event::find($event->event_Id)->event_Name); ?></a><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     
                <a class="allEvents" href="events">All events</button>  
                     
                 
   <script type="text/javascript" src="js/fullPage.min.js"></script>
   <script type="text/javascript" src="<?php echo e(URL::asset('js/modal.js')); ?>"></script>
</body>
</html>
