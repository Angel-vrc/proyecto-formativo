<div class="mt-3">
    <div class="display-4">
        Inactivar tanque
    </div>

    <div class="mt-4">
        <?php while($tanque = pg_fetch_assoc($tanques)){ ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar al tanque <strong><?php echo $tanque['nombre']; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>Tipo de tanque: </strong> <?php echo $tanque['tipo_tanque']; ?>
                </li>
                <li class="list-group-item">
                    <strong>cantidad de peces: </strong> <?php echo $tanque['cantidad_peces']; ?>
                </li>
                <li class="list-group-item">
                    <strong>Medidas del tanque: </strong> <?php echo $tanque['medidas']; ?>
                </li>
                <li class="list-group-item">
                    <strong>estado actual: </strong> <?php echo $tanque['estado']; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Tanques","Tanque","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $tanque['id']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Tanques","Tanque","lista"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>