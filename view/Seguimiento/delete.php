<div class="mt-3">
    <div class="display-4">
        Inactivar Seguimiento
    </div>

    <div class="mt-4">
        <?php while($seg = pg_fetch_assoc($seguimiento)){ ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar el seguimiento con ID <strong><?php echo $seg['id']; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>ID Seguimiento:</strong> <?php echo $seg['id_seguimiento']; ?>
                </li>
                <li class="list-group-item">
                    <strong>ID Actividad:</strong> <?php echo $seg['id_actividad']; ?>
                </li>
                <li class="list-group-item">
                    <strong>Estado actual:</strong> <?php echo isset($seg['estado_id']) ? $seg['estado_id'] : 'N/A'; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Seguimiento","Seguimiento","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $seg['id']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Seguimiento","Seguimiento","list"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>

