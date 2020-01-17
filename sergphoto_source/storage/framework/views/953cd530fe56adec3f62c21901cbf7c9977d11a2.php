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
                    $eventCount = DB::table('events')
                    ->orderBy('event_Id', 'desc')
                    ->get();
                ?>
                
                <?php $__currentLoopData = $eventCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\App\Event::find($i->event_Id)->event_Privacy == 'public'): ?>
                         <h1 class="event__description-name"><a href="<?php echo e(route('events')); ?>/<?php echo e($i->event_Id); ?>"><?php echo e(\App\Event::find($i->event_Id)->event_Name); ?></a></h1>
                         <p class="event_description-about"><?php echo e(\App\Event::find($i->event_Id)->event_Description); ?></p>
                         <?php echo e(\App\Event::find($i->event_Id)->event_Privacy); ?>

                         <br>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a class="myEvents" href="myevents">My events</a>
                <button id="myBtn">Create event</button>
            </div>
        </div>
    </div>
                     
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>shot opp</h2>
            </div>
            <div class="modal-body">
                <form action="/create" method="post" enctype="multipart/form-data">
                    <input type="hidden" name ="_token" value="<?php echo csrf_token(); ?>">
                    <table>
                        <tr>
                            <td>Event name</td>
                            <td><input type='text' name='event_Name'></td>
                        </tr>
                        <tr>
                            <td>Event type</td>
                            <td><select name='event_Type'>
                                <option value="LAN">LAN</option>
                                <option value="WEDDING">WEDDING</option>
                                <option value="GRADUATION">GRADUATION</option>
                                <option value="PARTY">PARTY</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td>Event description</td>
                            <td><input type='textbox' name='event_Description'></td>
                        </tr>
                        <tr>
                            <td>Event Location</td>
                            <td><input type='text' name='event_Location'></td>
                        </tr>
                        <tr>
                            <td><select name='event_Privacy'>
                                <option value="private">Private</option>
                                <option value="public" selected>Public</option>
                                <option value="hidden">Hidden (Link only)</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td>Event header</td>
                            <td><input type="file" name="event_Header"></td>
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        </tr>
                        <tr>
                            <td colspan='2'><input type='submit' value ="Add event"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <h3>ney</h3>
            </div>
        </div>
    </div>
   <script type="text/javascript" src="js/fullPage.min.js"></script>
   <script type="text/javascript" src="<?php echo e(URL::asset('js/modal.js')); ?>"></script>
</body>
</html>
