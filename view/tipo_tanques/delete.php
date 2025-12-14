<div class="mt-3">
    <div class="display-4">
        Inactivar Tipo de tanque
    </div>

    <div class="mt-4">
        <?php while($tiestado = pg_fetch_assoc($tipoestados)){ ?>
            <div class="alert alert-warning">
                ¿Seguro que desea inactivar El tipo de tanque <strong><?php echo $tiestado['nombre']; ?></strong>?
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <strong>estado del tipo de tanque: </strong> <?php echo $tiestado['estado']; ?>
                </li>
            </ul>
            <form action="<?php echo getUrl("Tipo_tanques","Tipotanque","postDelete"); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $tiestado['id']; ?>">
                <button type="submit" class="btn btn-danger me-2">Confirmar</button>
                <a href="<?php echo getUrl("Tipo_tanques","Tipotanque","lista"); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</div>