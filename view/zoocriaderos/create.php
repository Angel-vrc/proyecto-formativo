<div class="page-inner">

    <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","list") ?>" class="btn btn-primary btn-round" >
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Registrar Nuevo Zoocriadero</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Zoocriadero</div>
                </div>
                <form id="formZoocriadero" method="POST" action="<?php echo getUrl("Zoocriaderos","Zoocriadero","postCreate") ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nombre -->
                                <div class="form-group">
                                    <label for="nombre">Nombre del Zoocriadero *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           placeholder="Ej: Zoocriadero Las Acacias" required
                                           maxlength="150">
                                </div>
                                
                                <!-- Dirección -->
                                <div class="form-group">
                                    <label for="direccion">Dirección *</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" 
                                           placeholder="Ej: Calle 123 #45-67" required
                                           maxlength="200">
                                    <small class="form-text text-muted">Transversal, carrera, calle, diagonal</small>
                                </div>
                                
                                <!-- Comuna -->
                                <div class="form-group">
                                    <label for="comuna">Comuna *</label>
                                    <select class="form-control select2" id="comuna" name="comuna" required>
                                        <option value="">Seleccione una comuna</option> 
                                        <?php foreach ($comunas as $comuna): ?>
                                            <option value="<?php echo $comuna; ?>">
                                                <?php echo $comuna; ?>
                                            </option>
                                        <?php endforeach; ?>                                     
                                    </select>
                                </div>
                                
                                <!-- Barrio -->
                                <div class="form-group">
                                    <label for="barrio">Barrio *</label>
                                    <select class="form-control select2" id="barrio" name="barrio" required>                                             
                                        <option value="">Seleccione un Barrio</option> 
                                        <?php foreach ($barrios as $barrio): ?>
                                            <option value="<?php echo $barrio; ?>">
                                                <?php echo $barrio; ?>
                                            </option>
                                        <?php endforeach; ?>                                     
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- Responsable -->
                                <div class="form-group">
                                    <label for="responsable">Responsable *</label>
                                    <select class="form-control select2" id="responsable" name="responsable" required> 
                                        <?php while($usuario = pg_fetch_assoc($usuarios)){ ?>
                                            <option value="<?php echo $usuario['id']; ?>">
                                                <?php echo $usuario['nombre']." ".$usuario['apellido']; ?>
                                            </option>
                                        <?php } ?>                                     
                                    </select>
                                </div>
                                
                                <!-- Teléfono -->
                                <div class="form-group">
                                    <label for="telefono">Teléfono *</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" 
                                           placeholder="Ej: 3001234567" required
                                           pattern="[0-9]{7,20}" maxlength="20">
                                    <small class="form-text text-muted">Solo números, mínimo 7 dígitos</small>
                                </div>
                                
                                <!-- Correo -->
                                <div class="form-group">
                                    <label for="correo">Correo Electrónico *</label>
                                    <input type="email" class="form-control" id="correo" name="correo" 
                                           placeholder="ejemplo@dominio.com" required
                                           maxlength="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" value="Registrar" class="btn btn-success">
                        <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","list") ?>" class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>