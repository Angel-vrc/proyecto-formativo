<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Inactivar Actividad</h4>
    </div>

    <div class="mt-4">
        <?php 
            while($actividad_data = pg_fetch_assoc($actividad)){
                $nombre = isset($actividad_data['nombre']) ? $actividad_data['nombre'] : 'N/A';
                $estado_nombre = isset($actividad_data['estado_nombre']) ? $actividad_data['estado_nombre'] : 'N/A';
        ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar la actividad <strong><?php echo $nombre; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>Nombre:</strong> <?php echo $nombre; ?>
                </li>
                <li class="list-group-item">
                    <strong>Estado actual:</strong> <?php echo $estado_nombre; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Actividad","Activida","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $actividad_data['id']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Actividad","Activida","lista"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>
