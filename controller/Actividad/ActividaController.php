<?php 
    include_once '../model/Actividad/ActividadModel.php';

    class  ActividaController {
        
        public function lista(){
            $obj = new ActividadModel();
            $connect = $obj->getConnect();

            // Calcular parámetros de paginación (10 registros por página)
            $paginacion = calcularPaginacion(10);

            // Consulta SQL base (sin LIMIT)
            $sqlBase = "SELECT id, nombre, id_estado AS estado FROM actividad ORDER BY id ASC";

            // Obtener total de registros usando COUNT directo
            $sqlCount = "SELECT COUNT(*) as total FROM actividad";
            $resultCount = pg_query($connect, $sqlCount);
            $totalRegistros = 0;
            if ($resultCount) {
                $rowCount = pg_fetch_assoc($resultCount);
                $totalRegistros = isset($rowCount['total']) ? intval($rowCount['total']) : 0;
            }

            // Aplicar paginación a la consulta
            $sql = aplicarPaginacionSQL($sqlBase, $paginacion['limite'], $paginacion['offset']);

            // Ejecutar consulta paginada
            $tipos = $obj->select($sql);

            // Generar HTML de paginación
            $parametros = array(
                'modulo' => isset($_GET['modulo']) ? $_GET['modulo'] : 'Actividad',
                'controlador' => isset($_GET['controlador']) ? $_GET['controlador'] : 'Activida',
                'funcion' => isset($_GET['funcion']) ? $_GET['funcion'] : 'lista'
            );

            $htmlPaginacion = generarPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina'], $parametros);
            $infoPaginacion = generarInfoPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina']);

            include_once '../view/actividad/list.php';
        }
                
        public function getCreate(){
            $obj = new ActividadModel();

            include_once '../view/actividad/create.php';
        }
        
        public function postCreate(){
            $obj = new ActividadModel();
            
            $id = $obj->autoincrement("actividad", "id");
            $nombre = $_POST['nombre'];
            
            $sql = "INSERT INTO actividad (id, nombre )VALUES ($id, '$nombre')";

            $resultado = $obj->insert($sql);

            if($resultado){
                $_SESSION['success'] = "Actividad creada correctamente";
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al crear la actividad";
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }
        }

        public function getDelete(){
            $obj = new ActividadModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Actividad","Activida","lista"));
                return;
            }
             $sql = "SELECT ac.id,ac.nombre, aes.nombre AS estado FROM actividad AS ac 
             INNER JOIN actividad_estado AS aes ON ac.id_estado = aes.id WHERE ac.id = $id";

            $desactivo = $obj->select($sql);


            include_once '../view/actividad/delete.php';
        }

        public function postDelete(){
            $obj = new ActividadModel();

            $id = ($_POST['id']);

            $sql = "UPDATE actividad SET id_estado = 2 WHERE id = $id";

            $ejecutar = $obj->update($sql);
            
            if($ejecutar){
                $_SESSION['success'] = "actividad deshabilitada correctamente";
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al deshabilitar la actividad";
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }
        }
        //para el activar
        public function updateStatus(){
            $obj = new ActividadModel();
            $id = intval($_GET['id']);

            $sql = "UPDATE actividad SET id_estado=1 WHERE id=$id";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Actividad habilitada correctamente";
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al habilitar la actividad";
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }
        }

        public function getUpdate(){
            $obj = new ActividadModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Actividad","Activida","lista"));
                return;
            }

            $sql = "SELECT * FROM actividad WHERE id = $id";
            $tipo_actividad = pg_fetch_assoc($obj->select($sql));

            if(!$tipo_actividad){
                redirect(getUrl("Actividad","Activida","lista"));
                return;
            }

            include_once '../view/actividad/update.php';
        }

        public function postUpdate(){
            $obj = new ActividadModel();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];

            $sql = "UPDATE actividad SET nombre = '$nombre' WHERE id = $id";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Actividad actualizada correctamente";
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al actualizar la actividad";
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }
        }
    }
?>