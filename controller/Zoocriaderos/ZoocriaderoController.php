<?php

    include_once '../model/Zoocriaderos/ZoocriaderoModel.php';

    class ZoocriaderoController{

        private function construirDireccion($tipoVia, $numeroVia, $complemento = '') {
            $direccion = '';
            
            // Construir dirección: Tipo de Vía + Número de Vía
            if (!empty($tipoVia) && !empty($numeroVia)) {
                $direccion = trim($tipoVia) . ' ' . trim($numeroVia);
            } else if (!empty($tipoVia)) {
                $direccion = trim($tipoVia);
            } else if (!empty($numeroVia)) {
                $direccion = trim($numeroVia);
            }
            
            // Agregar complemento si existe
            if (!empty($complemento) && !empty($direccion)) {
                $direccion .= ' ' . trim($complemento);
            } else if (!empty($complemento)) {
                $direccion = trim($complemento);
            }

            return trim($direccion);
        }

        public function lista(){
            $obj = new ZoocriaderoModel();
            $connect = $obj->getConnect();

            // Calcular parámetros de paginación (10 registros por página)
            $paginacion = calcularPaginacion(10);

            // Consulta SQL base (sin LIMIT)
            $sqlBase = "SELECT z.*, e.nombre nombre_estado, u.nombre nombre_responsable, u.apellido apellido_responsable 
                        FROM zoocriadero z, usuarios u, zoocriadero_estado e 
                        WHERE z.responsable = u.id AND z.id_estado = e.id_estado
                        ORDER BY z.id_zoocriadero ASC";

            // Obtener total de registros
            $totalRegistros = obtenerTotalRegistros($connect, $sqlBase);

            // Aplicar paginación a la consulta
            $sql = aplicarPaginacionSQL($sqlBase, $paginacion['limite'], $paginacion['offset']);

            // Ejecutar consulta paginada
            $zoocriaderos = $obj->select($sql);

            // Generar HTML de paginación
            $parametros = array(
                'modulo' => isset($_GET['modulo']) ? $_GET['modulo'] : 'Zoocriaderos',
                'controlador' => isset($_GET['controlador']) ? $_GET['controlador'] : 'Zoocriadero',
                'funcion' => isset($_GET['funcion']) ? $_GET['funcion'] : 'lista'
            );

            $htmlPaginacion = generarPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina'], $parametros);
            $infoPaginacion = generarInfoPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina']);

            include_once '../lib/data/ubicacion.php';
            include_once '../view/zoocriaderos/list.php';
        }
        
        public function getCreate(){
            $obj = new ZoocriaderoModel();

            //Falta hacer el echo en su respectivo input en el formulario
            $longitud = $_GET['longitud'];
            $latitud = $_GET['latitud'];

            $sql = "SELECT id, nombre, apellido FROM usuarios";

            $usuarios = $obj->select($sql);

            include_once '../lib/data/ubicacion.php';
            include_once '../view/zoocriaderos/create.php';
        }

        public function postCreate(){
            $obj = new ZoocriaderoModel();
            $connect = $obj->getConnect();

            $id_zoocriadero = $obj->autoincrement("zoocriadero", "id_zoocriadero");
            $nombre = pg_escape_string($connect, $_POST['nombre']);
            
            // Construir dirección estandarizada
            $tipoVia = isset($_POST['tipo_via']) ? pg_escape_string($connect, $_POST['tipo_via']) : '';
            $numeroVia = isset($_POST['numero_via']) ? pg_escape_string($connect, $_POST['numero_via']) : '';
            $complemento = isset($_POST['complemento_direccion']) ? pg_escape_string($connect, $_POST['complemento_direccion']) : '';
            
            // Si la dirección ya viene construida del formulario, usarla; si no, construirla
            $direccionPost = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
            if (!empty($direccionPost)) {
                $direccion = pg_escape_string($connect, $direccionPost);
            } else {
                $direccion = pg_escape_string($connect, $this->construirDireccion($tipoVia, $numeroVia, $complemento));
            }
            
            $comuna = pg_escape_string($connect, $_POST['comuna']);
            $barrio = pg_escape_string($connect, $_POST['barrio']);
            $responsable = intval($_POST['responsable']);
            $telefono = pg_escape_string($connect, $_POST['telefono']);
            $correo = pg_escape_string($connect, $_POST['correo']);
            $latitud = floatval($_POST['latitud']);
            $longitud = floatval($_POST['longitud']);
            $coordenadas = $latitud . "," . $longitud;
            $punto = "ST_SetSRID(ST_GeomFromText('POINT(". $longitud . " " . $latitud . " )'), 4326)";
            
            $sql = "INSERT INTO zoocriadero VALUES ($id_zoocriadero, $responsable, '$direccion', '$coordenadas', '$telefono', '$comuna', '$barrio', '$nombre', $punto, 1, '$correo')";

            $resultado = $obj->insert($sql);

            if($resultado){
                $_SESSION['success'] = "Zoocriadero creado correctamente";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al crear el zoocriadero";
                redirect(getUrl("Mapa","Mapa","visualizarZoo"));
                exit();
            }
        }


        public function getDelete(){
            $obj = new ZoocriaderoModel();
            $id_zoocriadero = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id_zoocriadero <= 0){
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                return;
            }


            $sql = "SELECT z.*, u.nombre AS responsable_nombre, u.apellido AS responsable_apellido, e.nombre AS estado_nombre FROM zoocriadero AS z
            JOIN usuarios AS u ON z.responsable = u.id
            JOIN zoocriadero_estado AS e ON z.id_estado = e.id_estado
            WHERE z.id_zoocriadero = $id_zoocriadero;";

            $zoocriadero = $obj->select($sql);

            if(empty($zoocriadero)){
                echo "El zoocriadero solicitado no existe";
            }

            include_once '../view/zoocriaderos/delete.php';
        }

        public function postDelete(){
            $obj = new ZoocriaderoModel();

            $id_zoocriadero = ($_POST['id']);

            $sql = "UPDATE zoocriadero SET id_estado = 2 WHERE id_zoocriadero = $id_zoocriadero";

            $resultado = $obj->update($sql);
            
            if($resultado){
                $_SESSION['success'] = "Zoocriadero deshabilitado correctamente";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al deshabilitar el zoocriadero";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }

        }

        public function updateStatus(){
            $obj = new ZoocriaderoModel();
            $id_zoocriadero = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id_zoocriadero <= 0){
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                return;
            }

            $sql = "UPDATE zoocriadero SET id_estado=1 WHERE id_zoocriadero=$id_zoocriadero";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Zoocriadero habilitado correctamente";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al habilitar el zoocriadero";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }
        }


        public function getUpdate(){
            $obj = new ZoocriaderoModel();  

            $id_zoocriadero = $_GET['id'];
            $sql = "SELECT * FROM zoocriadero WHERE id_zoocriadero = $id_zoocriadero";

            $zoocriadero = $obj->select($sql);

            $sql = "SELECT id, nombre, apellido FROM usuarios";

            $usuarios = $obj->select($sql);

            include_once '../lib/data/ubicacion.php';
            include_once '../view/zoocriaderos/update.php';
        }

        public function postUpdate(){
            $obj = new ZoocriaderoModel();
            $connect = $obj->getConnect();

            $id_zoocriadero = intval($_POST['id']);
            $nombre = pg_escape_string($connect, $_POST['nombre']);
            
            // Construir dirección estandarizada SIEMPRE desde los campos individuales
            $tipoVia = isset($_POST['tipo_via']) ? trim($_POST['tipo_via']) : '';
            $numeroVia = isset($_POST['numero_via']) ? trim($_POST['numero_via']) : '';
            $complemento = isset($_POST['complemento_direccion']) ? trim($_POST['complemento_direccion']) : '';
            
            // Construir la dirección desde los campos individuales
            $direccion = $this->construirDireccion($tipoVia, $numeroVia, $complemento);
            $direccion = pg_escape_string($connect, $direccion);

            $coordenadas = pg_escape_string($connect, $_POST['coordenadas']);
            $comuna = pg_escape_string($connect, $_POST['comuna']);
            $barrio = pg_escape_string($connect, $_POST['barrio']);
            $responsable = intval($_POST['responsable']);
            $telefono = pg_escape_string($connect, $_POST['telefono']);
            $correo = pg_escape_string($connect, $_POST['correo']);

            $sql = "UPDATE zoocriadero SET responsable=$responsable, direccion='$direccion', coordenadas='$coordenadas',  telefono='$telefono', comuna='$comuna', barrio='$barrio', nombre='$nombre', correo='$correo' WHERE id_zoocriadero=$id_zoocriadero";


            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Zoocriadero actualizado correctamente";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al actualizar el zoocriadero";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }
        }

        public function filtro() {
            $obj = new ZoocriaderoModel();
            $connect = $obj->getConnect();

            // Obtener y validar filtros
            $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
            $comuna = isset($_GET['comuna']) ? trim($_GET['comuna']) : '';
            $estado = isset($_GET['estado']) ? trim($_GET['estado']) : '';

            $where = array();

            // Filtro por texto (nombre o responsable)
            if ($buscar !== '') {
                $buscar_escaped = pg_escape_string($connect, $buscar);
                $where[] = "(z.nombre ILIKE '%$buscar_escaped%' 
                            OR u.nombre ILIKE '%$buscar_escaped%' 
                            OR u.apellido ILIKE '%$buscar_escaped%'
                            OR e.nombre ILIKE '%$buscar_escaped%')";
            }

            // Filtro por comuna (igualdad exacta)
            if ($comuna !== '') {
                $comuna_escaped = pg_escape_string($connect, $comuna);
                $where[] = "z.comuna = '$comuna_escaped'";
            }

            // Filtro por estado (1 = Activo, 2 = Inactivo)
            if ($estado !== '' && ($estado == '1' || $estado == '2')) {
                $estado_escaped = intval($estado);
                $where[] = "z.id_estado = $estado_escaped";
            }

            // SQL base
            $sql = "SELECT z.*, e.nombre nombre_estado, u.nombre nombre_responsable, u.apellido apellido_responsable
                    FROM zoocriadero z
                    JOIN usuarios u ON z.responsable = u.id
                    JOIN zoocriadero_estado e ON z.id_estado = e.id_estado";

            // Agregar WHERE dinámico si hay filtros
            if (count($where) > 0) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            $sql .= " ORDER BY z.id_zoocriadero ASC";

            $zoocriaderos = $obj->select($sql);

            include_once '../view/zoocriaderos/filtro.php';
        }

        public function getTanquesByZoocriadero(){
            header('Content-Type: application/json');
            
            $obj = new ZoocriaderoModel();
            $id_zoocriadero = isset($_GET['id_zoocriadero']) ? intval($_GET['id_zoocriadero']) : 0;
            
            if($id_zoocriadero <= 0){
                echo json_encode(array('success' => false, 'message' => 'ID de zoocriadero inválido'));
                exit();
            }
            
            $sql_tanques = "SELECT t.id, t.nombre, t.cantidad_peces, t.medidas, t.id_tipo_tanque, tt.nombre as tipo_tanque, te.nombre as estado
                            FROM tanques t
                            LEFT JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id
                            LEFT JOIN tanque_estado te ON t.id_estado = te.id
                            WHERE t.id_zoocriadero = $id_zoocriadero
                            ORDER BY t.nombre";
            
            $tanques = $obj->select($sql_tanques);
            
            $tanques_array = array();
            
            if($tanques && pg_num_rows($tanques) > 0){
                while($tanque = pg_fetch_assoc($tanques)){
                    $tanques_array[] = array(
                        'id' => $tanque['id'],
                        'nombre' => $tanque['nombre'],
                        'tipo_tanque' => $tanque['tipo_tanque'] ? $tanque['tipo_tanque'] : 'N/A',
                        'cantidad_peces' => $tanque['cantidad_peces'],
                        'medidas' => $tanque['medidas'] ? $tanque['medidas'] : 'N/A',
                        'estado' => $tanque['estado'] ? $tanque['estado'] : 'N/A'
                    );
                }
            }
            
            echo json_encode(array('success' => true, 'tanques' => $tanques_array));
            exit();
        }
        
    }
?>