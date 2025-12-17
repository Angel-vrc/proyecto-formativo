<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body ">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-fish"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Zoocriaderos</p>
                            <h4 class="card-title"><?php echo isset($datos_dashboard['total_zoocriaderos']) ? number_format($datos_dashboard['total_zoocriaderos']) : '0'; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                             <i class="fas fa-tint"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Tanques</p>
                            <h4 class="card-title"><?php echo isset($datos_dashboard['total_tanques']) ? number_format($datos_dashboard['total_tanques']) : '0'; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                           <i class="fas fa-fish"></i>
                            <i class="fas fa-venus"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Hembras</p>
                            <h4 class="card-title"><?php echo isset($datos_dashboard['total_hembras']) ? number_format($datos_dashboard['total_hembras']) : '0'; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                            <i class="fas fa-fish"></i>
                            <i class="fas fa-mars"></i>

                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Machos</p>
                            <h4 class="card-title"><?php echo isset($datos_dashboard['total_machos']) ? number_format($datos_dashboard['total_machos']) : '0'; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(isset($_SESSION['success'])): ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<i class="fas fa-check-circle"></i> <?php echo ($_SESSION['success']); unset($_SESSION['success']); ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		</button>
	</div>
<?php endif; ?>

<?php if(isset($_SESSION['error_helpers'])): ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<i class="fas fa-exclamation-circle"></i> <?php echo ($_SESSION['error_helpers']); unset($_SESSION['error_helpers']); ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		</button>
	</div>
<?php endif; ?>
	
<style>
    .welcome-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    
    .welcome-text {
    flex: 1;
    min-width: 300px;
    padding-right: 30px;
    padding-left: 30px; 
    }

    
    .welcome-image {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        min-width: 300px;
    }
    
    .welcome-image img {
        max-height: 500px;
        width: auto;
        object-fit: contain;
    }
    
    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
    }
    
    .welcome-subtitle {
        font-size: 1rem;
        opacity: 0.7;
        margin-bottom: 20px;
        color: #666;
    }
    
    @media (max-width: 768px) {
        .welcome-content {
            flex-direction: column;
        }
        
        .welcome-text {
            padding-right: 0;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .welcome-title {
            font-size: 1.5rem;
            text-align: left;
        }
        
        .welcome-image img {
            max-height: 350px;
        }
    }
</style>

<div class="row mt-4">
    <div class="col-12">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h2 class="fw-bold mb-2">
                            <i class="fas fa-user-circle me-2"></i>Hola, <?php echo $_SESSION['nombre']; ?>
                        </h2>
                        <p class="mb-3" style="color: #666;">
                            <i class="fas fa-briefcase me-2"></i><?php echo $_SESSION['usuario_rol_nombre']; ?>
                        </p>
                        <br><br>
                        <h1 class="welcome-title">Bienvenido al Sistema de Información Geográfico GeoControl</h1>
                        <p class="welcome-subtitle">
                            <i class="fas fa-map-marked-alt me-2"></i>
                            Sistema de gestión y control geográfico para el monitoreo y seguimiento de información sobre los Zoocriaderos
                        </p>
                        <div class="mt-4">
                            <a href="<?php echo getUrl("Configuracion","Configuracion","listManuales"); ?>" class="btn btn-outline-primary btn-lg" style="border-radius: 10px;">
                                <i class="fas fa-book me-2"></i>Ver Documentación
                            </a>
                        </div>
                    </div>
                    <div class="welcome-image">
                        <img src="assets/img/zancudo_hola.png" alt="GeoControl" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

