<!DOCTYPE html>
<html>
    @include('includes.head')
    <body>
        @include('includes.header')
        
        
    <main>
    <div id="fullpage">
        <div class="section" id="section0">
            <section class="section__login" id="login">
                    <div class="container__box">
                        <h2 class="heading-landing">Photogram</h2>
@yield('content')
                    </div>
                </section>
            </div>
            
            <div class="section" id="section1">
                <div class="content">
                    <section class="section__about" id="about">
                        <div class="container__box"><h2 class="heading-landing">Abouts Photogram</h2>
                            <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
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