<div class="page-inner">
    <a href="<?php echo getUrl("Tanques","Tanque","lista") ?>" class="btn btn-primary btn-round">
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>

    <div class="page-header mt-3">
        <h4 class="page-title">Actualizar Tanque</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Tanque</div>
                </div>

                <form method="POST" action="<?php echo getUrl("Tanques","Tanque","postUpdate") ?>">
                    <!-- ID oculto -->
                    <input type="hidden" name="id" value="<?php echo $tanque['id'] ?>">

                    <div class="card-body">
                        <div class="row">

                            <!-- Columna izquierda -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre del Tanque *</label>
                                    <input type="text" class="form-control"
                                        name="nombre"
                                        value="<?php echo $tanque['nombre'] ?>"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>Medidas *</label>
                                    <input type="text" class="form-control"
                                        name="medidas"
                                        value="<?php echo $tanque['medidas'] ?>"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>zoocriadero *</label>
                                    <select class="form-control" name="id_zoocriadero" required>
                                        <option value="">Seleccione un Zoocriadero</option>
                                        <?php while($zoo = pg_fetch_assoc($zoocriaderos)){ ?>
                                            <option value="<?php echo $zoo['id_zoocriadero'] ?>"
                                                <?php if($zoo['id_zoocriadero'] == $tanque['id_zoocriadero']) echo "selected"; ?>>
                                                <?php echo $zoo['nombre'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    
                                </div>
                            </div>

                            <!-- Columna derecha -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de Tanque *</label>
                                    <select class="form-control" name="id_tipo_tanque" required>
                                        <option value="">Seleccione un tipo</option>
                                        <?php while($tipo = pg_fetch_assoc($tipos)){ ?>
                                            <option value="<?php echo $tipo['id'] ?>"
                                                <?php if($tipo['id'] == $tanque['id_tipo_tanque']) echo "selected"; ?>>
                                                <?php echo $tipo['nombre'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Cantidad de peces *</label>
                                    <input type="number" class="form-control"
                                        name="cantidad"
                                        value="<?php echo $tanque['cantidad_peces'] ?>"
                                        required>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                        <a href="<?php echo getUrl("Tanques","Tanque","lista") ?>" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
