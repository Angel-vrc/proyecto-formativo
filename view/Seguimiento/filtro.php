<?php
    while($seg = pg_fetch_assoc($seguimientos)){    
                                    $fecha_formato = ($seg['fecha_seguimiento']) && $seg['fecha_seguimiento'] ? date('d/m/Y', strtotime($seg['fecha_seguimiento'])) : 'N/A';
                                    $nombre_tanque = $seg['nombre_tanque'] ? $seg['nombre_tanque'] : 'N/A';
                                    // Mostrar tanque con su tipo si existe
                                    if(!empty($seg['nombre_tipo_tanque'])){
                                        $nombre_tanque .= ' - ' . $seg['nombre_tipo_tanque'];
                                    }

                                    echo "<tr>";
                                        echo "<td>".$seg['id']."</td>";
                                        echo "<td>".$fecha_formato."</td>";
                                        echo "<td>".$nombre_tanque."</td>";
                                        echo "<td>".($seg['nombre_actividad'] ? $seg['nombre_actividad'] : 'N/A')."</td>";
                                        echo "<td>".substr($seg['observaciones'], 0, 30).(($seg['observaciones']) > 30 ? '...' : '')."</td>";
                                        
                                        echo "<td>";

                                            if (tienePermiso('seguimiento', 'Actualizar')) {
                                                echo "<a href='".getUrl("Seguimiento","Seguimiento","getUpdate",array("id"=>$seg['id']))."' class='btn btn-primary mx-2'>Editar</a>";
                                            }

                                            if (isset($seg['estado_id']) && $seg['estado_id'] == 1) {
                                                if (tienePermiso('seguimiento', 'Eliminar')) {
                                                    echo "<a href='".getUrl("Seguimiento","Seguimiento","getDelete",array("id"=>$seg['id']))."' class='btn btn-danger mx-2'>Eliminar</a>";
                                                }
                                            } elseif ($seg['estado_id'] == 2) {
                                                if (tienePermiso('seguimiento', 'Eliminar')) {
                                                    echo "<a href='".getUrl("Seguimiento","Seguimiento","updateStatus",array("id"=>$seg['id']))."' class='btn btn-success mx-2'>Activar</a>";
                                                }
                                            }

                                            // ---- Ver Detalles ----
                                            if (tienePermiso('seguimiento', 'Consultar')) {
                                                echo "<button type='button' class='btn btn-info mx-2' onclick='abrirModalDetalles(this)'
                                                    data-ph='".$seg['ph']."'
                                                    data-temperatura='".$seg['temperatura']."'
                                                    data-cloro='".$seg['cloro']."'
                                                    data-alevines='".$seg['num_alevines']."'
                                                    data-muertes='".$seg['num_muertes']."'
                                                    data-machos='".$seg['num_machos']."'
                                                    data-hembras='".$seg['num_hembras']."'
                                                    data-total='".$seg['total']."'>
                                                    Ver Detalles
                                                </button>";
                                            }
                                        echo "</td>";
                                    echo "</tr>";
                                }
    $c = pg_num_rows($seguimientos);
?>