<!DOCTYPE html>
<html>
    <head>
        <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/css/swiper.min.css">
    </head>
    <body>
        <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="wrapper-profile">
            <div class="profile__container">
                <div class="profile__information-l">
                    <img src="<?php echo e(URL::asset('uploads/avatars')); ?>/<?php echo e($user->avatar); ?>" class="profile__img">
                    <div class="profile__description">
                        <h1 class="profile__description-name"><?php echo e($user->first_Name); ?> <?php echo e($user->last_Name); ?></h1>
                        <p class="profile__description-about"><?php echo e($user->schoolname); ?></p>
                    </div>
                    <div class="profile__info">
                        <p class="profile__description-study">Studying: <?php echo e($user->class); ?></p>
                        <p class="profile__description-study">Location: <?php echo e($user->location); ?></p>
                        <p class="profile__description-study">Hobby: <?php echo e($user->hobby); ?></p>
                        <?php if(Auth::id() == $user->user_Id): ?>
                            <a class="btn btn-form" href="<?php echo e(route('editprofile')); ?>" id="event_Modal">Edit profile</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="profile__gallery">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="<?php echo e(URL::asset('img/bogenpornoas.jpg')); ?>" class="swiper-slide-img">
                        </div>
                        <div class="swiper-slide">
                            <img src="<?php echo e(URL::asset('img/bogenpornoas.jpg')); ?>" class="swiper-slide-img">
                        </div>
                        <div class="swiper-slide">
                            <img src="<?php echo e(URL::asset('img/bogenpornoas.jpg')); ?>" class="swiper-slide-img">
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/js/swiper.min.js"></script>
        <script type="text/javascript" src="<?php echo e(URL::asset('js/swiperRun.js')); ?>"></script>
    </body>
</html>