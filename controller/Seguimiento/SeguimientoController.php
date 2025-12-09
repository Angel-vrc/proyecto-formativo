<?php

    include_once '../model/Seguimiento/SeguimientoModel.php';

    class SeguimientoController{

        public function list(){
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
            
            // Obtener actividades para el select
            $sql_actividades = "SELECT id, nombre FROM actividad ORDER BY nombre";
            $actividades = $obj->select($sql_actividades);
            
            // Obtener zoocriaderos para el select
            $sql_zoocriaderos = "SELECT id_zoocriadero, nombre FROM zoocriadero ORDER BY nombre";
            $zoocriaderos = $obj->select($sql_zoocriaderos);
            
            // Obtener tipos de tanque para el select
            $sql_tipos_tanque = "SELECT id, nombre FROM tipo_tanque ORDER BY nombre";
            $tipos_tanque = $obj->select($sql_tipos_tanque);
            
            include_once '../view/Seguimiento/create.php';
        }

        public function getTanquesByZoocriadero(){
            // Establecer header JSON desde el inicio
            header('Content-Type: application/json');
            
            $obj = new SeguimientoModel();
            $id_zoocriadero = isset($_GET['id_zoocriadero']) ? intval($_GET['id_zoocriadero']) : 0;
            
            if($id_zoocriadero <= 0){
                echo json_encode(array('success' => false, 'message' => 'ID de zoocriadero inválido', 'tanques' => array()));
                exit();
            }
            
            // Obtener tanques asociados al zoocriadero usando la FK id_zoocriadero
            // Según el backup: tanques tiene id_zoocriadero como FK a zoocriadero(id_zoocriadero)
            $sql_tanques = "SELECT t.id, t.nombre, t.cantidad_peces, t.id_tipo_tanque, tt.nombre as tipo_tanque
                           FROM tanques t
                           LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id
                           WHERE t.id_zoocriadero = $id_zoocriadero
                           ORDER BY t.nombre";
            
            $tanques = $obj->select($sql_tanques);
            
            $tanques_array = array();
            
            // Verificar si hay error en la consulta
            if($tanques === false){
                echo json_encode(array('success' => false, 'message' => 'Error en la consulta SQL', 'tanques' => array()));
                exit();
            }
            
            if($tanques && pg_num_rows($tanques) > 0){
                while($tanque = pg_fetch_assoc($tanques)){
                    $tanques_array[] = array(
                        'id' => intval($tanque['id']),
                        'nombre' => isset($tanque['nombre']) ? $tanque['nombre'] : '',
                        'cantidad_peces' => isset($tanque['cantidad_peces']) ? intval($tanque['cantidad_peces']) : 0,
                        'tipo_tanque' => isset($tanque['tipo_tanque']) ? $tanque['tipo_tanque'] : '',
                        'id_tipo_tanque' => isset($tanque['id_tipo_tanque']) ? intval($tanque['id_tipo_tanque']) : null
                    );
                }
            }
            
            echo json_encode(array('success' => true, 'tanques' => $tanques_array));
            exit();
        }

        public function postCreate(){
            $obj = new SeguimientoModel();

            // Primero crear el seguimiento
            $fecha = $_POST['fecha'];
            $id_zoocriadero = isset($_POST['id_zoocriadero']) ? intval($_POST['id_zoocriadero']) : 0;
            $id_tanque = isset($_POST['id_tanque']) ? intval($_POST['id_tanque']) : 0;
            $id_responsable = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;
            
            // Actualizar el tanque con el tipo de tanque seleccionado si es necesario
            $id_tipo_tanque = isset($_POST['id_tipo_tanque']) ? intval($_POST['id_tipo_tanque']) : 0;
            if($id_tanque > 0 && $id_tipo_tanque > 0){
                $sql_update_tanque = "UPDATE tanques SET id_tipo_tanque=$id_tipo_tanque WHERE id=$id_tanque";
                $obj->update($sql_update_tanque);
            }
            
            // Obtener cantidad_peces del tanque para calcular el total
            $cantidad_peces_tanque = 0;
            if($id_tanque > 0){
                $sql_tanque = "SELECT cantidad_peces FROM tanques WHERE id=$id_tanque";
                $result_tanque = $obj->select($sql_tanque);
                if(pg_num_rows($result_tanque) > 0){
                    $tanque_data = pg_fetch_assoc($result_tanque);
                    $cantidad_peces_tanque = isset($tanque_data['cantidad_peces']) ? intval($tanque_data['cantidad_peces']) : 0;
                }
            }
            
            // Crear nuevo seguimiento y obtener el ID
            $id_seguimiento = $obj->autoincrement("seguimiento", "id");
            $sql_new_seguimiento = "INSERT INTO seguimiento (id, id_zoo, id_tanque, id_responsable, fecha) 
                                   VALUES ($id_seguimiento, $id_zoocriadero, $id_tanque, $id_responsable, '$fecha')";
            $result_seguimiento = $obj->insert($sql_new_seguimiento);
            
            if(!$result_seguimiento){
                echo "Error al crear el seguimiento";
                exit();
            }

            // Ahora crear el seguimiento_detalle con el ID del seguimiento
            $id = $obj->autoincrement("seguimiento_detalle", "id");
            $id_actividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;
            $ph = isset($_POST['ph']) ? floatval($_POST['ph']) : 0;
            $temperatura = isset($_POST['temperatura']) ? floatval($_POST['temperatura']) : 0;
            $num_alevines = isset($_POST['num_alevines']) ? intval($_POST['num_alevines']) : 0;
            $num_muertes = isset($_POST['num_muertes']) ? intval($_POST['num_muertes']) : 0;
            $num_machos = isset($_POST['num_machos']) ? intval($_POST['num_machos']) : 0;
            $num_hembras = isset($_POST['num_hembras']) ? intval($_POST['num_hembras']) : 0;
            $cloro = isset($_POST['cloro']) ? floatval($_POST['cloro']) : 0;
            $observaciones = isset($_POST['observaciones']) ? pg_escape_string($obj->getConnect(), $_POST['observaciones']) : '';
            
            // Calcular el total: cantidad_peces del tanque + alevines - muertes + machos + hembras
            $total = $cantidad_peces_tanque + $num_alevines - $num_muertes + $num_machos + $num_hembras;
            
            $sql = "INSERT INTO seguimiento_detalle (id, id_seguimiento, id_actividad, ph, temperatura, num_alevines, num_muertes, num_machos, num_hembras, cloro, observaciones, total, estado_id) 
                    VALUES ($id, $id_seguimiento, $id_actividad, $ph, $temperatura, $num_alevines, $num_muertes, $num_machos, $num_hembras, $cloro, '$observaciones', $total, 1)";

            $resultado = $obj->insert($sql);

            if(!$resultado){
                echo "Error en la insercion de datos";
            }else{                
                redirect(getUrl("Seguimiento","Seguimiento","list"));
            }
        }

        public function getDelete(){
            $obj = new SeguimientoModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Seguimiento","Seguimiento","list"));
                return;
            }


            $sql = "SELECT * FROM seguimiento_detalle WHERE id=$id";

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
                redirect(getUrl("Seguimiento","Seguimiento","list"));
            }else{
                echo "No se pudo actualizar el seguimiento";
            }

        }

        public function updateStatus(){
            $obj = new SeguimientoModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Seguimiento","Seguimiento","list"));
                return;
            }

            $sql = "UPDATE seguimiento_detalle SET estado_id=1 WHERE id=$id";

            $ejecutar = $obj->update($sql);

            if($ejecutar){
                redirect(getUrl("Seguimiento","Seguimiento","list"));
            }else{
                echo "El seguimiento solicitado no existe.";
                return;
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
            
            // Obtener actividades para el select
            $sql_actividades = "SELECT id, nombre FROM actividad ORDER BY nombre";
            $actividades = $obj->select($sql_actividades);
            
            // Obtener tanques para el select
            $sql_tanques = "SELECT t.id, t.nombre, tt.nombre as tipo_tanque, t.id_tipo_tanque
                           FROM tanques t
                           LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id
                           ORDER BY t.nombre";
            $tanques = $obj->select($sql_tanques);
            
            // Obtener tipos de tanque para el select
            $sql_tipos_tanque = "SELECT id, nombre FROM tipo_tanque ORDER BY nombre";
            $tipos_tanque = $obj->select($sql_tipos_tanque);

            include_once '../view/Seguimiento/update.php';
        }

        public function postUpdate(){
            $obj = new SeguimientoModel();

            $id = $_POST['id'];
            $fecha = $_POST['fecha'];
            $id_tanque = isset($_POST['id_tanque']) ? intval($_POST['id_tanque']) : 0;
            $id_tipo_tanque = isset($_POST['id_tipo_tanque']) ? intval($_POST['id_tipo_tanque']) : 0;
            $id_seguimiento = isset($_POST['id_seguimiento']) ? intval($_POST['id_seguimiento']) : 0;
            $id_responsable = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;
            $id_zoo = 0;
            
            // Actualizar el tanque con el tipo de tanque seleccionado
            if($id_tanque > 0 && $id_tipo_tanque > 0){
                $sql_update_tanque = "UPDATE tanques SET id_tipo_tanque=$id_tipo_tanque WHERE id=$id_tanque";
                $obj->update($sql_update_tanque);
            }
            
            // Actualizar o crear seguimiento
            if($id_seguimiento > 0){
                // Actualizar seguimiento existente
                $sql_update_seguimiento = "UPDATE seguimiento SET fecha='$fecha', id_tanque=$id_tanque, id_responsable=$id_responsable WHERE id=$id_seguimiento";
                $obj->update($sql_update_seguimiento);
            } else {
                // Crear nuevo seguimiento
                $id_seguimiento_new = $obj->autoincrement("seguimiento", "id");
                $sql_new_seguimiento = "INSERT INTO seguimiento (id, id_zoo, id_tanque, id_responsable, fecha) 
                                       VALUES ($id_seguimiento_new, $id_zoo, $id_tanque, $id_responsable, '$fecha')";
                $obj->insert($sql_new_seguimiento);
                $id_seguimiento = $id_seguimiento_new;
            }
            
            // Obtener cantidad_peces del tanque para calcular el total
            $cantidad_peces_tanque = 0;
            if($id_tanque > 0){
                $sql_tanque = "SELECT cantidad_peces FROM tanques WHERE id=$id_tanque";
                $result_tanque = $obj->select($sql_tanque);
                if(pg_num_rows($result_tanque) > 0){
                    $tanque_data = pg_fetch_assoc($result_tanque);
                    $cantidad_peces_tanque = isset($tanque_data['cantidad_peces']) ? intval($tanque_data['cantidad_peces']) : 0;
                }
            }
            
            $id_actividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;
            $ph = isset($_POST['ph']) && $_POST['ph'] !== '' ? floatval($_POST['ph']) : 0;
            $temperatura = isset($_POST['temperatura']) && $_POST['temperatura'] !== '' ? floatval($_POST['temperatura']) : 0;
            $num_alevines = isset($_POST['num_alevines']) && $_POST['num_alevines'] !== '' ? intval($_POST['num_alevines']) : 0;
            $num_muertes = isset($_POST['num_muertes']) && $_POST['num_muertes'] !== '' ? intval($_POST['num_muertes']) : 0;
            $num_machos = isset($_POST['num_machos']) && $_POST['num_machos'] !== '' ? intval($_POST['num_machos']) : 0;
            $num_hembras = isset($_POST['num_hembras']) && $_POST['num_hembras'] !== '' ? intval($_POST['num_hembras']) : 0;
            $cloro = isset($_POST['cloro']) && $_POST['cloro'] !== '' ? floatval($_POST['cloro']) : 0;
            $observaciones = isset($_POST['observaciones']) ? pg_escape_string($obj->getConnect(), $_POST['observaciones']) : '';
            
            // Cálculo del total (misma fórmula que en postCreate)
            $total = $cantidad_peces_tanque + $num_alevines - $num_muertes + $num_machos + $num_hembras;

            $sql = "UPDATE seguimiento_detalle SET id_seguimiento=$id_seguimiento, id_actividad=$id_actividad, ph=$ph, temperatura=$temperatura, num_alevines=$num_alevines, num_muertes=$num_muertes, num_machos=$num_machos, num_hembras=$num_hembras, cloro=$cloro, observaciones='$observaciones', total=$total WHERE id=$id";

            $resultado = $obj->update($sql);

            if($resultado){
                redirect(getUrl("Seguimiento","Seguimiento","list"));
            }else{
                echo "error de insercion";
            }
        }

    }

?>

