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
            <h2 class="album__list-heading"><?php echo e($event->event_Name); ?></h2>
            <p class="event__description-about e__d-a"><?php echo e($event->event_Description); ?></p>
        </div>
        <?php if((!is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->where('participant_Role', '=', 'Admin')->first()))): ?>
            <div class="invitation__template">
                <h1 class="invitation__template-heading">Preview</h1>
                <?php if(file_exists(public_path().'/uploads/events/'.$event->event_Id.'/invitation.png')): ?>
                    <img src="<?php echo e(url('/uploads/events/'.$event->event_Id.'/invitation.png')); ?>">
                    <a class="btn btn-form btn-invitation" href="<?php echo e(url('/events/'. $event->event_Id .'/invitation/edit')); ?>" id="edit__event">Edit invitation layout</a>
                <?php else: ?>
                <p>No preview since you haven't made the invitation layout yet</p>
                <a class="btn btn-form event__btn-group" href="<?php echo e(url('/events/'. $event->event_Id .'/invitation/edit')); ?>" id="edit__event">Create invitation layout</a>
            </div>
            <?php endif; ?>
            <div class="invitation__template-mailinvite">
                <h2 class="invitation__template-mh">Invite</h2>
                <div class="invitation__template-form">
                    <form method="POST" name"_token" enctype="multipart/form-data" action="<?php echo e(route('invite')); ?>" value="<?php echo csrf_token(); ?>">
                         <?php echo e(csrf_field()); ?>

                        <input type="email" class="invitation__template-search" id="search" name="search"></input>
                        <input type="submit" class="invitation__template-invite" value="Invite via email">
                        <input type="hidden" id="event_Id" name="event_Id" value="<?php echo e($event->event_Id); ?>"></input>
                    </form>
                </div>
            </div>
            
            <?php
                $invite = DB::table('invites')->where('event_Id', $event->event_Id)->get()
            ?>
            <div class="invitation__template-invited">
                <h2 class="invitation__template-mh">Pending invitations</h2>
                <table class="invitation__template-table">
                    <tr>
                        <th class="invitation__template-th">Email</th>
                        <th class="invitation__template-th">Token</th>
                        <th class="invitation__template-th">Delete</th>
                    </tr>
                    <?php $__currentLoopData = $invite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invites): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="invitation__template-td"><?php echo e($invites->email); ?></td>
                        <td class="invitation__template-td"><?php echo e($invites->token); ?></td>
                        <td>
                            <form method="POST" name"deleteInvitation" class="invitation__template-delete" action="<?php echo e(url('/events/invitation/delete')); ?>" value="<?php echo csrf_token(); ?>">
                                 <?php echo e(csrf_field()); ?>

                                <input type="hidden" id="invite_token" name="invite_token" value="<?php echo e($invites->token); ?>"></input>
                                <input type="submit" class="invitation__template-invite lp" value="Delete invitation"></input>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                <?php else: ?>
                    Only admin can view invitation.
                <?php endif; ?>
            </div>
    </div>
</div>

</body>
</html>