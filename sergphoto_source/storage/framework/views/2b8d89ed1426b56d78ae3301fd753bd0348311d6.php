<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
<?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="container__events">
        <div class="wrapper__eventlist">
            <div class="event__list">
                <h2 class="event__list-heading">Your eventlist</h2>
            </div>
            <div class="event__info">
                <?php
                    $eventCount = DB::table('participants')
                    ->where('user_Id', Auth::id())
                    ->orderBy('event_Id', 'desc')
                    ->get();
                ?>
                <table class="event__info-table">
                    <tr>
                        <th class="event__info-heading">Event</th>
                        <th class="event__info-heading">User role</th>
                        <th class="event__info-heading">Participants</th>
                    </tr>
                <?php $__currentLoopData = $eventCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><p class="event__description-name el__d-name"><a class="event__description-link" href="<?php echo e(route('events')); ?>/<?php echo e($event->event_Id); ?>"><?php echo e(\App\Event::find($event->event_Id)->event_Name); ?></a></p></td>
                        <td><p class="event__description-about"><?php echo e($event->participant_Role); ?></p></td>
                        <td><p class="event__description-about"><?php echo (DB::table('participants')->where('event_Id', $event->event_Id)->count())?></p></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
                <a class="btn-event btn-form" href="events">All events</a>
            </div>
        </div>
    </div>
</body>
</html>
