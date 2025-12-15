<?php 

class MapaController {

    public function visualizarZoo() {
        include_once "../../view/partials/content.php";
    }

    public function consultarZoocriadero() {
        $conn = pg_connect("host=localhost port=5432 dbname=Zoocriadero_B user=postgres password=12345");
        header('Content-Type: application/json');

        $dir1 = $_GET['x'];
        $dir2 = $_GET['y'];

        $sqlconsult = "SELECT id_zoocriadero, astext(geom) AS geom FROM zoocriadero";
        $queryConsult = pg_query($conn, $sqlconsult);
        $encontro = false;

        while ($resultado = pg_fetch_array($queryConsult)) {
        
            $astext = $resultado['geom'];
            $astext = str_replace(array('POINT(', ')'), '', $astext);
            list($astext_x, $astext_y) = explode(' ', $astext);
        
            $tol = 100;
        
            if (
                ($dir1 >= $astext_x - $tol && $dir1 <= $astext_x + $tol) &&
                ($dir2 >= $astext_y - $tol && $dir2 <= $astext_y + $tol)
            ) {
                $id = $resultado['id_zoocriadero'];
            
                $sql1 = "SELECT * FROM zoocriadero WHERE id_zoocriadero = $id";
                $query1 = pg_query($conn, $sql1);
                $array1 = pg_fetch_array($query1);
            
                echo "Punto encontrado\n";
                if ($row = pg_fetch_assoc($query)) {
                    echo json_encode($row);
                } else {
                    echo json_encode(['error' => 'No se encontraron zoocriaderos cercanos']);
                }
            
                $encontro = true;
                break;
            }
        }

        if (!$encontro) {
            echo json_encode(['error' => 'No se encontraron puntos cercanos']);
        }

        include_once "../../view/partials/content.php";
    }


}

?>