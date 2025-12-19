<footer class="footer" style="background: linear-gradient(135deg, #2c555a 0%, #1a5a5a 100%); color: #fff; margin-top: auto;">
    <div class="container-fluid">
        <div class="row py-4">
            <!-- Información del Sistema -->
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="footer-section">
                    <h5 class="mb-3" style="color: #fff; font-weight: 600;">
                        <i class="fas fa-fish me-2"></i>GeoControl
                    </h5>
                    <p class="mb-2" style="color: rgba(255,255,255,0.9); font-size: 14px;">
                        Sistema de Información Geográfico para la gestión integral de zoocriaderos.
                    </p>
                    <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 12px;">
                        <i class="fas fa-code me-1"></i> Versión 1.0.0
                    </p>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="footer-section">
                    <h5 class="mb-3" style="color: #fff; font-weight: 600;">
                        <i class="fas fa-envelope me-2"></i>Contacto
                    </h5>
                    <ul class="list-unstyled" style="font-size: 14px; color: rgba(255,255,255,0.9);">
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:soporte@geocontrol.gov.co" style="color: rgba(255,255,255,0.9); text-decoration: none;">
                                soporte@geocontrol.gov.co
                            </a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:+573178562312" style="color: rgba(255,255,255,0.9); text-decoration: none;">
                                +57 123 456 7890
                            </a>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span>Santiago de Cali, Colombia</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="col-md-4">
                <div class="footer-section">
                    <h5 class="mb-3" style="color: #fff; font-weight: 600;">
                        <i class="fas fa-info-circle me-2"></i>Información
                    </h5>
                    <ul class="list-unstyled" style="font-size: 14px;">
                        <li class="mb-2">
                            <a href="<?php echo getUrl("Configuracion","Configuracion","listManuales"); ?>" style="color: rgba(255,255,255,0.9); text-decoration: none; transition: color 0.3s;">
                                <i class="fas fa-question-circle me-2"></i>Ayuda
                            </a>
                        </li>
                        <!--<li class="mb-2">
                            <a href="#" style="color: rgba(255,255,255,0.9); text-decoration: none; transition: color 0.3s;">
                                <i class="fas fa-file-alt me-2"></i>Términos
                            </a>
                        </li>-->
                        <li class="mb-2">
                            <a href="<?php echo getUrl("Configuracion","Configuracion","acercaDe"); ?>" style="color: rgba(255,255,255,0.9); text-decoration: none; transition: color 0.3s;">
                                <i class="fas fa-shield-alt me-2"></i>Acerca de nosotros
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Copyright y Año -->
        <div class="row py-5">
            <div class="col-md-12 text-center text-md-end">
                <p class="mb-0" style="color: rgba(255,255,255,0.8); font-size: 13px;">
                    &copy; <?php echo date('Y'); ?> GeoControl - Sistema de Información Geográfico. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>

    <style>
        .footer a:hover {
            color: #fff !important;
            text-decoration: underline !important;
        }
        .footer-section h5 {
            border-bottom: 2px solid rgba(255,255,255,0.2);
            padding-bottom: 8px;
        }
    </style>
</footer>
