<?php
    while($zoo = pg_fetch_assoc($zoocriaderos)){
        echo "<tr>";
            echo "<td>".$zoo['id_zoocriadero']."</td>";
            echo "<td>".$zoo['nombre']."</td>";
            echo "<td>".$zoo['direccion']."</td>";
            echo "<td>".$zoo['barrio']."</td>";
            echo "<td>".$zoo['nombre_responsable']." ".$zoo['apellido_responsable']."</td>";
            echo "<td>";
                if (tienePermiso('zoocriaderos', 'Consultar')) {
                    echo "<button type='button' class='btn btn-info mx-2' onclick='abrirModalDetalles(this)'
                        data-id='".$zoo['id_zoocriadero']."'
                        data-nombre='".$zoo['nombre']."'
                        data-comuna='".$zoo['comuna']."'
                        data-barrio='".$zoo['barrio']."'
                        data-direccion='".$zoo['direccion']."'
                        data-coordenadas='".$zoo['coordenadas']."'
                        data-responsable='".$zoo['nombre_responsable']."'
                        data-telefono='".$zoo['telefono']."'
                        data-correo='".$zoo['correo']."'
                        data-estado='".$zoo['nombre_estado']."'>
                        Ver Detalles
                    </button>";
                }

                if (tienePermiso('zoocriaderos', 'Actualizar')) {
                    echo "<a href='".getUrl("Zoocriaderos", "Zoocriadero", "getUpdate", array("id"=>$zoo['id_zoocriadero']))."' class='btn btn-primary mx-2'>Editar</a>";
                }

                if ($zoo['id_estado'] == 1) {
                    if (tienePermiso('zoocriaderos', 'Eliminar')) {
                        echo "<a href='".getUrl("Zoocriaderos","Zoocriadero","getDelete",array("id"=>$zoo['id_zoocriadero']))."' class='btn btn-danger'>Eliminar</a>";
                    }
                } elseif ($zoo['id_estado'] == 2) {
                    if (tienePermiso('zoocriaderos', 'Eliminar')) {
                        echo "<a href='".getUrl("Zoocriaderos","Zoocriadero","updateStatus",array("id"=>$zoo['id_zoocriadero']))."' class='btn btn-success'>Activar</a>";
                    }
                }                          
            echo "</td>";
        echo "</tr>";
    }
    $c = pg_num_rows($zoocriaderos);
?>