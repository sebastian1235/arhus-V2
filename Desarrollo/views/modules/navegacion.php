 <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo $_SESSION["photo"];?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $_SESSION["usuario"];?></p>
                    <p><i class="fa fa-circle text-success"></i> Online</p>
                </div>
            </div>
>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="active"><a href="inicio"><i class="glyphicon glyphicon-chevron-right"></i> <span>Inicio</span></a></li>
               <!-- <li><a href="registroDet_venta"><i class="glyphicon glyphicon-chevron-right"></i> <span>Detalle de venta</span></a></li>-->
                <li class="treeview">
                    <a href="FregistroSol"><i class="glyphicon glyphicon-chevron-right"></i> <span>Registrar solicitud</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="TSolicitudes"><i class="glyphicon glyphicon-tag"></i>Todos los registros</a></li>
                        <li><a href="FregistroSol"><i class="glyphicon glyphicon-tag"></i>Registrar solicitud</a></li>
                        
                    </ul>
                </li>
                 <li class="treeview">
                    <a href="FregistroSol"><i class="glyphicon glyphicon-chevron-right"></i> <span>Parametros</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="Tasignacion"><i class="glyphicon glyphicon-tag"></i>Asignacion</a></li>
                        <li><a href="registro_ciudad"><i class="glyphicon glyphicon-tag"></i>Ciudad</a></li>
                        <li><a href="Tcampanas"><i class="glyphicon glyphicon-tag"></i>Campañas</a></li>
                        <li><a href="Titems"><i class="glyphicon glyphicon-tag"></i>Items</a></li>
                        <li><a href="Tterceros"><i class="glyphicon glyphicon-tag"></i>Terceros</a></li>
                        <li><a href="tipoInventario"><i class="glyphicon glyphicon-tag"></i>Tipo inventario</a></li>
                        <li><a href="tipoTercero"><i class="glyphicon glyphicon-tag"></i>Tipo tercero</a></li>
                        <li><a href="medioPago"><i class="glyphicon glyphicon-tag"></i>Medio pago</a></li>
                    </ul>
                <li><a href="perfil"><i class="glyphicon glyphicon-chevron-right"></i> <span>Usuarios</span></a></li>
                </li>
            </ul>
        </section>
    </aside>



