<div class="mt-3">
    <div class="display-4">
        Inactivar Zoocriadero
    </div>

    <div class="mt-4">
        <div class="alert alert-warning">
            ¿Seguro que desea inactivar al rol <strong><?php echo $rol['nombre']; ?></strong>?
        </div>
        <ul class="list-group mb-4">
            <li class="list-group-item">
                <strong>Nombre: </strong> <?php echo $rol['nombre'] ?>
            </li>
            <li class="list-group-item">
                <strong>Estado actual: </strong> <?php echo $rol['estado_nombre']; ?>
            </li>
        </ul>
        <form action="<?php echo getUrl("Roles","Rol","postDelete"); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $rol['id']; ?>">
            <button type="submit" class="btn btn-danger me-2">Confirmar</button>
            <a href="<?php echo getUrl("Roles","Rol","lista"); ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>