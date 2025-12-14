<?php

    include_once '../model/Reportes/ReporteZoocriaderoModel.php';

    class ReporteZoocriaderoController{

        public function listZoocriadero(){
            $obj = new ReporteZoocriaderoModel();

            $sql = "SELECT z.*, 
                           e.nombre as nombre_estado, 
                           u.nombre as nombre_responsable, 
                           u.apellido as apellido_responsable 
                    FROM zoocriadero z
                    JOIN usuarios u ON z.responsable = u.id
                    JOIN zoocriadero_estado e ON z.id_estado = e.id_estado
                    ORDER BY z.id_zoocriadero ASC";

            $zoocriaderos = $obj->select($sql);

            $sql_estadisticas = "SELECT 
                                    z.comuna,
                                    COUNT(z.id_zoocriadero) as total_zoocriaderos
                                FROM zoocriadero z
                                WHERE z.comuna IS NOT NULL AND z.comuna != ''
                                GROUP BY z.comuna
                                ORDER BY z.comuna ASC";

            $estadisticas = $obj->select($sql_estadisticas);

            include_once '../lib/data/ubicacion.php';
            include_once '../view/Reportes/listZoocriadero.php';
        }

        public function filtro() {
            $obj = new ReporteZoocriaderoModel();

            // Obtener filtros
            $comuna = isset($_GET['comuna']) ? trim($_GET['comuna']) : '';

            $where = array();

            // Filtro por comuna
            if ($comuna !== '') {
                $comuna_escaped = pg_escape_string($obj->getConnect(), $comuna);
                $where[] = "z.comuna = '$comuna_escaped'";
            }

            // SQL base
            $sql = "SELECT z.*, 
                           e.nombre as nombre_estado, 
                           u.nombre as nombre_responsable, 
                           u.apellido as apellido_responsable 
                    FROM zoocriadero z
                    JOIN usuarios u ON z.responsable = u.id
                    JOIN zoocriadero_estado e ON z.id_estado = e.id_estado";

            // Agregar WHERE dinámico si hay filtros
            if (count($where) > 0) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            $sql .= " ORDER BY z.id_zoocriadero ASC";

            $zoocriaderos = $obj->select($sql);

            include_once '../view/Reportes/filtroZoocriadero.php';
        }

        public function exportarExcel() {
            if (ob_get_length()) {
                ob_end_clean();
            }

            $obj = new ReporteZoocriaderoModel();

            $sql = "SELECT z.*, 
                           e.nombre as nombre_estado, 
                           u.nombre as nombre_responsable, 
                           u.apellido as apellido_responsable 
                    FROM zoocriadero z
                    JOIN usuarios u ON z.responsable = u.id
                    JOIN zoocriadero_estado e ON z.id_estado = e.id_estado
                    ORDER BY z.id_zoocriadero ASC";

            $zoocriaderos = $obj->select($sql);

            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=reporte_zoocriaderos_" . date('Y-m-d') . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");

            echo "<table border='1'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Comuna</th>
                    <th>Barrio</th>
                    <th>Responsable</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Estado</th>
                  </tr>";

            if ($zoocriaderos && pg_num_rows($zoocriaderos) > 0) {
                while ($zoo = pg_fetch_assoc($zoocriaderos)) {
                    echo "<tr>
                            <td>{$zoo['id_zoocriadero']}</td>
                            <td>{$zoo['nombre']}</td>
                            <td>{$zoo['direccion']}</td>
                            <td>{$zoo['comuna']}</td>
                            <td>{$zoo['barrio']}</td>
                            <td>{$zoo['nombre_responsable']} {$zoo['apellido_responsable']}</td>
                            <td>{$zoo['telefono']}</td>
                            <td>{$zoo['correo']}</td>
                            <td>{$zoo['nombre_estado']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center'>No hay registros de zoocriaderos</td></tr>";
            }

            echo "</table>";

            exit; 
        }
    }

?>

