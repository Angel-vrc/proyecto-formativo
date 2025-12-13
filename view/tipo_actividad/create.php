<div class="page-inner">
    <a href="<?php echo getUrl("Tipo_actividad","Tipoactivida","list") ?>" class="btn btn-primary btn-round" >
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Registrar Nueva Actividad</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información de la Actividad</div>
                </div>
                <form id="formZoocriadero" method="POST" action="<?php echo getUrl("Tipo_actividad","Tipoactivida","postCreate") ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nombre actividad -->
                                <div class="form-group">
                                    <label for="nombre">Nombre de la Actividad *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           placeholder="Ej: Actividad de crias" required
                                           maxlength="150">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" value="Registrar" class="btn btn-success">
                        <a href="<?php echo getUrl("Tipo_actividad","Tipoactivida","list") ?>" class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>