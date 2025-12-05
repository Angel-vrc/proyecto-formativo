<form action="<?php echo getUrl("Zoocriaderos","Zoocriadero","postDelete"); ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <button type="submit" class="btn btn-danger me-2">Confirmar</button>
</form>