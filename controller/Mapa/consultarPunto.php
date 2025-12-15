<?php
$conn = pg_connect("host=localhost port=5432 dbname=Zoocriadero_B user=postgres password=12345");

$dir1 = floatval($_GET['x']);
$dir2 = floatval($_GET['y']);

$sqlconsult = "SELECT id_zoocriadero, astext(geom) AS geom FROM zoocriadero";
$queryConsult = pg_query($conn, $sqlconsult);

$encontro = false;

while ($resultado = pg_fetch_array($queryConsult)) {

    $astext = $resultado['geom'];
    $astext = str_replace(array('POINT(', ')'), '', $astext);
    list($astext_x, $astext_y) = explode(' ', $astext);
    $astext_x = floatval($astext_x);
    $astext_y = floatval($astext_y);


    $tol = 600;

    if (
        ($dir1 >= $astext_x - $tol && $dir1 <= $astext_x + $tol) &&
        ($dir2 >= $astext_y - $tol && $dir2 <= $astext_y + $tol)
    ) {
        $id = $resultado['id_zoocriadero'];

        $sql1 = "SELECT * FROM zoocriadero WHERE id_zoocriadero = $id";
        $query1 = pg_query($conn, $sql1);
        $array1 = ($query1 !== false) ? pg_fetch_assoc($query1) : false;
        if ($query1 && $array1) {
            echo json_encode(array(
                "codigo" => $array1['id_zoo'],
                "nombre" => $array1['nombre'],
                "geom" => $array1['geom']
            ));  
            echo "Nombre: " . htmlspecialchars($array1['nombre']) . "<br>";
            echo "";
            echo "Coordenadas: " . htmlspecialchars($array1['astext']);
        } else {
            echo  "<script>alert('No se encontraron datos para el zoocriadero seleccionado');</script>";
        }


        $encontro = true;
        break;
    }
}

if (!$encontro) {
    echo "No se encontraron puntos cercanos";
}