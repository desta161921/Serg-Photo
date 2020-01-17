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
                <h2 class="event__list-heading">Eventlist</h2>
            </div>
            <div class="event__info">
                <?php
                    $eventCount = DB::table('events')
                    ->orderBy('event_Id', 'desc')
                    ->paginate(10);
                ?>
                
                <table class="event__info-table">
                    <tr>
                        <th class="event__info-heading">Event</th>
                        <th class="event__info-heading">Description</th>
                        <th class="event__info-heading">Location</th>
                    </tr>
                <?php $__currentLoopData = $eventCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\App\Event::find($i->event_Id)->event_Privacy == 'public'): ?>
                        <tr>
                            <td><p class="event__description-name el__d-name"><a class="event__description-link" href="<?php echo e(route('events')); ?>/<?php echo e($i->event_Id); ?>"><?php echo e(\App\Event::find($i->event_Id)->event_Name); ?></a></p></td>
                            <td><p class="event__description-about"><?php echo e(str_limit(\App\Event::find($i->event_Id)->event_Description, 50)); ?></p></td>
                            <td><p class="event__description-about"><?php echo e(\App\Event::find($i->event_Id)->event_Location); ?></p></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
                <div class="event__paginate">
                    <?php echo $eventCount->render(); ?>

                </div>
                <div class="event__buttons">
                    <button id="myBtn" class="btn-event btn-form btn-event-l">Create event</button>
                    <a class="btn-event btn-form btn-event-r" href="myevents">My events</a>
                </div>
            </div>
        </div>
    </div>
                     
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-heading">
                    <h2 class="modal-heading-h">Create event</h2>
                </div>
                <span class="btn-closeModal">&times;</span>
            </div>
            <div class="modal-body">
                <form action="/create" class="form__event" method="post" enctype="multipart/form-data">
                    <input type="hidden" name ="_token" value="<?php echo csrf_token(); ?>">
                    <table>
                        <tr>
                            <td><label class="event-label">Name</label></td>
                            <td><input type='text' class="event-input" name='event_Name' required></td>
                        </tr>
                        <tr>
                            <td><label class="event-label">Description</label></td>
                            <td><textarea class="event-input" name ="event_Description" rows="4" cols="50" required></textarea></td>
                        </tr>
                        <tr>
                            <td><label class="event-label">Location</label></td>
                            <td><input class="event-input" id="geocomplete" type='text' name='event_Location' required></td>
                        </tr>
                        <tr>
                            <td><label class="event-label">Type</label></td>
                            <td><select class="event-input" name='event_Type'>
                                <option value="Wedding">Wedding</option>
                                <option value="Party">Party</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td><label class="event-label">Privacy</label></td>
                            <td><select class="event-input" name='event_Privacy'>
                                <option value="private">Private</option>
                                <option value="public" selected>Public</option>
                                <option value="hidden">Hidden (Link only)</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td><label class="event-label">Header</label></td>
                            <td><input class="event-input" type="file" name="event_Header"></td>
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        </tr>
                        <tr>
                            <td colspan='2'><input class="btn-event btn-form btn-modal" type='submit' value ="Create event"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
   <script type="text/javascript" src="<?php echo e(URL::asset('js/modal.js')); ?>"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDiEw6eEobaD__SGRhNQrY-tFtQFdqVGY&amp;sensor=false&amp;libraries=places"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo e(URL::asset('js/jquery.geocomplete.min.js')); ?>"></script>
    <script>
      $(function(){
        $("#geocomplete").geocomplete()
      });
    </script>
</body>
</html>
