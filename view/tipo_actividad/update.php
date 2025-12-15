<div class="page-inner">
    <a href="<?php echo getUrl("Tipo_actividad","Tipoactivida","list") ?>" 
       class="btn btn-primary btn-round">
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>

    <div class="page-header mt-3">
        <h4 class="page-title">Actualizar Tipo de Actividad</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Tipo de Actividad</div>
                </div>

                <form method="POST"
                      action="<?php echo getUrl("Tipo_actividad","Tipoactivida","postUpdate") ?>">

                    <!-- ID oculto -->
                    <input type="hidden" name="id"
                           value="<?php echo $tipo_actividad['id']; ?>">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nombre -->
                                <div class="form-group">
                                    <label>Nombre de la Actividad *</label>
                                    <input type="text"
                                           class="form-control"
                                           name="nombre"
                                           required
                                           maxlength="150"
                                           value="<?php echo $tipo_actividad['nombre']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-success">
                            Actualizar
                        </button>
                        <a href="<?php echo getUrl("Tipo_actividad","Tipoactivida","list") ?>"
                           class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>