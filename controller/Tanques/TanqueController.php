<?php 
    include_once '../model/Tanques/TanquesModel.php';

    class TanqueController{

        public function lista(){
            $obj = new TanquesModel();
            $connect = $obj->getConnect();

            // Calcular parámetros de paginación (10 registros por página)
            $paginacion = calcularPaginacion(10);

            // Consulta SQL base (sin LIMIT)
            $sqlBase = "SELECT t.id,t.nombre,t.medidas,t.cantidad_peces,t.id_estado AS estado,tt.nombre AS tipo_tanque
                        FROM tanques t INNER JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id  
                        ORDER BY t.id ASC";

            // Obtener total de registros
            $totalRegistros = obtenerTotalRegistros($connect, $sqlBase);

            // Aplicar paginación a la consulta
            $sql = aplicarPaginacionSQL($sqlBase, $paginacion['limite'], $paginacion['offset']);

            // Ejecutar consulta paginada
            $tanques = $obj->select($sql);

            $tipos = $obj->select("SELECT id, nombre FROM tipo_tanque ORDER BY nombre ASC");

            // Generar HTML de paginación
            $parametros = array(
                'modulo' => isset($_GET['modulo']) ? $_GET['modulo'] : 'Tanques',
                'controlador' => isset($_GET['controlador']) ? $_GET['controlador'] : 'Tanque',
                'funcion' => isset($_GET['funcion']) ? $_GET['funcion'] : 'lista'
            );

            $htmlPaginacion = generarPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina'], $parametros);
            $infoPaginacion = generarInfoPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina']);
            
            include_once '../view/tanques/list.php';
        }
                
        public function getCreate(){
            $obj = new TanquesModel();

            // Traer tipos de tanque
            $sql = "SELECT id, nombre FROM tipo_tanque ORDER BY nombre ASC";
            $tipos = $obj->select($sql);

            include_once '../view/tanques/create.php';
        }
        
        public function postCreate(){
            $obj = new TanquesModel();
            
            $id = $obj->autoincrement("Tanques", "id");
            $nombre = $_POST['nombre'];
            $medidas = $_POST['medidas'];
            $id_tipo_tanque = $_POST['id_tipo_tanque'];
            $cantidad = $_POST['cantidad'];
            
            $sql = "INSERT INTO tanques (id, nombre, medidas, id_tipo_tanque, cantidad_peces,id_estado)
            VALUES ($id, '$nombre', '$medidas', $id_tipo_tanque, $cantidad,1)";

            $resultado = $obj->insert($sql);

            if($resultado){
                $_SESSION['success'] = "Tanque creado correctamente";
                redirect(getUrl("Tanques","Tanque","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al crear el tanque";
                redirect(getUrl("Tanques","Tanque","lista"));
                exit();
            }
        }
//        falta la tabla de estado
         public function getDelete(){
            $obj = new TanquesModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tanques","Tanque","lista"));
                return;
            }

            $sql = "SELECT t.*, tt.nombre AS tipo_tanque_nombre, 
                           CASE WHEN t.id_estado = 1 THEN 'Activo' WHEN t.id_estado = 2 THEN 'Inactivo' ELSE 'Desconocido' END AS estado_nombre
                    FROM tanques t 
                    LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id 
                    WHERE t.id = $id";

            $tanque = $obj->select($sql);

            if(!$tanque || pg_num_rows($tanque) == 0){
                redirect(getUrl("Tanques","Tanque","lista"));
                return;
            }

            include_once '../view/tanques/delete.php';
        }

        public function postDelete(){
            $obj = new TanquesModel();
            $id = intval($_POST['id']);
            
            if($id <= 0){
                redirect(getUrl("Tanques","Tanque","lista"));
                return;
            }

            $sql = "UPDATE tanques SET id_estado = 2 WHERE id = $id";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "tanque deshabilitado correctamente";
                redirect(getUrl("Tanques","Tanque","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al deshabilitar el tanque";
                redirect(getUrl("Tanques","Tanque","lista"));
                exit();
            }
        }
        
        //para el activar
        public function updateStatus(){
            $obj = new TanquesModel();
            $id = intval($_GET['id']);

            $sql = "UPDATE tanques SET id_estado=1 WHERE id=$id";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Tanque habilitado correctamente";
                redirect(getUrl("Tanques","Tanque","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al habilitar el tanque";
                redirect(getUrl("Tanques","Tanque","lista"));
                exit();
            }
        }

        public function getUpdate(){
            $obj = new TanquesModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tanques","Tanque","lista"));
                return;
            }

            $sql = "SELECT * FROM tanques WHERE id = $id";
            $tanque = pg_fetch_assoc($obj->select($sql));

            if(!$tanque){
                redirect(getUrl("Tanques","Tanque","lista"));
                return;
            }

            $sqlTipos = "SELECT id, nombre FROM tipo_tanque ORDER BY nombre ASC";
            $tipos = $obj->select($sqlTipos);

            include_once '../view/tanques/update.php';
        }

        public function postUpdate(){
            $obj = new TanquesModel();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $medidas = $_POST['medidas'];
            $id_tipo_tanque = $_POST['id_tipo_tanque'];
            $cantidad = $_POST['cantidad'];

            $sql = "UPDATE tanques SET nombre = '$nombre',medidas = '$medidas',id_tipo_tanque = $id_tipo_tanque,cantidad_peces = $cantidad WHERE id = $id";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "tanque actualizado correctamente";
                redirect(getUrl("Tanques","Tanque","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al actualizar el tanque";
                redirect(getUrl("Tanques","Tanque","lista"));
                exit();
            }
        }

        public function filtro() {
            $obj = new TanquesModel();
            $connect = $obj->getConnect();

            // Obtener filtro
            $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

            $where = array();

            // Filtro por nombre de tanque o tipo de tanque
            if ($buscar !== '') {
                $buscar_escaped = pg_escape_string($connect, $buscar);
                $where[] = "(
                    t.nombre ILIKE '%$buscar_escaped%' 
                    OR tt.nombre ILIKE '%$buscar_escaped%'
                )";
            }

            // SQL base
            $sql = "SELECT 
                        t.id,
                        t.nombre,
                        t.medidas,
                        t.cantidad_peces,
                        t.id_estado AS estado,
                        tt.nombre AS tipo_tanque
                    FROM tanques t
                    INNER JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id";

            // Agregar WHERE dinámico
            if (count($where) > 0) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            $sql .= " ORDER BY t.id ASC";

            $tanques = $obj->select($sql);

            include_once '../view/tanques/filtro.php';
        }
    }
?>