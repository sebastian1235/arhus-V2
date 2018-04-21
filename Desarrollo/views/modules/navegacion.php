 <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo $_SESSION["photo"];?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $_SESSION["nombre_tercero"];?></p>
                    <p><i class="fa fa-circle text-success"></i> Online</p>
                </div>
            </div>
>
            <ul class="sidebar-menu" data-widget="tree">
                <li ><a href="inicio"><i class="glyphicon glyphicon-chevron-right"></i> <span>Inicio</span></a></li>
               
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
                    <a href="FregistroSol"><i class="glyphicon glyphicon-chevron-right"></i> <span>Cotizaciones</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="cotizacion"><i class="glyphicon glyphicon-tag"></i>Todos los registros</a></li>
                        
                        
                    </ul>
                </li>


                <?php
                if($_SESSION["tipo_tercero"] == 1) {
                    echo '
                    <li class="treeview" >
                    <a href = "FregistroSol" ><i class="glyphicon glyphicon-chevron-right" ></i > <span > Parametros</span >
                        <span class="pull-right-container" ><i class="fa fa-angle-left pull-right" ></i ></span >
                    </a >
                    <ul class="treeview-menu" >
                        <li ><a href = "tipoAsignacion" ><i class="glyphicon glyphicon-tag" ></i > Tipo Asignación </a ></li >
                        <li ><a href = "registroCiudad" ><i class="glyphicon glyphicon-tag" ></i > Ciudad</a ></li >
                        <li ><a href = "Tcampanas" ><i class="glyphicon glyphicon-tag" ></i > Campañas</a ></li >
                        <li ><a href = "Titems" ><i class="glyphicon glyphicon-tag" ></i > Items</a ></li >
                        <li ><a href = "tipoTercero" ><i class="glyphicon glyphicon-tag" ></i > Tipo tercero </a ></li >
                        <li ><a href = "medioPago" ><i class="glyphicon glyphicon-tag" ></i > Medio pago </a ></li >
                    </ul >
                 </li >';
                 }
                ?>





                <?php
                if($_SESSION["tipo_tercero"] == 1) {
                    echo '
                <li>
                    <a href="usuarioTercero"><i class="glyphicon glyphicon-chevron-right"></i> <span>Usuario Terceros</span></a></li>
                </li>
                    </ul>';
                }
                ?>

        </section>
    </aside>



