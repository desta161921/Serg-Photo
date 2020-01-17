<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/css/swiper.min.css">
</head>
<body>
    <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="container__profile">
        <div class="wrapper__profile">
            <div class="profile__information">
                    <img src="<?php echo e(URL::asset('uploads/avatars')); ?>/<?php echo e($user->avatar); ?>" class="profile__img">
                    <div class="profile__description">
                        <h1 class="profile__description-name"><?php echo e($user->first_Name); ?> <?php echo e($user->last_Name); ?></h1>
                    </div>
                    <div class="profile__info">
                        <p class="profile__description-study">Date of birth: <?php echo e($user->DOB); ?></p>
                        <p class="profile__description-study">Location: <?php echo e($user->location); ?></p>
                        <?php if(Auth::id() == $user->user_Id): ?>
                            <a class="btn btn-form" href="<?php echo e(route('editprofile')); ?>" id="event_Modal">Edit profile</a>
                            <button id="myBtn" class="btn-form btn-feed">Create album</button>
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-heading">
                                            <h2 class="modal-heading-h">Create album</h2>
                                        </div>
                                        <span class="btn-closeModal">&times;</span>
                                    </div>
                                    <div class="modal-body">
                                        <div class="profile__upload">
                                            <form value="<?php echo csrf_token(); ?>" class="album_upload-form" enctype="multipart/form-data" name="_token" action="/createAlbum"  method="POST">
                                                <input type="text" class="feed-input" name="album_Name-input" placeholder="Name..">
                                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                <input type="text" class="feed-input" name="album_Description" placeholder="Description.." required>
                                                <select class="album-input" name="album_Privacy">
                                                    <option value="" disabled selected>Select permissions</option>
                                                    <option value="public">Public</option>
                                                    <option value="private">Private</option>
                                                </select>
                                                <input type="submit" class="btn btn-upload" value="Create album">
                                            </form>
                                        </div>
                                        <div class="profile__upload-bottom">
                                            <img class="mainfeed__post-img" id="output_image"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                </div>
            </div>
            <div class="album__list">
                <h2 class="album__list-heading">Albums</h2>
            </div>  
            <div class="profile__gallery">
                <?php
                    $album = DB::table('albums')->where('user_Id', $user->user_Id)->paginate(3);
                    $i = 0;
                ?>
                
                <?php $__currentLoopData = $album; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $albums): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($albums->album_Permission == 'public' || $albums->user_Id == Auth::id()): ?>
                    <div class="profile__gallery-description">
                        <a href="<?php echo e(url('/')); ?>/album/<?php echo e($albums->album_Id); ?>"><h1 class="profile__gallery-p"><?php echo e($albums->album_Name); ?> - (<?php echo e(DB::table('files')->where('user_Id', $user->user_Id)->where('album_Id', $albums->album_Id)->count()); ?> photos)</h1></a>
                        <h3 class="profile__gallery-heading"><?php echo e($albums->album_Description); ?></h3>
                    </div>
                    <?php
                        $photo = DB::table('files')->where('user_Id', $user->user_Id)->where('album_Id', $albums->album_Id)->take(4)->orderBy('file_Id', 'Desc')->get();
                        $i++;
                    ?>
                    <div class="profile__gallery-row">
                    <?php $__currentLoopData = $photo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="profile__gallery-column">
                            <a href="<?php echo e(url('/')); ?>/album/<?php echo e($albums->album_Id); ?>">
                            <img class="profile__gallery-img" src="<?php echo e(url('/')); ?>/uploads/users/<?php echo e($photos->user_Id); ?>/<?php echo e($albums->album_Name); ?>/<?php echo e($photos->file_Name); ?>"></a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($album->links()); ?>


            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo e(URL::asset('js/modal.js')); ?>"></script>
</body>
</html>