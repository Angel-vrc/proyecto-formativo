<?php
    while($rol = pg_fetch_assoc($roles)){
        echo "<tr>";
            echo "<td>".$rol['id']."</td>";
            echo "<td>".$rol['nombre']."</td>";
            echo "<td>";
                if (tienePermiso('roles', 'Consultar')) {
                    echo "<button type='button' class='btn btn-info mx-2' onclick='abrirModalDetalles(this)'
                        data-id='".$rol['id']."'
                        data-nombre='".$rol['nombre']."'
                        data-estado ='".$rol['estado_nombre']."'>
                        Ver Detalles
                    </button>";
                }

                if (tienePermiso('roles', 'Actualizar')) {
                    echo "<a href='".getUrl("Roles", "Rol", "getUpdate", array("id"=>$rol['id']))."' class='btn btn-primary mx-2'>Editar</a>";
                }

                if ($rol['id_estado'] == 1) {
                    if (tienePermiso('roles', 'Eliminar')) {
                        echo "<a href='".getUrl("Roles","Rol","getDelete",array("id"=>$rol['id']))."' class='btn btn-danger'>Eliminar</a>";
                    }
                } elseif ($rol['id_estado'] == 2) {
                    if (tienePermiso('roles', 'Activar')) {
                        echo "<a href='".getUrl("Roles","Rol","updateStatus",array("id"=>$rol['id']))."' class='btn btn-success'>Activar</a>";
                    }
                }                          
            echo "</td>";
        echo "</tr>";
    }   
    $c = pg_num_rows($roles);
?>