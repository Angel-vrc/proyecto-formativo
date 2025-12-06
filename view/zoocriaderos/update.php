<div class="page-inner">

    <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","list") ?>" class="btn btn-primary btn-round" >
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Actualizar Zoocriadero</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Zoocriadero</div>
                </div>
                <form id="formZoocriadero" method="POST" action="<?php echo getUrl("Zoocriaderos","Zoocriadero","postUpdate") ?>">
                    
                    <?php
                        $comunas = [
                            'Comuna 1', 'Comuna 2', 'Comuna 3', 'Comuna 4', 'Comuna 5',
                            'Comuna 6', 'Comuna 7', 'Comuna 8', 'Comuna 9', 'Comuna 10',
                            'Comuna 11', 'Comuna 12', 'Comuna 13', 'Comuna 14', 'Comuna 15',
                            'Comuna 16', 'Comuna 17', 'Comuna 18', 'Comuna 19', 'Comuna 20',
                            'Comuna 21', 'Comuna 22'
                        ];

                        while($zoo = pg_fetch_assoc($zoocriadero)){                                            
                    ?>

                    <input type="hidden" name="id" value="<?php echo $zoo['id']; ?>">
                    
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Nombre -->
                                    <div class="form-group">
                                        <label for="nombre">Nombre del Zoocriadero *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                            placeholder="Ej: Zoocriadero Las Acacias" required
                                            maxlength="150" value="<?php echo $zoo['nombre']?>">
                                        <small class="form-text text-muted">Nombre completo del establecimiento</small>
                                    </div>
                                    
                                    <!-- Dirección -->
                                    <div class="form-group">
                                        <label for="direccion">Dirección *</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" 
                                            placeholder="Ej: Calle 123 #45-67" required
                                            maxlength="200" value="<?php echo $zoo['direccion']?>">
                                    </div>
                                    
                                    <!-- Comuna -->
                                    <div class="form-group">
                                        <label for="comuna">Comuna *</label>
                                        <select class="form-control select2" id="comuna" name="comuna" required>
                                            <option value="">Seleccione una comuna</option> 
                                            <?php foreach ($comunas as $comuna): ?>
                                                <option value="<?php echo $comuna; ?>" 
                                                    <?php echo ($comuna == $zoo['comuna']) ? 'selected' : ''; ?>>
                                                    <?php echo $comuna; ?>
                                                </option>
                                            <?php endforeach; ?>                                     
                                        </select>
                                    </div>
                                    
                                    <!-- Barrio -->
                                    <div class="form-group">
                                        <label for="barrio">Barrio *</label>
                                        <input type="text" class="form-control" id="barrio" name="barrio" 
                                            placeholder="Ej: El Poblado, San Antonio" required
                                            maxlength="100" value="<?php echo $zoo['barrio']?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <!-- Responsable -->
                                    <div class="form-group">
                                        <label for="responsable">Responsable *</label>
                                        <input type="text" class="form-control" id="responsable" name="responsable" 
                                            placeholder="Nombre completo del responsable" required
                                            maxlength="150" value="<?php echo $zoo['responsable']?>">
                                    </div>
                                    
                                    <!-- Teléfono -->
                                    <div class="form-group">
                                        <label for="telefono">Teléfono *</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                                            placeholder="Ej: 3001234567" required
                                            pattern="[0-9]{7,20}" maxlength="20" value="<?php echo $zoo['telefono']?>">
                                        <small class="form-text text-muted">Solo números, mínimo 7 dígitos</small>
                                    </div>
                                    
                                    <!-- Correo -->
                                    <div class="form-group">
                                        <label for="correo">Correo Electrónico *</label>
                                        <input type="email" class="form-control" id="correo" name="correo" 
                                            placeholder="ejemplo@dominio.com" required
                                            maxlength="100" value="<?php echo $zoo['correo']?>">
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

                    <?php
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>