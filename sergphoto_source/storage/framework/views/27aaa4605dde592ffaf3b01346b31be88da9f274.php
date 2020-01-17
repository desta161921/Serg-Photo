<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <title id="top">Photogram</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:100,400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/fullPage.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header class="header" >
            <div class="header__logo-box">
                <a href="#firstPage"><img src="img/v7.svg" alt="Logo" class="header__logo"></a>
                <a href="#firstPage"><h3 class="header__logo-text">Photogram</h3></a>
            </div>
            <nav class="nav">
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
            </nav>
        </header>
        
        
    <main>
    <div id="fullpage">
        <div class="section" id="section0">
            <section class="section__login" id="login">
                    <div class="container__box">
                        <h2 class="heading-landing">Photogram</h2>
<?php echo $__env->yieldContent('content'); ?>
                    </div>
                </section>
            </div>
            
            <div class="section" id="section1">
                <div class="content">
                    <section class="section__about" id="about">
                        <div class="container__box"><h2 class="heading-landing">About Photogram</h2>
                            <li>
                                        <a href="<?php echo e(route('logout')); ?>"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                            <?php echo e(csrf_field()); ?>

                                        </form>
                                    </li></div>
                    </section>
                </div>
            </div>
            
            <div class="section" id="section2">
                <section class="section__sign-up" id="register">
                    <div class="container__box">
                    <h2 class="heading-landing">Photogram</h2>
                        <form action="costa__login.php" class="form__login">
                            <div class="form-group">
                                <input type="text" placeholder="Enter username" class="form__login-text" required>
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Enter password" class="form__login-text" required>
                            </div>   
                            <div class="form-group">
                                <input type="password" placeholder="Confirm password" class="form__login-text" required>
                            </div>   
                            <div class="form-group">
                                <a class="btn btn-primary" href="profile.html">Create account</a>
                            </div>
                        </form>
                    </div>
                    
                    <footer class="footer">
                     <div class="footer-text">
                         <h3>Made by Photogram &copy; | All rights reserved 2018.</h3>
                     </div>   
                </footer>
                </section>
            </div>
      </main>
    </div>
    <script type="text/javascript" src="js/fullPage.min.js"></script>
    <script type="text/javascript" src="js/fullPageInit.js"></script>
    <script type="text/javascript" src="js/slideShow.js"></script>
    </body>
</html>