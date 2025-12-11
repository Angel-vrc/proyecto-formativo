<?php

    include_once '../model/Seguimiento/SeguimientoModel.php';

    class SeguimientoController{


        public function lista(){
            $obj = new SeguimientoModel();

            $sql = "SELECT sd.*, 
                           a.nombre as nombre_actividad,
                           t.nombre as nombre_tanque,
                           tt.nombre as nombre_tipo_tanque,
                           s.fecha as fecha_seguimiento,
                           COALESCE(sd.estado_id, 1) as estado_id
                    FROM seguimiento_detalle sd
                    LEFT JOIN actividad a ON sd.id_actividad = a.id
                    LEFT JOIN seguimiento s ON sd.id_seguimiento = s.id
                    LEFT JOIN tanques t ON s.id_tanque = t.id
                    LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id
                    WHERE NOT (sd.ph = 0 AND sd.temperatura = 0 AND sd.cloro = 0 AND sd.num_alevines = 0 AND sd.num_muertes = 0 AND sd.num_machos = 0 AND sd.num_hembras = 0 AND sd.total = 0)
                    ORDER BY sd.id ASC";

            $seguimientos = $obj->select($sql);

            include_once '../view/Seguimiento/list.php';

        }
        
        public function getCreate(){
            $obj = new SeguimientoModel();
            
            $sql_actividades = "SELECT id, nombre FROM actividad ORDER BY nombre";
            $actividades = $obj->select($sql_actividades);
            
            $sql_zoocriaderos = "SELECT id_zoocriadero, nombre FROM zoocriadero ORDER BY nombre";
            $zoocriaderos = $obj->select($sql_zoocriaderos);
            
            include_once '../view/Seguimiento/create.php';
        }

        public function getTanquesByZoocriadero(){
            header('Content-Type: application/json');
            
            $obj = new SeguimientoModel();
            $id_zoocriadero = $_GET['id_zoocriadero'];
            
            
            $sql_tanques = "SELECT t.id, t.nombre, t.cantidad_peces, t.id_tipo_tanque, tt.nombre as tipo_tanque
                           FROM tanques t
                           LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id
                           WHERE t.id_zoocriadero = $id_zoocriadero
                           ORDER BY t.nombre";
            
            $tanques = $obj->select($sql_tanques);
            
            $tanques_array = array();
            
            
            if($tanques && pg_num_rows($tanques) > 0){
                while($tanque = pg_fetch_assoc($tanques)){
                    // Formatear el nombre del tanque con su tipo: "Tanque A - Siembra"
                    $nombre_completo = $tanque['nombre'];
                    if(!empty($tanque['tipo_tanque'])){
                        $nombre_completo .= ' - ' . $tanque['tipo_tanque'];
                    }
                    
                    $tanques_array[] = array(
                        'id' => $tanque['id'],
                        'nombre' => $nombre_completo,
                        'nombre_solo' => $tanque['nombre'],
                        'cantidad_peces' => $tanque['cantidad_peces'],
                        'tipo_tanque' => $tanque['tipo_tanque'],
                        'id_tipo_tanque' => $tanque['id_tipo_tanque']
                    );
                }
            }
            
            echo json_encode(array('success' => true, 'tanques' => $tanques_array));
            exit();
        }

        public function postCreate(){
            $obj = new SeguimientoModel();

             $fecha = $_POST['fecha'];
             $id_zoocriadero = $_POST['id_zoocriadero'];
             $id_tanque = $_POST['id_tanque'];
             $id_responsable = $_SESSION['usuario_id'];
             
             $cantidad_peces_tanque = 0;
            if($id_tanque > 0){
                $sql_tanque = "SELECT cantidad_peces FROM tanques WHERE id=$id_tanque";
                $result_tanque = $obj->select($sql_tanque);
                if(pg_num_rows($result_tanque) > 0){
                    $tanque_data = pg_fetch_assoc($result_tanque);
                    $cantidad_peces_tanque = $tanque_data['cantidad_peces'];
                }
            }
            
            $id_seguimiento = $obj->autoincrement("seguimiento", "id");
            $sql_new_seguimiento = "INSERT INTO seguimiento (id, id_zoo, id_tanque, id_responsable, fecha) 
                                   VALUES ($id_seguimiento, $id_zoocriadero, $id_tanque, $id_responsable, '$fecha')";
            $result_seguimiento = $obj->insert($sql_new_seguimiento);
            
            if(!$result_seguimiento){
                echo "Error al crear el seguimiento";
                exit();
            }

            $id = $obj->autoincrement("seguimiento_detalle", "id");
            $id_actividad = $_POST['id_actividad'];
            $ph = $_POST['ph'];
            $temperatura = $_POST['temperatura'];
            $num_alevines = $_POST['num_alevines'];
            $num_muertes = $_POST['num_muertes'];
            $num_machos = $_POST['num_machos'];
            $num_hembras = $_POST['num_hembras'];
            $cloro = $_POST['cloro'];
            $observaciones = $_POST['observaciones'] ? pg_escape_string($obj->getConnect(), $_POST['observaciones']) : '';
            
            // Validar que la suma de alevines, hembras y machos sea igual a la cantidad de peces del tanque
            $suma_peces = $num_alevines + $num_hembras + $num_machos;
            if($cantidad_peces_tanque > 0 && $suma_peces != $cantidad_peces_tanque) {
                $_SESSION['error'] = "La suma de Alevines ($num_alevines) + Hembras ($num_hembras) + Machos ($num_machos) = $suma_peces debe ser igual a la cantidad de peces del tanque ($cantidad_peces_tanque)";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","create") . "';</script>";
                exit();
            }
            
            // Calcular total: Cantidad de peces del tanque - Muertes
            $total = $cantidad_peces_tanque - $num_muertes;
            
            $sql = "INSERT INTO seguimiento_detalle (id, id_seguimiento, id_actividad, ph, temperatura, num_alevines, num_muertes, num_machos, num_hembras, cloro, observaciones, total, estado_id) 
                    VALUES ($id, $id_seguimiento, $id_actividad, $ph, $temperatura, $num_alevines, $num_muertes, $num_machos, $num_hembras, $cloro, '$observaciones', $total, 1)";

            $resultado = $obj->insert($sql);

            if(!$resultado){
                $_SESSION['error'] = "Error en la insercion de datos";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","lista") . "';</script>";
                exit();
            }else{                
                $_SESSION['success'] = "Seguimiento registrado correctamente";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","lista") . "';</script>";
                exit();
            }
        }

        public function getDelete(){
            $obj = new SeguimientoModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Seguimiento","Seguimiento","lista"));
                return;
            }


            $sql = "SELECT sd.*, 
                           a.nombre as nombre_actividad,
                           sde.nombre as nombre_estado
                    FROM seguimiento_detalle sd 
                    LEFT JOIN actividad a ON sd.id_actividad = a.id
                    LEFT JOIN seguimiento_detalle_estado sde ON sd.estado_id = sde.id
                    WHERE sd.id=$id";

            $seguimiento = $obj->select($sql);

            if(empty($seguimiento)){
                echo "El seguimiento solicitado no existe";
            }

            include_once '../view/Seguimiento/delete.php';
        }

        public function postDelete(){
            $obj = new SeguimientoModel();

            $id = ($_POST['id']);

            $sql = "UPDATE seguimiento_detalle SET estado_id = 2 WHERE id = $id";

            $ejecutar = $obj->update($sql);
            
            if($ejecutar){
                $_SESSION['success'] = "Seguimiento inactivado correctamente";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","lista") . "';</script>";
                exit();
            }else{
                $_SESSION['error'] = "No se pudo actualizar el seguimiento";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","lista") . "';</script>";
                exit();
            }

        }

        public function updateStatus(){
            $obj = new SeguimientoModel();
            $id = $_GET['id'];

            if($id <= 0){
                redirect(getUrl("Seguimiento","Seguimiento","lista"));
                return;
            }

            $sql = "UPDATE seguimiento_detalle SET estado_id=1 WHERE id=$id";

            $ejecutar = $obj->update($sql);

            if($ejecutar){
                $_SESSION['success'] = "Seguimiento activado correctamente";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","lista") . "';</script>";
                exit();
            }else{
                $_SESSION['error'] = "El seguimiento solicitado no existe";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","lista") . "';</script>";
                exit();
            }
        }

        public function getUpdate(){
            $obj = new SeguimientoModel();  

            $id = $_GET['id'];
            $sql = "SELECT sd.*, 
                           a.nombre as nombre_actividad,
                           t.nombre as nombre_tanque,
                           tt.nombre as nombre_tipo_tanque,
                           s.fecha as fecha_seguimiento,
                           s.id_tanque as id_tanque_actual,
                           t.id_tipo_tanque as id_tipo_tanque_actual,
                           t.cantidad_peces as cantidad_peces_tanque
                    FROM seguimiento_detalle sd 
                    LEFT JOIN actividad a ON sd.id_actividad = a.id
                    LEFT JOIN seguimiento s ON sd.id_seguimiento = s.id
                    LEFT JOIN tanques t ON s.id_tanque = t.id
                    LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id
                    WHERE sd.id=$id";

            $seguimiento = $obj->select($sql);
            
            $sql_actividades = "SELECT id, nombre FROM actividad ORDER BY nombre";
            $actividades = $obj->select($sql_actividades);
            
            $sql_tanques = "SELECT t.id, t.nombre, tt.nombre as tipo_tanque, t.id_tipo_tanque
                           FROM tanques t
                           LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id
                           ORDER BY t.nombre";
            $tanques = $obj->select($sql_tanques);

            include_once '../view/Seguimiento/update.php';
        }

        public function postUpdate(){
            $obj = new SeguimientoModel();

             $id = $_POST['id'];
             $fecha = $_POST['fecha'];
             $id_tanque = $_POST['id_tanque'];
             $id_seguimiento = $_POST['id_seguimiento'];
             $id_responsable = $_SESSION['usuario_id'];
             $id_zoo = 0;
             
             if($id_seguimiento > 0){
                $sql_update_seguimiento = "UPDATE seguimiento SET fecha='$fecha', id_tanque=$id_tanque, id_responsable=$id_responsable WHERE id=$id_seguimiento";
                $obj->update($sql_update_seguimiento);
            } else {
                $id_seguimiento_new = $obj->autoincrement("seguimiento", "id");
                $sql_new_seguimiento = "INSERT INTO seguimiento (id, id_zoo, id_tanque, id_responsable, fecha) 
                                       VALUES ($id_seguimiento_new, $id_zoo, $id_tanque, $id_responsable, '$fecha')";
                $obj->insert($sql_new_seguimiento);
                $id_seguimiento = $id_seguimiento_new;
            }
            
            $cantidad_peces_tanque = 0;
            if($id_tanque > 0){
                $sql_tanque = "SELECT cantidad_peces FROM tanques WHERE id=$id_tanque";
                $result_tanque = $obj->select($sql_tanque);
                if(pg_num_rows($result_tanque) > 0){
                    $tanque_data = pg_fetch_assoc($result_tanque);
                    $cantidad_peces_tanque = $tanque_data['cantidad_peces'];
                }
            }

            $id_actividad = $_POST['id_actividad'];
            $ph = $_POST['ph'];
            $temperatura = $_POST['temperatura'];
            $num_alevines = $_POST['num_alevines'];
            $num_muertes = $_POST['num_muertes'];
            $num_machos = $_POST['num_machos'];
            $num_hembras = $_POST['num_hembras'];
            $cloro = $_POST['cloro'];
            $observaciones = $_POST['observaciones'];
            
            // Validar que la suma de alevines, hembras y machos sea igual a la cantidad de peces del tanque
            $suma_peces = $num_alevines + $num_hembras + $num_machos;
            if($cantidad_peces_tanque > 0 && $suma_peces != $cantidad_peces_tanque) {
                $_SESSION['error'] = "La suma de Alevines ($num_alevines) + Hembras ($num_hembras) + Machos ($num_machos) = $suma_peces debe ser igual a la cantidad de peces del tanque ($cantidad_peces_tanque)";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","update", array("id" => $id)) . "';</script>";
                exit();
            }
            
            // Calcular total: Cantidad de peces del tanque - Muertes
            $total = $cantidad_peces_tanque - $num_muertes;

            $sql = "UPDATE seguimiento_detalle SET id_seguimiento=$id_seguimiento, id_actividad=$id_actividad, ph=$ph, temperatura=$temperatura, num_alevines=$num_alevines, num_muertes=$num_muertes, num_machos=$num_machos, num_hembras=$num_hembras, cloro=$cloro, observaciones='$observaciones', total=$total WHERE id=$id";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Seguimiento actualizado correctamente";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","lista") . "';</script>";
                exit();
            }else{
                $_SESSION['error'] = "Error al actualizar el seguimiento";
                echo "<script>window.location.href = '" . getUrl("Seguimiento","Seguimiento","lista") . "';</script>";
                exit();
            }
        }

    }

