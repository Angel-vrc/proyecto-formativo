r<?php

    include_once '../model/Reportes/ReporteSeguimientoModel.php';

    

    class ReporteSeguimientoController{

        public function listSeguimientos(){
            $obj = new ReporteSeguimientoModel();

            $fechaDesde = isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : null;
            $fechaHasta = isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : null;
            $idZoocriadero = isset($_GET['id_zoocriadero']) ? $_GET['id_zoocriadero'] : null;

            $where = "WHERE NOT (
            sd.ph = 0 AND sd.temperatura = 0 AND sd.cloro = 0 
            AND sd.num_alevines = 0 AND sd.num_muertes = 0 
            AND sd.num_machos = 0 AND sd.num_hembras = 0 
             AND sd.total = 0
            )";

            if (!empty($fechaDesde)) {
                 $where .= " AND s.fecha >= '$fechaDesde'";
            }

            if (!empty($fechaHasta)) {
                 $where .= " AND s.fecha <= '$fechaHasta'";
            }

            if (!empty($idZoocriadero)) {
                 $where .= " AND s.id_zoo = $idZoocriadero";
            }


            $sql = "SELECT sd.*, 
                           a.nombre as nombre_actividad,
                           t.nombre as nombre_tanque,
                           tt.nombre as nombre_tipo_tanque,
                           s.fecha as fecha_seguimiento,
                           z.nombre as nombre_zoocriadero
                    FROM seguimiento_detalle sd
                    LEFT JOIN actividad a ON sd.id_actividad = a.id
                    LEFT JOIN seguimiento s ON sd.id_seguimiento = s.id
                    LEFT JOIN tanques t ON s.id_tanque = t.id
                    LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id
                    LEFT JOIN zoocriadero z ON s.id_zoo = z.id_zoocriadero
                    $where
                    ORDER BY s.fecha DESC, sd.id DESC";

            $seguimientos = $obj->select($sql);

            // Estadísticas
            $where_estadisticas = "WHERE NOT (sd.ph = 0 AND sd.temperatura = 0 AND sd.cloro = 0 AND sd.num_alevines = 0 AND sd.num_muertes = 0 AND sd.num_machos = 0 AND sd.num_hembras = 0 AND sd.total = 0)
                                   AND s.fecha IS NOT NULL";

            if (!empty($fechaDesde)) {
                $where_estadisticas .= " AND s.fecha >= '$fechaDesde'";
            }

            if (!empty($fechaHasta)) {
                $where_estadisticas .= " AND s.fecha <= '$fechaHasta'";
            }

            if (!empty($idZoocriadero)) {
                $where_estadisticas .= " AND s.id_zoo = $idZoocriadero";
            }


            $sql_estadisticas = "SELECT 
                                    TO_CHAR(s.fecha, 'YYYY-MM') as mes,
                                    TO_CHAR(s.fecha, 'Month YYYY') as mes_nombre,
                                    SUM(sd.num_alevines) as total_alevines,
                                    SUM(sd.num_hembras) as total_hembras,
                                    SUM(sd.num_machos) as total_machos,
                                    SUM(sd.num_muertes) as total_muertes
                                FROM seguimiento_detalle sd
                                LEFT JOIN seguimiento s ON sd.id_seguimiento = s.id
                                $where_estadisticas
                                GROUP BY TO_CHAR(s.fecha, 'YYYY-MM'), TO_CHAR(s.fecha, 'Month YYYY')
                                ORDER BY TO_CHAR(s.fecha, 'YYYY-MM') ASC";

            $estadisticas = $obj->select($sql_estadisticas);

            $sqlZoo = "SELECT id_zoocriadero, nombre FROM zoocriadero ORDER BY nombre";
            $zoocriaderos = $obj->select($sqlZoo);


            include_once '../view/Reportes/listSeguimientos.php';

        }





    public function exportarExcel() {
        // Limpiar cualquier output anterior
        while (ob_get_level()) {
            ob_end_clean();
        }

        $obj = new ReporteSeguimientoModel();

        $fechaDesde = isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : null;
        $fechaHasta = isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : null;
        $idZoocriadero = isset($_GET['id_zoocriadero']) ? $_GET['id_zoocriadero'] : null;
        $idTanque = isset($_GET['id_tanque']) ? $_GET['id_tanque'] : null;

        $where = "WHERE NOT (
                    sd.ph = 0 AND 
                    sd.temperatura = 0 AND 
                    sd.cloro = 0 AND 
                    sd.num_alevines = 0 AND 
                    sd.num_muertes = 0 AND 
                    sd.num_machos = 0 AND 
                    sd.num_hembras = 0 AND 
                    sd.total = 0
                )";

        if (!empty($fechaDesde)) {
            $where .= " AND s.fecha >= '$fechaDesde'";
        }

        if (!empty($fechaHasta)) {
            $where .= " AND s.fecha <= '$fechaHasta'";
        }

        if (!empty($idZoocriadero)) {
            $where .= " AND s.id_zoo = $idZoocriadero";
        }

        if (!empty($idTanque)) {
            $where .= " AND s.id_tanque = $idTanque";
        }

        $sql = "SELECT sd.*, 
                   a.nombre as nombre_actividad,
                   t.nombre as nombre_tanque,
                   tt.nombre as nombre_tipo_tanque,
                   s.fecha as fecha_seguimiento,
                   z.nombre as nombre_zoocriadero
            FROM seguimiento_detalle sd
            LEFT JOIN actividad a ON sd.id_actividad = a.id
            LEFT JOIN seguimiento s ON sd.id_seguimiento = s.id
            LEFT JOIN tanques t ON s.id_tanque = t.id
            LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id
            LEFT JOIN zoocriadero z ON s.id_zoo = z.id_zoocriadero
            $where
            ORDER BY s.fecha DESC, sd.id DESC";

        $seguimientos = $obj->select($sql);

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=reporte_seguimientos_" . date('Y-m-d') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // BOM para UTF-8
        echo "\xEF\xBB\xBF";
        
        echo "<table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Zoocriadero</th>
                <th>Tanque</th>
                <th>Actividad</th>
                <th>pH</th>
                <th>Temperatura</th>
                <th>Cloro</th>
                <th>Alevines</th>
                <th>Hembras</th>
                <th>Machos</th>
                <th>Muertes</th>
                <th>Total</th>
                <th>Observaciones</th>
              </tr>";

        if ($seguimientos && pg_num_rows($seguimientos) > 0) {
            while ($seg = pg_fetch_assoc($seguimientos)) {
                $fecha = $seg['fecha_seguimiento']
                    ? date('d/m/Y', strtotime($seg['fecha_seguimiento']))
                    : 'N/A';

                echo "<tr>
                        <td>{$seg['id']}</td>
                        <td>{$fecha}</td>
                        <td>{$seg['nombre_zoocriadero']}</td>
                        <td>{$seg['nombre_tanque']}</td>
                        <td>{$seg['nombre_actividad']}</td>
                        <td>{$seg['ph']}</td>
                        <td>{$seg['temperatura']}</td>
                        <td>{$seg['cloro']}</td>
                        <td>{$seg['num_alevines']}</td>
                        <td>{$seg['num_hembras']}</td>
                        <td>{$seg['num_machos']}</td>
                        <td>{$seg['num_muertes']}</td>
                        <td>{$seg['total']}</td>
                        <td>" . str_replace(array("\n", "\t"), ' ', $seg['observaciones']) . "</td>
                      </tr>";
            }
        }

        echo "</table>";

        exit; 
    }

}

