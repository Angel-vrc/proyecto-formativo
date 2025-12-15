<div class="mt-3">
    <div class="display-4">
        Inactivar Zoocriadero
    </div>

    <div class="mt-4">
        <?php while($zoo = pg_fetch_assoc($zoocriadero)){ ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar al zoo <strong><?php echo $zoo['nombre']; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>Direccion: </strong> <?php echo $zoo['direccion']; ?>
                </li>
                <li class="list-group-item">
                    <strong>Encargado: </strong> <?php echo $zoo['responsable_nombre']." ".$zoo['responsable_apellido']; ?>
                </li>
                <li class="list-group-item">
                    <strong>Estado actual: </strong> <?php echo $zoo['estado_nombre']; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Zoocriaderos","Zoocriadero","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $zoo['id_zoocriadero']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","lista"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>