<div class="mt-3">
    <div class="display-4">
        Inactivar Seguimiento
    </div>

    <div class="mt-4">
        <?php while($seg = pg_fetch_assoc($seguimiento)){ 
            $nombre_actividad = isset($seg['nombre_actividad']) && $seg['nombre_actividad'] ? $seg['nombre_actividad'] : 'N/A';
            $nombre_estado = isset($seg['nombre_estado']) && $seg['nombre_estado'] ? $seg['nombre_estado'] : 'N/A';
        ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar el seguimiento con actividad <strong><?php echo $nombre_actividad; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>Actividad:</strong> <?php echo $nombre_actividad; ?>
                </li>
                <li class="list-group-item">
                    <strong>Estado actual:</strong> <?php echo $nombre_estado; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Seguimiento","Seguimiento","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $seg['id']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Seguimiento","Seguimiento","lista"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>