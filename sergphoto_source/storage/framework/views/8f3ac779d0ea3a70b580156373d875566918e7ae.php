 <header class="header" >
    <div class="header__logo-box">
        <a href="<?php echo e(URL::asset('/')); ?>"><img src="img/v7.svg" alt="Logo" class="header__logo"></a>
        <a href="<?php echo e(URL::asset('/')); ?>"><h3 class="header__logo-text">SergPhoto</h3></a>
    </div>
    <?php if(auth()->guard()->guest()): ?>
    <?php else: ?>
        <form class="header__search" action="<?php echo e(URL::asset('toSearchableArray')); ?>" method="POST" value=" <?php echo e(csrf_token()); ?>">
            <?php echo e(csrf_field()); ?>

            <input type="text" class="header__search-box" name='searchValue' >
            <button id="searchButton" type="submit">Click to search</button>
            <span class="fa fa-search"></span>
        </form>
    <?php endif; ?>
    <nav class="nav">
        <?php if(auth()->guard()->guest()): ?>
        <ul class="nav__items">
            <li class="nav__item">
                <a class="btn btn-nav" href="#login">Log in</a>
            </li>
            <li class="nav__item">
                <a class="btn btn-nav" href="#aboutus">About us</a>
            </li>
            <li class="nav__item">
                <a class="btn btn-nav" href="#signup">Sign up</a>
            </li>
        </ul>
        <?php else: ?>
        <ul class="nav__items">
            <li class="nav__item">
                <a class="btn btn-nav" href="<?php echo e(route('profile')); ?>">My profile</a>
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
</header>