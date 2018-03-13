   <!-- Main Header -->
   <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="views/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $_SESSION["usuario"];?></p>
                    <!-- Status -->
                    <p><i class="fa fa-circle text-success"></i> Online</p>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <!-- Optionally, you can add icons to the links -->
                <li class="active"><a href="inicio"><i class="fa fa-link"></i> <span>Inicio</span></a></li>
                <li><a href="registroDet_venta"><i class="fa fa-link"></i> <span>Detalle de venta</span></a></li>
                <li class="treeview">
                    <a href="FregistroSol"><i class="fa fa-link"></i> <span>Registrar solicitud</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="TSolicitudes">Todos los registros</a></li>
                        <li><a href="FregistroSol">Registrar solicitud</a></li>
                        
                    </ul>
                </li>
                 <li class="treeview">
                    <a href="FregistroSol"><i class="fa fa-link"></i> <span>Parametros</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="Tasignacion">Asigancion</a></li>
                        <li><a href="registro_ciudad">Registrar solicitud</a></li>
                        <li><a href="Tcampanas">Campañas</a></li>
                        <li><a href="Titems">Items</a></li>
                        <li><a href="Tterceros">Items</a></li>
                        
                    </ul>
                <li><a href="perfil"><i class="fa fa-link"></i> <span>Perfiles</span></a></li>
                </li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>



