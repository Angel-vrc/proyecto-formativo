<?php
    while($usuario = pg_fetch_assoc($usuarios)){
        echo "<tr>";
            echo "<td>".$usuario['id']."</td>";
            echo "<td>".$usuario['nombre']."</td>";
            echo "<td>".$usuario['apellido']."</td>";
            echo "<td>".$usuario['telefono']."</td>";
            echo "<td>".$usuario['rol_nombre']."</td>";
            echo "<td>";
                if (tienePermiso('usuarios', 'Consultar')) {
                    echo "<button type='button' class='btn btn-info mx-2' onclick='abrirModalDetalles(this)'
                        data-nombre='".$usuario['nombre']."'
                        data-apellido='".$usuario['apellido']."'
                        data-documento='".$usuario['documento']."'
                        data-telefono='".$usuario['telefono']."'
                        data-correo='".$usuario['correo']."'
                        data-rol='".$usuario['rol_nombre']."'
                        data-estado ='".$usuario['estado_nombre']."'>
                        Ver Detalles
                    </button>";
                }

                if (tienePermiso('usuarios', 'Actualizar')) {
                    echo "<a href='".getUrl("Usuarios", "Usuario", "getUpdate", array("id"=>$usuario['id']))."' class='btn btn-primary mx-2'>Editar</a>";
                }

                if ($usuario['id_estado'] == 1) {
                    if (tienePermiso('usuarios', 'Eliminar')) {
                        echo "<a href='".getUrl("Usuarios","Usuario","getDelete",array("id"=>$usuario['id']))."' class='btn btn-danger'>Eliminar</a>";
                    }
                } elseif ($usuario['id_estado'] == 2) {
                    if (tienePermiso('usuarios', 'Activar')) {
                        echo "<a href='".getUrl("Usuarios","Usuario","updateStatus",array("id"=>$usuario['id']))."' class='btn btn-success'>Activar</a>";
                    }
                }                          
            echo "</td>";
        echo "</tr>";
    }
    $c = pg_num_rows($usuarios);
?>