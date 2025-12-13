<div class="page-inner">

    <a href="<?php echo getUrl("Usuarios","Usuario","lista") ?>" class="btn btn-primary btn-round" >
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Registrar Nuevo Usuario</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Usuario</div>
                </div>
                <form id="formZoocriadero" method="POST" action="<?php echo getUrl("Usuarios","Usuario","postCreate") ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <!-- Nombre -->
                                <div class="form-group">
                                    <label for="nombre">Nombre del Usuario *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           placeholder="Ej: Juan" required
                                           maxlength="150">
                                </div>

                                <!-- Apellido -->
                                <div class="form-group">
                                    <label for="nombre">Apellido del Usuario *</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" 
                                           placeholder="Ej: Rodriguez" required
                                           maxlength="150">
                                </div>
                                
                                <!-- Documento -->
                                <div class="form-group">
                                    <label for="documento">Documento *</label>
                                    <input type="text" class="form-control" id="documento" name="documento" 
                                           placeholder="Ej: 123456789" required
                                           maxlength="200">                                    
                                </div>    
                            </div>
                                
                            <div class="col-md-6">

                                <!-- Correo -->
                                <div class="form-group">
                                    <label for="correo">Correo Electrónico *</label>
                                    <input type="email" class="form-control" id="correo" name="correo" 
                                           placeholder="ejemplo@dominio.com" required
                                           maxlength="100">
                                </div>

                                <!-- Teléfono -->
                                <div class="form-group">
                                    <label for="telefono">Teléfono *</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" 
                                           placeholder="Ej: 3001234567" required
                                           pattern="[0-9]{7,20}" maxlength="20">                                    
                                </div>                                                                                       

                                <!-- Rol -->
                                <div class="form-group">
                                    <label for="rol">Rol *</label>
                                    <select class="form-control select2" id="rol" name="rol" required> 
                                        <?php while($rol = pg_fetch_assoc($roles)){ ?>
                                            <option value="<?php echo $rol['id']; ?>">
                                                <?php echo $rol['nombre']; ?>
                                            </option>
                                        <?php } ?>                                     
                                    </select>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" value="Registrar" class="btn btn-success">
                        <a href="<?php echo getUrl("Usuarios","Usuario","lista") ?>" class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>