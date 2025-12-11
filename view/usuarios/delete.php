<div class="mt-3">
    <div class="display-4">
        Inactivar Zoocriadero
    </div>

    <div class="mt-4">
        <div class="alert alert-warning">
            ¿Seguro que desea inactivar al usuario <strong><?php echo $usuario['nombre']; ?></strong>?
        </div>
        <ul class="list-group mb-4">
            <li class="list-group-item">
                <strong>Nombre: </strong> <?php echo $usuario['nombre'].$usuario['apellido']; ?>
            </li>
            <li class="list-group-item">
                <strong>Telefono: </strong> <?php echo $usuario['telefono']; ?>
            </li>
            <li class="list-group-item">
                <strong>Rol: </strong> <?php echo $usuario['rol_nombre']; ?>
            </li>
            <li class="list-group-item">
                <strong>Estado actual: </strong> <?php echo $usuario['estado_nombre']; ?>
            </li>
        </ul>
        <form action="<?php echo getUrl("Usuarios","Usuario","postDelete"); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
            <button type="submit" class="btn btn-danger me-2">Confirmar</button>
            <a href="<?php echo getUrl("Usuarios","Usuario","lista"); ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>