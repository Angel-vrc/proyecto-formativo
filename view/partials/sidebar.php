<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">

            <a href="index.php" class="logo">
                <img src="assets/img/logo.png" alt="GeoControl" class="navbar-brand" height="40">
                <span style="margin-left: 10px; color: #fff; font-weight: 600; font-size: 18px;">GeoControl</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>

        </div>
        <!-- End Logo Header -->	
    </div>	
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
       <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item <?php echo (!isset($_GET['modulo'])) ? 'active' : ''; ?>">    
                    <a href="index.php">
                        <i class="fas fa-map"></i>
                        <p>Visualización de Mapa</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Gestión del Sistema</h4>
                </li>
                <li class="nav-item <?php echo isActiveModule('Zoocriaderos'); ?>">
                    <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","list"); ?>">
                        <i class="fas fa-fish"></i>
                        <p>Gestión de Zoocriadero</p>                        
                    </a>
                </li>
                <li class="nav-item <?php echo isActiveModule('Tanques'); ?>">
                    <a href="<?php echo getUrl("Tanques","Tanque","list"); ?>">
                        <i class="fas fa-tint"></i>
                        <p>Gestión de Tanques</p>                        
                    </a>
                </li>
                <li class="nav-item <?php echo isActiveModule('Tipo_actividad'); ?>">
                    <a href="<?php echo getUrl("Tipo_actividad","Tipoactivida","list"); ?>">
                        <i class="fas fa-tint"></i>
                        <p> Tipo de Actividad</p>
                    </a>
                </li>
                <li class="nav-item <?php echo isActiveModule('Actividades'); ?>">
                    <a href="<?php echo getUrl("Actividades","Actividad","list"); ?>">
                        <i class="fas fa-tasks"></i>
                        <p>Gestión de Actividades</p>                        
                    </a>                    
                </li>
                <li class="nav-item <?php echo isActiveModule('Usuarios'); ?>">
                    <a href="<?php echo getUrl("Usuarios","Usuario","list"); ?>">
                        <i class="fas fa-users"></i>
                        <p>Gestión de Usuarios</p>                        
                    </a>
                </li>
                <li class="nav-item <?php echo isActiveModule('Seguridad'); ?>">
                    <a data-bs-toggle="collapse" href="#gestionSeguridad">
                        <i class="fas fa-lock"></i>
                        <p>Seguridad del Sistema</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="gestionSeguridad">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="<?php echo getUrl("Seguridad","Seguridad","listRoles"); ?>">
                                    <span class="sub-item">Roles</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo getUrl("Seguridad","Seguridad","listPermisos"); ?>">
                                    <span class="sub-item">Permisos</span>
                                </a>
                            </li>                            
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php echo isActiveModule('Reportes'); ?>">
                    <a data-bs-toggle="collapse" href="#reportes">
                        <i class="fas fa-chart-bar"></i>
                        <p>Reportes y Estadisticas</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="reportes">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="<?php echo getUrl("Reportes","Reporte","listNacidos"); ?>">
                                    <span class="sub-item">Peces nacidos y muertos</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo getUrl("Reportes","Reporte","listSeguimientos"); ?>">
                                    <span class="sub-item">Seguimiento de actividades</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo getUrl("Reportes","Reporte","listZoocriaderos"); ?>">
                                    <span class="sub-item">Reportes por zoocriadero</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php echo isActiveModule('Configuracion'); ?>">
                    <a data-bs-toggle="collapse" href="#configuracion">
                        <i class="fas fa-cogs"></i>
                        <p>Configuración</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="configuracion">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="<?php echo getUrl("Configuracion","Configuracion","listManuales"); ?>">
                                    <span class="sub-item">Manuales</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo getUrl("Configuracion","Configuracion","acercaDe"); ?>">
                                    <span class="sub-item">Acerca de nosotros</span>
                                </a>
                            </li>                            
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>