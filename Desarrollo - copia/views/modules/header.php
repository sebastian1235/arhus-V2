<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->

    <header class="main-header">

        <!-- Logo -->
        <a href="inicio" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>A</b>RHUS</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src="views/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message -->
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                </ul>
                                <!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- /.messages-menu -->

                    <!-- Notifications Menu -->
                    <!-- Tasks Menu -->
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="<?php echo $_SESSION["photo"];?>" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?php echo $_SESSION["nombre_tercero"];?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="<?php echo $_SESSION["photo"];?>" class="img-circle" alt="User Image">

                                <p>
                                    <?php echo $_SESSION["nombre_tercero"];?>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="salir" class="btn btn-default btn-flat">Salir</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

        <!--Div para el objecto content-->
    <div class="content-wrapper">
        <section class="content container-fluid">


