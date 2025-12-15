<?php

    include_once '../model/Reportes/ReporteZoocriaderoModel.php';

    class ReporteZoocriaderoController{

        public function listZoocriadero(){
            $obj = new ReporteZoocriaderoModel();
            $connect = $obj->getConnect();

            $paginacion = calcularPaginacion(10);

            $sqlBase = "SELECT z.*, 
                           e.nombre as nombre_estado, 
                           u.nombre as nombre_responsable, 
                           u.apellido as apellido_responsable 
                    FROM zoocriadero z
                    JOIN usuarios u ON z.responsable = u.id
                    JOIN zoocriadero_estado e ON z.id_estado = e.id_estado
                    ORDER BY z.id_zoocriadero ASC";

            $totalRegistros = obtenerTotalRegistros($connect, $sqlBase);

            $sql = aplicarPaginacionSQL($sqlBase, $paginacion['limite'], $paginacion['offset']);

            $zoocriaderos = $obj->select($sql);

            $parametros = array(
                'modulo' => isset($_GET['modulo']) ? $_GET['modulo'] : 'Reportes',
                'controlador' => isset($_GET['controlador']) ? $_GET['controlador'] : 'ReporteZoocriadero',
                'funcion' => isset($_GET['funcion']) ? $_GET['funcion'] : 'listZoocriadero'
            );

            $htmlPaginacion = generarPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina'], $parametros);
            $infoPaginacion = generarInfoPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina']);

            include_once '../lib/data/ubicacion.php';
            
            // Crear una consulta que muestre todas las comunas
            // Primero obtener los datos reales de la BD
            $sql_comunas_bd = "SELECT 
                                    z.comuna,
                                    COUNT(z.id_zoocriadero) as total_zoocriaderos
                                FROM zoocriadero z
                                WHERE z.comuna IS NOT NULL AND z.comuna != ''
                                GROUP BY z.comuna";
            
            $result_comunas_bd = $obj->select($sql_comunas_bd);
            $comunas_con_datos = array();
            if ($result_comunas_bd && pg_num_rows($result_comunas_bd) > 0) {
                while ($row = pg_fetch_assoc($result_comunas_bd)) {
                    $comunas_con_datos[$row['comuna']] = $row['total_zoocriaderos'];
                }
            }
            
            // Crear array con todas las comunas y sus conteos
            $estadisticas_array = array();
            foreach ($comunas as $comuna) {
                $total = isset($comunas_con_datos[$comuna]) ? intval($comunas_con_datos[$comuna]) : 0;
                $estadisticas_array[] = array(
                    'comuna' => $comuna,
                    'total_zoocriaderos' => $total
                );
            }
            
            $estadisticas = $estadisticas_array;
            include_once '../view/Reportes/listZoocriadero.php';
        }

        public function filtro() {
            $obj = new ReporteZoocriaderoModel();

            $comuna = isset($_GET['comuna']) ? trim($_GET['comuna']) : '';

            $where = array();

            if ($comuna !== '') {
                $comuna_escaped = pg_escape_string($obj->getConnect(), $comuna);
                $where[] = "z.comuna = '$comuna_escaped'";
            }

            $sql = "SELECT z.*, 
                           e.nombre as nombre_estado, 
                           u.nombre as nombre_responsable, 
                           u.apellido as apellido_responsable 
                    FROM zoocriadero z
                    JOIN usuarios u ON z.responsable = u.id
                    JOIN zoocriadero_estado e ON z.id_estado = e.id_estado";

            if (count($where) > 0) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            $sql .= " ORDER BY z.id_zoocriadero ASC";

            $zoocriaderos = $obj->select($sql);

            include_once '../view/Reportes/filtroZoocriadero.php';
        }
        

        public function exportarExcel() {
            // Limpiar cualquier output anterior
            while (ob_get_level()) {
                ob_end_clean();
            }

            $obj = new ReporteZoocriaderoModel();

            $comuna = isset($_GET['comuna']) ? $_GET['comuna'] : null;

            $where = array();

            if (!empty($comuna)) {
                $comuna_escaped = pg_escape_string($obj->getConnect(), $comuna);
                $where[] = "z.comuna = '$comuna_escaped'";
            }

            $sql = "SELECT z.*, 
                           e.nombre as nombre_estado, 
                           u.nombre as nombre_responsable, 
                           u.apellido as apellido_responsable 
                    FROM zoocriadero z
                    JOIN usuarios u ON z.responsable = u.id
                    JOIN zoocriadero_estado e ON z.id_estado = e.id_estado";

            if (count($where) > 0) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            $sql .= " ORDER BY z.id_zoocriadero ASC";

            $zoocriaderos = $obj->select($sql);

            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=reporte_zoocriaderos_" . date('Y-m-d') . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");

            // BOM para UTF-8
            echo "\xEF\xBB\xBF";
            
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
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No hay registros de zoocriaderos</td></tr>";
            }

            echo "</table>";

            exit; 
        }
    }
