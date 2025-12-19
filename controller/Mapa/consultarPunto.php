<?php
header('Content-Type: application/json;');
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

        $sql1 = "SELECT z.*, e.nombre nombre_estado, u.nombre nombre_responsable, u.apellido apellido_responsable 
                FROM zoocriadero z, usuarios u, zoocriadero_estado e 
                WHERE z.responsable = u.id AND z.id_estado = e.id_estado AND id_zoocriadero = $id
                ORDER BY z.id_zoocriadero ASC";

        $query1 = pg_query($conn, $sql1);
        $array1 = ($query1 !== false) ? pg_fetch_assoc($query1) : false;

        if ($query1 && $array1) {
            echo json_encode(array(
                "id_zoocriadero" => $array1['id_zoocriadero'],
                "nombre" => $array1['nombre'],
                "barrio" => $array1['barrio'],
                "comuna" => $array1['comuna'],
                "direccion" => $array1['direccion'],
                "nombre_responsable" => $array1['nombre_responsable'],
                "apellido_responsable" => $array1['apellido_responsable'],
                "correo" => $array1['correo'],
                "telefono" => $array1['telefono'],
                "coordenadas" => $array1['coordenadas'],
                "nombre_estado" => $array1['nombre_estado']
            )); 
        } else {
            echo "<script>alert('No se encontraron datos para el zoocriadero seleccionado');</script>";
        }

        $encontro = true;
        break;
    }
}

if (!$encontro) {
    echo "No se encontraron puntos cercanos";
}