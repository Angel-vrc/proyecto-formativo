<div class="mt-3">
    <div class="display-4">
        Inactivar Tipo de Actividad
    </div>

    <div class="mt-4">
        <?php 
            while($tipo_actividad_data = pg_fetch_assoc($tipo_actividad)){
                $nombre = isset($tipo_actividad_data['nombre']) ? $tipo_actividad_data['nombre'] : 'N/A';
                $estado_nombre = isset($tipo_actividad_data['estado_nombre']) ? $tipo_actividad_data['estado_nombre'] : 'N/A';
        ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar el tipo de actividad <strong><?php echo $nombre; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>Nombre:</strong> <?php echo $nombre; ?>
                </li>
                <li class="list-group-item">
                    <strong>Estado actual:</strong> <?php echo $estado_nombre; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Tipo_actividad","Tipoactivida","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $tipo_actividad_data['id']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Tipo_actividad","Tipoactivida","list"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>

