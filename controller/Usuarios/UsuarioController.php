<?php

    include_once '../model/Usuarios/UsuarioModel.php';

    class UsuarioController{

        public function lista(){
            $obj = new UsuarioModel();
            $connect = $obj->getConnect();

            $id = $_SESSION['usuario_id'];

            // Calcular parámetros de paginación (10 registros por página)
            $paginacion = calcularPaginacion(10);

            // Consulta SQL base (sin LIMIT)
            $sqlBase = "SELECT u.*, r.nombre rol_nombre, e.nombre estado_nombre 
                        FROM usuarios u, roles r, usuario_estado e 
                        WHERE u.id_rol = r.id AND u.id_estado = e.id_estado AND u.id<>$id 
                        ORDER BY u.id ASC";

            // Obtener total de registros
            $totalRegistros = obtenerTotalRegistros($connect, $sqlBase);

            // Aplicar paginación a la consulta
            $sql = aplicarPaginacionSQL($sqlBase, $paginacion['limite'], $paginacion['offset']);

            // Ejecutar consulta paginada
            $usuarios = $obj->select($sql);

            // Generar HTML de paginación
            $parametros = array(
                'modulo' => isset($_GET['modulo']) ? $_GET['modulo'] : 'Usuarios',
                'controlador' => isset($_GET['controlador']) ? $_GET['controlador'] : 'Usuario',
                'funcion' => isset($_GET['funcion']) ? $_GET['funcion'] : 'lista'
            );

            $htmlPaginacion = generarPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina'], $parametros);
            $infoPaginacion = generarInfoPaginacion($totalRegistros, $paginacion['pagina'], $paginacion['registrosPorPagina']);

            include_once '../view/usuarios/list.php';
        }

        public function getCreate(){
            $obj = new UsuarioModel();

            $sql = "SELECT * FROM roles ORDER BY nombre ASC";
            $roles = $obj->select($sql);

            include_once '../view/usuarios/create.php';
        }

        public function postCreate(){
            $obj = new UsuarioModel();

            $id = $obj->autoincrement('usuarios', 'id');
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $documento = $_POST['documento'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $rol = $_POST['rol'];
            $password = str_replace(' ', '', $nombre.$documento);
            $hash = md5($password);

            $sql = "INSERT INTO usuarios VALUES ($id, '$nombre','$apellido','$documento','$correo','$telefono','$hash', $rol,1)";

            $resultado = $obj->insert($sql);

            if($resultado){
                $_SESSION['success'] = "Usuario creado correctamente";
                $_SESSION['pass'] = "La contraseña del nuevo usuario es: ".$password;
                redirect(getUrl("Usuarios","Usuario","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al crear el usuario";
                redirect(getUrl("Usuarios","Usuario","lista"));
                exit();
            }
        }

        public function getUpdate(){
            $obj = new UsuarioModel();

            $id = $_GET['id'];
            $sql = "SELECT * FROM usuarios WHERE id=$id";
            $usuario = pg_fetch_assoc($obj->select($sql));

            $sql = "SELECT * FROM roles ORDER BY nombre ASC";
            $roles = $obj->select($sql);

            include_once '../view/usuarios/update.php';

        }

        public function postUpdate(){
            $obj = new UsuarioModel();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $documento = $_POST['documento'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $rol = $_POST['rol'];

            $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', documento='$documento', correo='$correo',telefono='$telefono', id_rol=$rol WHERE id=$id";


            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Usuario actualizado correctamente";
                redirect(getUrl("Usuarios","Usuario","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al actualizar el usuario";
                redirect(getUrl("Usuarios","Usuario","lista"));
                exit();
            }
        }

       public function getDelete(){
            $obj = new UsuarioModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Usuarios","Usuario","lista"));
                return;
            }

            $sql = "SELECT u.id, u.nombre, u.apellido, u.telefono, u.id_estado, u.id_rol, e.nombre estado_nombre, r.nombre rol_nombre FROM usuarios u, usuario_estado e, roles r WHERE u.id=$id AND u.id_rol=r.id AND u.id_estado=e.id_estado";

            $usuario = pg_fetch_assoc($obj->select($sql));

            if(!$usuario){
                echo "El usuario solicitado no existe";
            }

            include_once '../view/usuarios/delete.php';
        }

        public function postDelete(){
            $obj = new UsuarioModel();

            $id = ($_POST['id']);

            $sql = "UPDATE usuarios SET id_estado = 2 WHERE id = $id";

            $resultado = $obj->update($sql);
            
            if($resultado){
                $_SESSION['success'] = "Usuario deshabilitado correctamente";
                redirect(getUrl("Usuarios","Usuario","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al deshabilitar el usuario";
                redirect(getUrl("Usuarios","Usuario","lista"));
                exit();
            }

        }

        public function updateStatus(){
            $obj = new UsuarioModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Usuarios","Usuario","lista"));
                return;
            }

            $sql = "UPDATE usuarios SET id_estado=1 WHERE id=$id";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Usuario habilitado correctamente";
                redirect(getUrl("Usuarios","Usuario","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al habilitar el usuario";
                redirect(getUrl("Usuarios","Usuario","lista"));
                exit();
            }
        }

        public function filtro(){
            $obj = new UsuarioModel();

            $id = $_SESSION['usuario_id'];

            $buscar = $_GET['buscar'];
            $sql = "SELECT u.*, r.nombre rol_nombre, e.nombre estado_nombre FROM usuarios u, roles r, usuario_estado e WHERE u.id_rol = r.id AND u.id_estado = e.id_estado AND u.id<>$id AND (u.nombre ILIKE '%$buscar%' OR u.apellido ILIKE '%$buscar%' OR e.nombre LIKE '%$buscar%') ORDER BY u.id ASC";

            $usuarios = $obj->select($sql);

            include_once '../view/usuarios/filtro.php';
        }

    }

?>