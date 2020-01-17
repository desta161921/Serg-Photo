<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
     <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="container__box">
        <div class="wrapper wrapper2" >
            <?php if( (!is_null(DB::table('events')->where('event_Id', '=', $event->event_Id)->where('event_Privacy', '=', 'private')->first())) and
                (is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->first()))): ?>
                
                You do not have accesss plz ask admin.
            <?php else: ?>
                <div class="event_header">
                    <img src="/uploads/events/<?php echo e($event->event_Header); ?>" class="event__header-img">
                </div>
                
            <div class="event__info">
                <h1 class="event__description-name"><?php echo e($event->event_Name); ?></h1>
                <p class="event_description-about"><?php echo e($event->event_Description); ?></p>
                <br>
                <h1>Participants</h1>
                
                <table>
                    <tr>
                        <td><h3>Full name</h3></td>
                        <td><h3>Role</h3></td>
                    </tr>
                <?php
                    $row = DB::table('participants')->where('event_Id', $event->event_Id)->get();
                    
                    foreach ($row as $participants) {
                        echo "<tr><td>" . \App\User::find($participants->user_Id)->first_Name. " ". \App\User::find($participants->user_Id)->last_Name . "</td><td>".  $participants->participant_Role . "</tr>" ;
                    
                    }
                ?>
                </table>
                
                <?php if((is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->first()))): ?>
                <form name="_token" method="POST" action="/joinEvent" value="<?php echo csrf_token(); ?>">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="event_Id" value="<?php echo e($event->event_Id); ?>" action="<?php echo e(action('EventController@joinEvent')); ?>">
                    <button class="btn btn-form" id="join">Click to join</button>    
                </form>
                <?php endif; ?>
                
                <?php if((!is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->first()))): ?>
                    <form name="_token" method="POST" action="/leaveEvent" value="<?php echo csrf_token(); ?>">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="event_Id" value="<?php echo e($event->event_Id); ?>" action="<?php echo e(action('EventController@leaveEvent')); ?>">
                        <button class="btn btn-form" id="join" onclick="return confirmLeave();">Click to leave</button>    
                    </form>
                <?php endif; ?>
                
                 
                <?php if((!is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->where('participant_Role', '=', 'Admin')->first()))): ?>
                <a class="btn btn-form" href="<?php echo e(url('/events/edit', [$event->event_Id])); ?>" id="edit__event">Edit event</a>
                <?php endif; ?>
                 
                
                
                    <div class="event-feed">
                    <?php if((!is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->first()))): ?>
                    <form name="upload__photo" method="POST" action="/uploadPhoto" value="<?php echo csrf_token(); ?>" enctype="multipart/form-data">
                        <input type="file" name="event__photo">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <input type="hidden" name="event_Id" value="<?php echo e($event->event_Id); ?>">
                        <input type="submit" class="btn btn-form" value="Upload event photo">
                    </form>
                    <?php endif; ?>
                    
                    
                    
                    
                        <div class="event-pictures">
                            <?php
                                $eventPhotos = DB::table('files')
                                ->where('event_Id', "=", $event->event_Id)
                                ->orderBy('file_Id', 'desc')
                                ->get();
                            ?>
                    <?php $__currentLoopData = $eventPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventPhoto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src='/uploads/events/<?php echo e($event->event_Id); ?>/<?php echo e($eventPhoto->file_Name); ?>'></img>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    
                 
                    
                    
                        
                    
                    
                    
                    </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo e(URL::asset('js/javascript.js')); ?>"></script>
</body>
</html>

