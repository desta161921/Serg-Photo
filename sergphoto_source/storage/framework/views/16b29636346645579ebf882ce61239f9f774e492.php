<?php if(session('alert')): ?>
        <script>
            alert("<?php echo e(html_entity_decode(session('alert'))); ?>");
        </script>
<?php endif; ?> 


 <header class="header" >
    <div class="header-container">
        <div class="header__logo-box">
            <a href="<?php echo e(URL::asset('/')); ?>"><img src=<?php echo e(URL::asset('img/logo.png')); ?> alt="Logo" class="header__logo"></a>
            <a href="<?php echo e(URL::asset('/')); ?>"><h3 class="header__logo-text">SergPhoto</h3></a>
        </div>
        <?php if(auth()->guard()->guest()): ?>
        <?php else: ?>
            <form class="header__search" action="<?php echo e(URL::asset('toSearchableArray')); ?>" method="POST" value=" <?php echo e(csrf_token()); ?>">
                <?php echo e(csrf_field()); ?>

                <div class="search">
                    <button id="searchButton" class="btn-search" type="submit"><span class="fa fa-search"></span></button>
                    <input type="text" class="header__search-box" name="searchValue">
                </div>
            </form>
        <?php endif; ?>
        <nav class="nav" >
            <?php if(auth()->guard()->guest()): ?>
            <ul class="nav__items">
                <li class="nav__item">
                    <a class="btn btn-nav" href="/">Log in</a>
                </li>
                <li class="nav__item">
                    <a class="btn btn-nav" href="/signup">Sign up</a>
                </li>
            </ul>
            <?php else: ?>
            <ul class="nav__items">
                <div class="dropdown" >
                    <button class="btnDrop" onclick="notifications()">Notifications <?php echo e(Auth::user()->unreadNotifications->count()); ?></button>
                    <div class="notifications__content" id="notificationDropdown" style="display:none">
                        <?php
                        if(Auth::user()->notifications->count() != 0){
                            ?>
                            <div id="notification_all">
                            <?php
                            foreach (Auth::user()->notifications as $notification) {
                                if($notification->read_at == NULL){
                                    echo "<div id='".$notification->id."'><p><a href='".$notification->data['url']."'> (UNREAD)".$notification->data['message'].'</a>  <input type="button" onclick="DeleteNotification()" value="Delete" /></p></div>';
                                    Auth::user()->unreadNotifications()->update(['read_at' => now()]);
                                }else{
                                    ?>
                                    <div id="<?php echo e($notification->id); ?>"><p><a href="<?php echo e($notification->data['url']); ?>"> (READ) <?php echo e($notification->data['message']); ?></a>  <input type="button" onclick="DeleteNotification('<?php echo e($notification->id); ?>')" value="Delete" /></p></div>
                                    <?php
                                }
                            }
                            ?>
                                <input type="button" onclick="DeleteNotification('all')" value="Delete all" />
                            </div>
                            <?php
                        }else{
                        echo "No notifications";
                        }
                        ?>
                        
                    </div>
                </div>
                <li class="nav__item">
                    <a class="btn btn-nav" href="<?php echo e(route('feed')); ?>">Feed</a>
                </li>
                <li class="nav__item">
                    <a class="btn btn-nav" href="<?php echo e(route('profile')); ?>">Profile</a>
                </li>
                <li class="nav__item">
                    <a class="btn btn-nav" href="<?php echo e(route('events')); ?>">Events</a>
                </li>
                <li class="nav__item">
                    <a class="btn btn-nav" href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo e(csrf_field()); ?>

                    </form>
                </li>
            </ul>
            <?php endif; ?>
        </nav>
    </div>
</header>
<?php if(session('alert')): ?>
        <script>
            alert("<?php echo e(html_entity_decode(session('alert'))); ?>");
        </script>
<?php endif; ?> 
<script>
    function DeleteNotification(pid) {
        var token = $('meta[name="csrf-token"]').attr('content');
        if(pid == 'all'){
            if (confirm("Press Ok to delete all notification.")) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(url('/')); ?>/notification/delete",
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token:'<?php echo e(csrf_token()); ?>',
                        notification: 'all'
                    },
                    success:function(data){
                        $('#notification_all').html('No notifications');
                    },
                    error:function(){
                        alert("Something went wrong.");
                    }
                    });
            } else {
                alert("You pressed Cancel!");
            }
        }else{
            $.ajax({
                type: "POST",
                url: "<?php echo e(url('/')); ?>/notification/delete",
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _token:'<?php echo e(csrf_token()); ?>',
                    notification: pid
                },
                success:function(data){
                    $('#'+pid).hide();
                },
                error:function(){
                    alert("Something went wrong.");
                }
            });
        }
    };
</script>

