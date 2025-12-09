<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Mi Perfil</h4>
    </div>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Usuario</div>
                </div>
                <div class="card-body" style="padding-top: 40px;">
                    <div class="row" style="margin-top: 0; margin-bottom: 40px;">
                        <div class="col-md-12">
                            <div class="profile-header" style="text-align: center;">
                                <div class="avatar-lg mx-auto" style="text-align: center;">
                                    <img src="assets/img/profile.jpg" alt="Imagen de perfil" class="avatar-img rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br><br>
                    
                    <form method="POST" action="<?php echo getUrl('Perfil', 'Perfil', 'postUpdate'); ?>">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-id-card" style="color: #1a5a5a; margin-right: 8px;"></i>
                                        <strong>Número de Documento</strong>
                                    </label>
                                <div class="form-control-plaintext" style="font-size: 16px; padding: 10px; background-color: #f8f9fa; border-radius: 8px;">
                                    <?php echo isset($usuario['documento']) ? htmlspecialchars($usuario['documento']) : 'N/A'; ?>
                                </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user" style="color: #1a5a5a; margin-right: 8px;"></i>
                                        <strong>Nombre Completo</strong>
                                    </label>
                                    <div class="form-control-plaintext" style="font-size: 16px; padding: 10px; background-color: #f8f9fa; border-radius: 8px;">
                                        <?php 
                                            $nombre_completo = '';
                                            if(isset($usuario['nombre']) && isset($usuario['apellido'])){
                                                $nombre_completo = trim($usuario['nombre'] . ' ' . $usuario['apellido']);
                                            } elseif(isset($usuario['nombre'])){
                                                $nombre_completo = $usuario['nombre'];
                                            } elseif(isset($usuario['apellido'])){
                                                $nombre_completo = $usuario['apellido'];
                                            }
                                            echo htmlspecialchars($nombre_completo ? $nombre_completo : 'N/A'); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="correo">
                                        <i class="fas fa-envelope" style="color: #1a5a5a; margin-right: 8px;"></i>
                                        <strong>Correo Electrónico</strong>
                                    </label>
                                    <input type="email" class="form-control" id="correo" name="correo" 
                                           value="<?php echo isset($usuario['correo']) ? htmlspecialchars($usuario['correo']) : ''; ?>" 
                                           placeholder="Ingrese su correo electrónico" required>
                                    <small class="form-text text-muted">Campo editable</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="telefono">
                                        <i class="fas fa-phone" style="color: #1a5a5a; margin-right: 8px;"></i>
                                        <strong>Teléfono</strong>
                                    </label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" 
                                           value="<?php echo isset($usuario['telefono']) ? htmlspecialchars($usuario['telefono']) : ''; ?>" 
                                           placeholder="Ingrese su teléfono" required>
                                    <small class="form-text text-muted">Campo editable</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-round">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <a href="index.php" class="btn btn-secondary btn-round">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

