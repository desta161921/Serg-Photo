 <header class="header" >
            <div class="header__logo-box">
                <a href="#firstPage"><img src="img/v7.svg" alt="Logo" class="header__logo"></a>
                <a href="#firstPage"><h3 class="header__logo-text">Photogram</h3></a>
            </div>
            <?php if(auth()->guard()->guest()): ?>
            <?php else: ?>
                <form class="header__search" action="#" method="POST">
                    <input type="text" class="header__search-box" >
                    <span class="fa fa-search"></span>
                </form>
            <?php endif; ?>
            <nav class="nav">
                <?php if(auth()->guard()->guest()): ?>
                <ul class="nav__items">
                    <li class="nav__item">
                        <a class="btn btn-nav" href="#firstPage">Log in</a>
                    </li>
                    <li class="nav__item">
                        <a class="btn btn-nav" href="#secondPage">About us</a>
                    </li>
                    <li class="nav__item">
                        <a class="btn btn-nav" href="#3rdPage">Sign up</a>
                    </li>
                </ul>
                <?php else: ?>
                <ul class="nav__items">
                    <li class="nav__item">
                        <a class="btn btn-nav" href="#firstPage">Log in</a>
                    </li>
                    <li class="nav__item">
                        <a class="btn btn-nav" href="#secondPage">About us</a>
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