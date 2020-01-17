<!DOCTYPE html>
<html>
    <head>
        <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;    
    </head>
    <body>
        <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
        <div class="wrapper-profile">
            <div class="container__feed">
                <div class="feed__main">
                    <div class="feed__main-user">
                        <img src="https://www.bakeru.edu/wp-content/uploads/2016/09/studentTalking-square.jpg" class="feed__main-img">
                        <div class="feed__main-user-info">
                            <h2 class="feed__main-name">Daniel Deggjerud</h2>
                            <p class="feed__main-study">Study at OsloMet</p>
                            <p class="feed__main-posted">5 hours ago</p>
                        </div>
                    </div>
                    <div class="feed__main-post">
                        <div class="feed__main-postimg">
                            <img src="https://images.pexels.com/photos/50582/selfie-monkey-self-portrait-macaca-nigra-50582.jpeg?w=1260&h=750&auto=compress&cs=tinysrgb">
                        </div>
                        <div class="feed__main-comments">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>