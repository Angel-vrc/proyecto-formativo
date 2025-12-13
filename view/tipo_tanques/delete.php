<form action="<?php echo getUrl("Tipo_tanques","Tipotanque","postDelete"); ?>" method="post">
    <h1 class="text-center mt-3">¿Está seguro que desea eliminar este tipo de Tanque?</h1>
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <button type="submit" class="btn btn-danger me-2">Confirmar</button>
</form>