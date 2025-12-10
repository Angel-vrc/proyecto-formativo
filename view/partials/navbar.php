<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">

            <a href="index.html" class="logo">
                <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20">
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
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">

        <div class="container-fluid">

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                    </a>
                    <div class="dropdown-menu quick-actions animated fadeIn">
                        <div class="quick-actions-header">
                            <span class="title mb-1">Acciones Rapidas</span>
                            <span class="subtitle op-7">Atajos</span>
                        </div>
                        <div class="quick-actions-scroll scrollbar-outer">
                            <div class="quick-actions-items">
                                <div class="row m-0">
                                    <a class="col-6 col-md-4 p-0" href="<?php echo getUrl("Seguimiento","Seguimiento","getCreate"); ?>">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-danger rounded-circle">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                            <span class="text">Nuevo Seguimiento</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-warning rounded-circle">
                                                <i class="fas fa-map"></i>
                                            </div>
                                            <span class="text">Mapa</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-info rounded-circle">
                                                <i class="fas fa-file-excel"></i>
                                            </div>
                                            <span class="text">Reportes</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="#">
                                        <div class="quick-actions-item">
                                            <div class="avatar-item bg-success rounded-circle">
                                                <i class="fas fa-cog"></i>
                                            </div>
                                            <span class="text">Configuracion</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hola,</span> <span class="fw-bold"><?php 
                            echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : htmlspecialchars($_SESSION['usuario']); ?></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg"><img src="assets/img/profile.jpg" alt="image profile" class="avatar-img rounded"></div>
                                    <div class="u-text">
                                        <h4><?php
                                        echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : htmlspecialchars($_SESSION['usuario']); ?></h4>
                                        <p class="text-muted"><?php echo isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Usuario'; ?></p><a href="<?php echo getUrl('Perfil', 'Perfil', 'view'); ?>" class="btn btn-xs btn-secondary btn-sm">Ver Perfil</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo getUrl('Login', 'Login', 'cerrarSesion'); ?>">Cerrar Sesion</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>   
        </div>
    </nav>
    <!-- End Navbar -->
</div>