<?php

    include_once '../model/Zoocriaderos/ZoocriaderoModel.php';
    include_once '../model/Seguimiento/SeguimientoModel.php';

    class DashboardController{

        public function index(){
            $objZoocriadero = new ZoocriaderoModel();
            $objSeguimiento = new SeguimientoModel();

            // Contar total de zoocriaderos
            $sql_zoocriaderos = "SELECT COUNT(*) as total FROM zoocriadero";
            $result_zoocriaderos = $objZoocriadero->select($sql_zoocriaderos);
            $total_zoocriaderos = 0;
            if($result_zoocriaderos && pg_num_rows($result_zoocriaderos) > 0){
                $row = pg_fetch_assoc($result_zoocriaderos);
                $total_zoocriaderos = $row['total'];
            }

            // Contar total de tanques
            $sql_tanques = "SELECT COUNT(*) as total FROM tanques";
            $result_tanques = $objZoocriadero->select($sql_tanques);
            $total_tanques = 0;
            if($result_tanques && pg_num_rows($result_tanques) > 0){
                $row = pg_fetch_assoc($result_tanques);
                $total_tanques = $row['total'];
            }

            // Sumar total de hembras del último seguimiento de cada tanque
            // Obtenemos el último id_seguimiento por tanque y luego sumamos las hembras
            $sql_hembras = "SELECT COALESCE(SUM(sd.num_hembras), 0) as total
                           FROM seguimiento_detalle sd
                           INNER JOIN seguimiento s ON sd.id_seguimiento = s.id
                           INNER JOIN (
                               SELECT DISTINCT ON (id_tanque) id as ultimo_seguimiento_id
                               FROM seguimiento
                               ORDER BY id_tanque, fecha DESC, id DESC
                           ) ultimos ON s.id = ultimos.ultimo_seguimiento_id
                           WHERE sd.num_hembras IS NOT NULL AND sd.num_hembras > 0";
            $result_hembras = $objSeguimiento->select($sql_hembras);
            $total_hembras = 0;
            if($result_hembras !== false && pg_num_rows($result_hembras) > 0){
                $row = pg_fetch_assoc($result_hembras);
                $total_hembras = isset($row['total']) ? intval($row['total']) : 0;
            } 

            // Sumar total de machos del último seguimiento de cada tanque
            // Obtenemos el último id_seguimiento por tanque y luego sumamos los machos
            $sql_machos = "SELECT COALESCE(SUM(sd.num_machos), 0) as total
                          FROM seguimiento_detalle sd
                          INNER JOIN seguimiento s ON sd.id_seguimiento = s.id
                          INNER JOIN (
                              SELECT DISTINCT ON (id_tanque) id as ultimo_seguimiento_id
                              FROM seguimiento
                              ORDER BY id_tanque, fecha DESC, id DESC
                          ) ultimos ON s.id = ultimos.ultimo_seguimiento_id
                          WHERE sd.num_machos IS NOT NULL AND sd.num_machos > 0";
            $result_machos = $objSeguimiento->select($sql_machos);
            $total_machos = 0;
            if($result_machos !== false && pg_num_rows($result_machos) > 0){
                $row = pg_fetch_assoc($result_machos);
                $total_machos = isset($row['total']) ? intval($row['total']) : 0;
            }

            // Pasar los datos a la vista
            $datos_dashboard = array(
                'total_zoocriaderos' => $total_zoocriaderos,
                'total_tanques' => $total_tanques,
                'total_hembras' => $total_hembras,
                'total_machos' => $total_machos
            );

            include_once '../view/partials/dashboard.php';
        }
    }
       
?>
