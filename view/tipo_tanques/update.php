<div class="page-inner">
    <a href="<?php echo getUrl("Tipo_tanques","Tipotanque","lista") ?>"
       class="btn btn-primary btn-round">
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>

    <div class="page-header mt-3">
        <h4 class="page-title">Actualizar Tipo de tanque</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Tipo de Tanque</div>
                </div>

                <form method="POST"
                      action="<?php echo getUrl("Tipo_tanques","Tipotanque","postUpdate"); ?>">

                    <!-- ID oculto -->
                    <input type="hidden" name="id"
                           value="<?php echo $tipo_tanque['id']; ?>">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nombre -->
                                <div class="form-group">
                                    <label>Nombre del tipo de Tanque *</label>
                                    <input type="text"
                                           class="form-control"
                                           name="nombre"
                                           required
                                           maxlength="150"
                                           value="<?php echo $tipo_tanque['nombre']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-success">
                            Actualizar
                        </button>
                        <a href="<?php echo getUrl("Tipo_tanques","Tipotanque","lista") ?>"
                           class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>