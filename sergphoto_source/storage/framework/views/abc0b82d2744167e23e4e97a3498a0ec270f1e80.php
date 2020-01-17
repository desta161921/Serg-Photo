<!DOCTYPE html>
<html>
    <head>
        <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;    
    </head>
    <body>
        <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
        <div class="wrapper-profile">
            <section class="editprofile">
                <img src="/uploads/events/<?php echo e($event->event_Header); ?>" class="editprofile-img">
                <form enctype="multipart/form-data" action="/updateHead" method="POST">
                    <label>Update event picture</label>
                    <input type="file" name="event-header">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="eventId" value="<?php echo e($event->event_Id); ?>">
                    <input type="submit" class="btn btn-form" value="Update event picture">
                </form>
            </section>
            <section class="editprofile-info">
                <div class="editprofile-information">
                    <?php
                            $row = DB::table('participants')->where('event_Id', $event->event_Id)->get();
                        ?>
 
                 <form method="POST" name="_token" action="/updateEvent" value="<?php echo csrf_token(); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group <?php echo e($errors->has('event_Name') ? ' has-error ' : ' '); ?>">
                        <label for="event_Name" class="control-label">Event name </label>
                        <input type="text" name="event_Name" value=" <?php echo e($event->event_Name); ?>" action="<?php echo e(action('EventController@updateEvent')); ?>">
                    </div>
                    <div class="form-group <?php echo e($errors->has('event_Type') ? ' has-error ' : ' '); ?>">
                        <label for="event_Type" class="control-label">Type of event </label>
                        <select name="event_Type" value=" <?php echo e($event->event_Type); ?>" action="<?php echo e(action('EventController@updateEvent')); ?>">
                            <option value="LAN">LAN</option>
                            <option value="WEDDING">WEDDING</option>
                            <option value="GRADUATION">GRADUATION</option>
                            <option value="PARTY">PARTY</option>
                        </select>
                    </div>
                    <div class="form-group <?php echo e($errors->has('event_Description') ? ' has-error ' : ' '); ?>">
                        <label for="event_Description" class="control-label">Description </label>
                        <input type="text" name="event_Description" value="<?php echo e($event->event_Description); ?>" action="<?php echo e(action('EventController@updateEvent')); ?>">
                    </div>
                    <div class="form-group <?php echo e($errors->has('class') ? ' has-error ' : ' '); ?>">
                        <label for="event_Location" class="control-label">Event location: </label>
                        <input type="text" name="event_Location" value="<?php echo e($event->event_Location); ?>" action="<?php echo e(action('EventController@updateEvent')); ?>">
                    </div>
                    <div class="form-group <?php echo e($errors->has('location') ? ' has-error ' : ' '); ?>">
                        <label for=event_Privacy class="control-label">Level of privacy: </label>
                       <select name="event_Privacy" value=" <?php echo e($event->event_Privacy); ?>" action="<?php echo e(action('EventController@updateEvent')); ?>">
                           <option value="private">Private</option>
                            <option value="public" selected>Public</option>
                            <option value="hidden">Hidden (Link only)</option>
                        </select>
                    </div>
                    <input type="hidden" name="event_Id" value="<?php echo e($event->event_Id); ?>" action="<?php echo e(action('EventController@updateEvent')); ?>">
                    <div class="form-group">
                        <button type="submit" class="btn btn-form">Update event</button>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-form">Delete event</button>
                    </div>
                </form>
                
                
            </section>
        </div>
    </body>
</html>