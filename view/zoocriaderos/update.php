<div class="page-inner">

    <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","lista") ?>" class="btn btn-primary btn-round" >
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

                        while($zoo = pg_fetch_assoc($zoocriadero)){                                            
                    ?>

                    <input type="hidden" name="id" value="<?php echo $zoo['id_zoocriadero']; ?>">
                    
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
                                        <select class="form-control select2" id="barrio" name="barrio" required>                                             
                                            <?php foreach ($barrios as $barrio): ?>
                                                <option value="<?php echo $barrio; ?>" 
                                                    <?php echo ($barrio == $zoo['barrio']) ? 'selected' : ''; ?>>
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
                                                <option value="<?php echo $usuario['id']; ?>" 
                                                    <?php echo ($usuario['id'] == $zoo['responsable']) ? 'selected' : ''; ?>>
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

                                    <div class="form-group">
                                    <label for="nombre">Coordenadas *</label>
                                    <input type="text" class="form-control" id="coordenadas" name="coordenadas" 
                                           placeholder="Ej: 4.4512,-79.5321" required readonly
                                           maxlength="150" value="<?php echo $zoo['coordenadas'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <input type="submit" value="Registrar" class="btn btn-success">
                            <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","lista") ?>" class="btn btn-danger">
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