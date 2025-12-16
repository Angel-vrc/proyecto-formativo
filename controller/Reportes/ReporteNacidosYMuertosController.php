<?php

    include_once '../model/Reportes/ReportesNacidosYMuertosModel.php';

    class ReporteNacidosYMuertosController{

        public function listNacidosYMuertos(){

            $obj = new ReporteNacidosYMuertosModel();


            $fechaDesde = isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : null;
            $fechaHasta = isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : null;

            $where = "WHERE (sd.num_alevines > 0 OR sd.num_muertes > 0)";


            if (!empty($fechaDesde)) {
                $where .= " AND s.fecha >= '$fechaDesde'";
            }

            if (!empty($fechaHasta)) {
                $where .= " AND s.fecha <= '$fechaHasta'";
            }

            $sql = "SELECT sd.*, 
                        s.fecha as fecha_seguimiento,
                        COALESCE(sd.num_alevines, 0) as nacidos,
                        COALESCE(sd.num_muertes, 0) as muertos
                    FROM seguimiento_detalle sd
                    LEFT JOIN seguimiento s ON sd.id_seguimiento = s.id
                    $where
                    ORDER BY s.fecha ASC, sd.id ASC";

            $nacidosYMuertos = $obj->select($sql);

            $sql_estadisticas = "SELECT 
                                    TO_CHAR(s.fecha, 'YYYY-MM') as mes,
                                    TO_CHAR(s.fecha, 'Month YYYY') as mes_nombre,
                                    SUM(COALESCE(sd.num_alevines, 0)) as total_nacidos,
                                    SUM(COALESCE(sd.num_muertes, 0)) as total_muertos
                                FROM seguimiento_detalle sd
                                LEFT JOIN seguimiento s ON sd.id_seguimiento = s.id
                                $where
                                GROUP BY TO_CHAR(s.fecha, 'YYYY-MM'),
                                        TO_CHAR(s.fecha, 'Month YYYY')
                                ORDER BY TO_CHAR(s.fecha, 'YYYY-MM') ASC";

            $estadisticas = $obj->select($sql_estadisticas);

            include_once '../view/Reportes/listNacidosYMuertos.php';
        }



        public function exportarExcel() {
            // Limpiar cualquier output anterior
            while (ob_get_level()) {
                ob_end_clean();
            }

            $obj = new ReporteNacidosYMuertosModel();

            $fechaDesde = isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : null;
            $fechaHasta = isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : null;

            $where = "WHERE (sd.num_alevines > 0 OR sd.num_muertes > 0)";

            if (!empty($fechaDesde)) {
                $where .= " AND s.fecha >= '$fechaDesde'";
            }

            if (!empty($fechaHasta)) {
                $where .= " AND s.fecha <= '$fechaHasta'";
            }

            $sql = "SELECT sd.*, 
                           s.fecha as fecha_seguimiento,
                           COALESCE(sd.num_alevines, 0) as nacidos,
                           COALESCE(sd.num_muertes, 0) as muertos
                    FROM seguimiento_detalle sd
                    LEFT JOIN seguimiento s ON sd.id_seguimiento = s.id
                    $where
                    ORDER BY s.fecha ASC, sd.id ASC";

            $nacidosYMuertos = $obj->select($sql);

            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=reporte_nacidos_y_muertos_" . date('Y-m-d') . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");

            // BOM para UTF-8
            echo "\xEF\xBB\xBF";
            
            echo "<table border='1'>";
            echo "<tr>
                    <th>Fecha</th>
                    <th>Nacidos (Alevines)</th>
                    <th>Muertos</th>
                  </tr>";

            if ($nacidosYMuertos && pg_num_rows($nacidosYMuertos) > 0) {
                while ($reg = pg_fetch_assoc($nacidosYMuertos)) {
                    $fecha = $reg['fecha_seguimiento'] ? date('d/m/Y', strtotime($reg['fecha_seguimiento'])) : 'N/A';
                    
                    echo "<tr>
                            <td>{$fecha}</td>
                            <td>{$reg['nacidos']}</td>
                            <td>{$reg['muertos']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>No hay registros de nacidos y muertos</td></tr>";
            }

            echo "</table>";

            exit; 
        }
    }