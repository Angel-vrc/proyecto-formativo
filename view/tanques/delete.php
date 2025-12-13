<div class="mt-3">
    <div class="display-4">
        Inactivar Tanque
    </div>

    <div class="mt-4">
        <?php 
            while($tanque_data = pg_fetch_assoc($tanque)){
                $nombre = isset($tanque_data['nombre']) ? $tanque_data['nombre'] : 'N/A';
                $tipo_tanque = isset($tanque_data['tipo_tanque_nombre']) ? $tanque_data['tipo_tanque_nombre'] : 'N/A';
                $medidas = isset($tanque_data['medidas']) ? $tanque_data['medidas'] : 'N/A';
                $cantidad_peces = isset($tanque_data['cantidad_peces']) ? $tanque_data['cantidad_peces'] : 'N/A';
                $estado_nombre = isset($tanque_data['estado_nombre']) ? $tanque_data['estado_nombre'] : 'N/A';
        ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar el tanque <strong><?php echo $nombre; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>Nombre:</strong> <?php echo $nombre; ?>
                </li>
                <li class="list-group-item">
                    <strong>Tipo de Tanque:</strong> <?php echo $tipo_tanque; ?>
                </li>
                <li class="list-group-item">
                    <strong>Medidas:</strong> <?php echo $medidas; ?>
                </li>
                <li class="list-group-item">
                    <strong>Cantidad de Peces:</strong> <?php echo $cantidad_peces; ?>
                </li>
                <li class="list-group-item">
                    <strong>Estado actual:</strong> <?php echo $estado_nombre; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Tanques","Tanque","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $tanque_data['id']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Tanques","Tanque","lista"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>
