<div class="page-inner">
    <a href="<?php echo getUrl("Tipo_tanques","Tipotanque","lista") ?>" class="btn btn-primary">
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Registrar Nueva tipo de Tanque</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del tipo de Tanque</div>
                </div>
                <form id="formZoocriadero" method="POST" action="<?php echo getUrl("Tipo_tanques","Tipotanque","postCreate") ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nombre actividad -->
                                <div class="form-group">
                                    <label for="nombre">Nombre del tipo de Tanque</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           placeholder="Ej: Actividad de crias" required
                                           maxlength="150">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" value="Registrar" class="btn btn-success">
                        <a href="<?php echo getUrl("Tipo_tanques","Tipotanque","lista") ?>" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>