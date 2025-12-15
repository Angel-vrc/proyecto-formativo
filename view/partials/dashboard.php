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
	
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
    <div>
        <h1 class="fw-bold mb-3">Hola, <?php echo $_SESSION['nombre']; ?></h1>
        <h6 class="op-7 mb-2"><?php echo $_SESSION['usuario_rol_nombre']; ?></h6>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <img src="assets/img/zancudo_hola.png" alt="GeoControl" class="navbar-brand" height="300">
    </div>

    <div class="col-6">
        <h1 class="fw-bold mb-3">Bienvenido al Sistema de Informacion Geografico GeoControl</h1>
        <h6 class="op-7 mb-2"><?php echo $_SESSION['usuario_rol_nombre']; ?></h6>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body ">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Visitors</p>
                            <h4 class="card-title">1,294</h4>
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
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Subscribers</p>
                            <h4 class="card-title">1303</h4>
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
                            <i class="fas fa-luggage-cart"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Sales</p>
                            <h4 class="card-title">$ 1,345</h4>
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
                            <i class="far fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Order</p>
                            <h4 class="card-title">576</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>