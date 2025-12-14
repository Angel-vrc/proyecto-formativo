<div class="mt-3">
    <div class="display-4">
        Inactivar Actividad
    </div>

    <div class="mt-4">
        <?php while($desactivado = pg_fetch_assoc($desactivo)){ ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar la actividad <strong><?php echo $desactivado['nombre']; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>estado de la actividad: </strong> <?php echo $desactivado['estado']; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Actividad","Activida","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $desactivado['id']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Actividad","Activida","lista"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>