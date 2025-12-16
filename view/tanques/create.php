<div class="page-inner">
    <a href="<?php echo getUrl("Tanques","Tanque","lista") ?>" class="btn btn-primary btn-round" >
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Registrar Nuevo Tanque</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Tanque</div>
                </div>
                <form id="formZoocriadero" method="POST" action="<?php echo getUrl("Tanques","Tanque","postCreate") ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nombre -->
                                <div class="form-group">
                                    <label for="nombre">Nombre del Tanque *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           placeholder="Ej: Tanque de crias" required
                                           maxlength="150">
                                    <small class="form-text text-muted">Nombre completo del establecimiento</small>
                                </div>
                                
                                <!-- Medidas -->
                                <div class="form-group">
                                    <label for="direccion">Medidas *</label>
                                    <input type="text" class="form-control" id="medidas" name="medidas" 
                                           placeholder="fondo 320 cm, altura 100 cm y ancho 100 cm" required
                                           maxlength="200">
                                </div>
                                <div class="form-group">
                                    <label for="tipo">Zoocriadero *</label>
                                    <select class="form-control select2" id="zoocriadero" name="id_zoocriadero" required>
                                        <option value="">Seleccione Zoocriadero</option>
                                        <?php
                                            while($zoo = pg_fetch_assoc($zoocriaderos)){
                                                echo "<option value='{$zoo['id_zoocriadero']}'>{$zoo['nombre']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Tipo de tanque -->
                                <div class="form-group">
                                    <label for="tipo">Tipo de Tanque *</label>
                                    <select class="form-control select2" id="tipo" name="id_tipo_tanque" required>
                                        <option value="">Seleccione un tipo de tanque</option>
                                        <?php
                                        while($tipo = pg_fetch_assoc($tipos)){
                                            echo "<option value='{$tipo['id']}'>{$tipo['nombre']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <br>
                                
                                <!-- cantidad de peces -->
                                <div class="form-group">
                                    <label for="barrio">Cantidad de peces *</label>
                                    <input type="text" class="form-control" id="cantidad" name="cantidad"
                                           placeholder="Ej: 320" required
                                           maxlength="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" value="Registrar" class="btn btn-success">
                        <a href="<?php echo getUrl("Tanques","Tanque","lista") ?>" class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>