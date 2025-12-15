<div class="mt-3">
    <div class="display-4">
        Inactivar Tipo de Tanque
    </div>

    <div class="mt-4">
        <?php 
            while($tipo_tanque_data = pg_fetch_assoc($tipo_tanque)){
                $nombre = isset($tipo_tanque_data['nombre']) ? $tipo_tanque_data['nombre'] : 'N/A';
                $estado_nombre = isset($tipo_tanque_data['estado_nombre']) ? $tipo_tanque_data['estado_nombre'] : 'N/A';
        ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar el tipo de tanque <strong><?php echo $nombre; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>Nombre:</strong> <?php echo $nombre; ?>
                </li>
                <li class="list-group-item">
                    <strong>Estado actual:</strong> <?php echo $estado_nombre; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Tipo_tanques","Tipotanque","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $tipo_tanque_data['id']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Tipo_tanques","Tipotanque","lista"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>
