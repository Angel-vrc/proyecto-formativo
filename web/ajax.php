<?php

    include_once '../lib/helpers.php';

    if (isset($_GET['accion'])) {
        resolveAjax();
    }

    function resolveAjax() {
        switch ($_GET['accion']) {

            case 'getPermisosRoles':
                getPermisosRoles();
                break;
        }
    }

    function getPermisosRoles(){
        include_once '../model/Roles/RolModel.php';

        $obj = new RolModel();

        $idRol = $_GET['id_rol'];

        

        $sql = "SELECT p.*, m.nombre modulo, a.nombre accion FROM permisos p, modulos m, acciones a WHERE p.id_roles = $idRol AND p.id_modulos = m.id AND p.id_acciones = a.id ORDER BY m.id ASC";

        $permisos = $obj->select($sql);

        $data = array();
        while ($row = pg_fetch_assoc($permisos)) {
            $data[$row['modulo']][] = $row['accion'];
        }

        foreach ($data as $modulo => $acciones) {
            echo "<div class='mb-3'>";
            echo "<h6 class='fw-bold'>$modulo</h6>";
            echo "<div class='d-flex flex-wrap gap-2'>";

            foreach ($acciones as $accion) {
                echo "<span>$accion</span>";
            }

            echo "</div>";
            echo "</div>";
        }
    }

?>