<?php
$conn = pg_connect("host=localhost port=5432 dbname=pruebaReg user=postgres password=sena");

$dir1 = $_GET['x'];
$dir2 = $_GET['y'];

$sql = "SELECT id, astext(geom) FROM puntos";

$query = pg_query($sql);

while ($resultado = pg_fetch_array($query)) {
    $astext = $resultado['astext'];
    $astext_x = substr($astext, 6, 8);
    $arreglo = explode(" ", $astext);
    $astext_y = substr($arreglo[1], 0, 6);

    if (
        ((($dir1 >= $astext_x && $dir1 <= $astext_x + 500) ||
         ($dir1 <= $astext_x && $dir1 >= $astext_x - 500)) &&
         (($dir2 <= $astext_y && $dir2 >= $astext_y - 100) ||
         ($dir2 >= $astext_y && $dir2 <= $astext_y + 1000)))
    ) {

        $id = $resultado['id'];

        $sql1 = "SELECT id, nombre, ST_AsText(geom) AS geom FROM puntos WHERE id = " . $id;
        $query1 = pg_query($sql1);
        $array1 = pg_fetch_array($query1);

        echo json_encode(array(
            "codigo" => $array1['id'],
            "nombre" => $array1['nombre'],
            "geom" => $array1['geom']
        ));        
    }
}

?>