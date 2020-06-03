<?php
    $path = substr($_SERVER['PHP_SELF'], 0, 9);
?>
<header>    
    <!-- Header Start -->
    <div class="header-area header-transparent" style="background-color: #212529">
        <div class="main-header">
            <div class="header-bottom  header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <div class="logo">
                                <a href="landingpage.php"><img src="assets/img/logo/logo.png" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-8">
                            <!-- Main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">                                       
                                        <li><a href="#"><?php echo $language['language'] ?></a>
                                            <ul class="submenu">
                                                <li><a href="javascript:changeLanguage('pt')">Português</a></li>
                                                <li><a href="javascript:changeLanguage('en')">English</a></li>
                                                <li><a href="javascript:changeLanguage('fr')">Français</a></li>
                                            </ul>
                                        </li>               
                                        <li><a href="<?php echo $path.'landingpage.php' ?>"><?php echo $language['home'] ?></a></li>
                                        <li><a href="<?php echo $path.'about.php' ?>"><?php echo $language['about'] ?></a></li>

                                        <?php 
                                        
                                        if(!isset($_SESSION['id'])){ ?>
                                        <li id="signin" class="login"><a href="<?php echo $path.'Login_Registo/formLogin.php' ?>">
                                            <i class="ti-user"></i><?php echo $language['signin'] ?></a>
                                        </li>
                                        <li class="login"><a href="<?php echo $path.'Login_Registo/formRegister.php' ?>">
                                            <i class="ti-user"></i><?php echo $language['register'] ?></a>
                                        </li>
                                        <?php  }else{ ?>
                                        <li class="login"><a href="<?php echo $path.'Userpages/profilepage.php' ?>">
                                            <i class="ti-user"></i><?php echo $language['me'] ?></a>
                                        </li>
                                        <li class="login"><a href="<?php echo $path.'Login_Registo/logout.php' ?>">
                                            <i class="ti-user"></i><?php echo $language['signout'] ?></a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>