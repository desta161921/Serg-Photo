<!DOCTYPE html>
<html>
    <head>
        <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;    
    </head>
    <body>
        <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
        <div class="wrapper-profile">
            <section class="editprofile">
                <div class="editprofile-img">
                    <?php 
                        $userId = Auth::id(); 
                        $user = \App\User::find($userId);
                    ?>
                    <img src="/uploads/avatars/<?php echo e($user->avatar); ?>" class="editprofile-img">
                    <form enctype="multipart/form-data" action="/editprofile" method="POST">
                        <label>Update profile picture</label>
                        <input type="file" name="avatar">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <input type="submit" class="btn btn-form" value="Update profile picture">
                    </form>
                </div>
            </section>
            <section class="editprofile-info">
                <div class="editprofile-information">
                <form method="POST" name="_token" action="profile/update" value="<?php echo csrf_token(); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group <?php echo e($errors->has('first_Name') ? ' has-error ' : ' '); ?>">
                        <label for="first_Name" class="control-label">First name: </label>
                        <input type="text" name="first_Name" value=" <?php echo e($user->first_Name); ?>" disabled>
                    </div>
                    <div class="form-group <?php echo e($errors->has('last_Name') ? ' has-error ' : ' '); ?>">
                        <label for="last_Name" class="control-label">Last name: </label>
                        <input type="text" name="last_Name" value=" <?php echo e($user->last_Name); ?>" disabled>
                    </div>
                    <div class="form-group <?php echo e($errors->has('schoolname') ? ' has-error ' : ' '); ?>">
                        <label for="schoolname" class="control-label">Student at: </label>
                        <input type="text" name="schoolname" value="<?php echo e($user->schoolname); ?>" action="<?php echo e(action('UserController@update')); ?>">
                    </div>
                    <div class="form-group <?php echo e($errors->has('class') ? ' has-error ' : ' '); ?>">
                        <label for="class" class="control-label">Studying: </label>
                        <input type="text" name="class" value="<?php echo e($user->class); ?>" action="<?php echo e(action('UserController@update')); ?>">
                    </div>
                    <div class="form-group <?php echo e($errors->has('location') ? ' has-error ' : ' '); ?>">
                        <label for="location" class="control-label">Location: </label>
                        <input type="text" name="location" value="<?php echo e($user->location); ?>" action="<?php echo e(action('UserController@update')); ?>">
                    </div>
                    <div class="form-group <?php echo e($errors->has('hobby') ? ' has-error ' : ' '); ?>">
                        <label for="hobby" class="control-label">Hobby: </label>
                        <input type="text" name="hobby" value="<?php echo e($user->hobby); ?>" action="<?php echo e(action('UserController@update')); ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-form">Update Profile</button>
                    </div>
                </form>
                
                 <a class="btn btn-form" href="<?php echo e(action('UserController@deleteUser')); ?>" id="delete_User" onclick="return deleteUser();">Delete User</a>
                
            </section>
        </div>
        <script type="text/javascript" src="<?php echo e(URL::asset('js/javascript.js')); ?>"></script>
    </body>
</html>