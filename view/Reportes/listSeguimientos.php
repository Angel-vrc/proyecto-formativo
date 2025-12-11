<!-- view/zoocriaderos/create.php -->
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Registrar Nuevo Zoocriadero</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="index.php">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="index.php?modulo=Zoocriaderos">Zoocriaderos</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Nuevo</a>
            </li>
        </ul>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Zoocriadero</div>
                </div>
                <form id="formZoocriadero" method="POST" action="<?php echo getUrl("Reportes","ReporteSeguimiento","postCreate") ?>">
                    <input type="hidden" name="funcion" value="crear">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nombre -->
                                <div class="form-group">
                                    <label for="nombre">Nombre del Zoocriadero *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           placeholder="Ej: Zoocriadero Las Acacias" required
                                           maxlength="150">
                                    <small class="form-text text-muted">Nombre completo del establecimiento</small>
                                </div>
                                
                                <!-- Dirección -->
                                <div class="form-group">
                                    <label for="direccion">Dirección *</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" 
                                           placeholder="Ej: Calle 123 #45-67" required
                                           maxlength="200">
                                </div>
                                
                                <!-- Comuna -->
                                <div class="form-group">
                                    <label for="comuna">Comuna *</label>
                                    <select class="form-control select2" id="comuna" name="comuna" required>
                                        <option value="">Seleccione una comuna</option>
                                        <option value="Comuna 1">Comuna 1</option>
                                        <option value="Comuna 2">Comuna 2</option>
                                        <option value="Comuna 3">Comuna 3</option>
                                        <option value="Comuna 4">Comuna 4</option>
                                        <option value="Comuna 5">Comuna 5</option>
                                        <option value="Comuna 6">Comuna 6</option>
                                        <option value="Comuna 7">Comuna 7</option>
                                        <option value="Comuna 8">Comuna 8</option>
                                        <option value="Comuna 9">Comuna 9</option>
                                        <option value="Comuna 10">Comuna 10</option>
                                        <!-- Agregar más comunas según necesidad -->
                                    </select>
                                </div>
                                
                                <!-- Barrio -->
                                <div class="form-group">
                                    <label for="barrio">Barrio *</label>
                                    <input type="text" class="form-control" id="barrio" name="barrio" 
                                           placeholder="Ej: El Poblado, San Antonio" required
                                           maxlength="100">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- Responsable -->
                                <div class="form-group">
                                    <label for="responsable">Responsable *</label>
                                    <input type="text" class="form-control" id="responsable" name="responsable" 
                                           placeholder="Nombre completo del responsable" required
                                           maxlength="150">
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
                                
                                <!-- Observaciones (opcional para futuras expansiones) -->
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" 
                                              rows="3" placeholder="Observaciones adicionales..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <a href="index.php?modulo=Zoocriaderos" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

