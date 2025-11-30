<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
    <div class="container-fluid">
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <!-- Quick Actions -->
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="quickActionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bolt"></i>
                        <span class="notification">Quick Actions</span>
                    </a>
                    <ul class="dropdown-menu quick-actions animated fadeIn" aria-labelledby="quickActionsDropdown">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-plus"></i>
                                <span>Nueva Actividad</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-chart-line"></i>
                                <span>Reporte Rápido</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Ver Mapa</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-tasks"></i>
                                <span>Tareas Pendientes</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog"></i>
                                <span>Configuración Rápida</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- User Profile -->
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img src="assets/img/profile.jpg" alt="image profile" class="avatar-img rounded">
                                </div>
                                <div class="u-text">
                                    <h4>Nombre Usuario</h4>
                                    <p class="text-muted">usuario@zoocriadero.com</p>
                                    <a href="profile.html" class="btn btn-xs btn-secondary btn-sm">Ver Perfil</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user-cog"></i>
                                Mi Cuenta
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog"></i>
                                Configuración
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-question-circle"></i>
                                Ayuda
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo getUrl('Login', 'Login', 'cerrarSesion'); ?>">
                                <i class="fas fa-power-off"></i>
                                Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>