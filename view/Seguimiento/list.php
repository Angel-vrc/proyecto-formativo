<link rel="stylesheet" href="assets/css/arregloTablas.css">

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Gestión de Seguimiento</h4>
    </div>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo ($_SESSION['success']); unset($_SESSION['success']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            </button>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo ($_SESSION['error']); unset($_SESSION['error']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            </button>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="" style="display:flex; justify-content: space-between;">
                        <h4 class="card-title">Listado de Seguimiento</h4>
                        <?php if (tienePermiso('seguimiento', 'Registrar')): ?>
                        <a href="<?php echo getUrl("Seguimiento","Seguimiento","getCreate") ?>" class="btn btn-primary btn-round mx-4 text-right" >
                            <i class="fa fa-plus mx-2"></i> Nuevo Seguimiento
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">

                    <!-- FILTROS -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text"
                                class="form-control"
                                id="filtro"
                                name="buscar"
                                placeholder="Buscar por tanque, actividad o fecha"
                                data-url="<?php echo getUrl("Seguimiento","Seguimiento","filtro", false, "ajax"); ?>">
                        </div>
                    </div>

                    <div class="col-md-3 mt-2">
                        <button class="btn btn-secondary" onclick="resetFilters()">
                            <i class="fas fa-redo mx-1"></i> Limpiar filtro
                        </button>
                    </div>
                </div>

                    
                    <!-- TABLA -->
                    <div class="table-responsive">
                        <table id="tableSeguimientos" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Tanque</th>
                                    <th>Actividad</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody id="tableBody">
                            <?php
                                if ($seguimientos && pg_num_rows($seguimientos) > 0) {
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
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No se encontraron registros</td></tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="dataTables_info" id="info" role="status" aria-live="polite">
                                <?php echo isset($infoPaginacion) ? $infoPaginacion : 'Mostrando 0 registros'; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dataTables_paginate paging_simple_numbers" id="pagination">
                                <?php echo isset($htmlPaginacion) ? $htmlPaginacion : ''; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="modalDetallesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background-color:#1a5a5a; color:white;">
                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detalles del Seguimiento</h5>
                <button type="button" class="close" onclick="cerrarModalDetalles()" style="color:white;">
                   
                </button>
            </div>

            <div class="modal-body">

                <!-- DATOS -->
                <div class="row">
                    <div class="col-md-6"><strong>pH:</strong> <p id="detalle-ph"></p></div>
                    <div class="col-md-6"><strong>Temperatura:</strong> <p id="detalle-temperatura"></p></div>
                    <div class="col-md-6"><strong>Cloro:</strong> <p id="detalle-cloro"></p></div>
                    <div class="col-md-6"><strong>Alevines:</strong> <p id="detalle-alevines"></p></div>
                    <div class="col-md-6"><strong>Muertes:</strong> <p id="detalle-muertes"></p></div>
                    <div class="col-md-6"><strong>Machos:</strong> <p id="detalle-machos"></p></div>
                    <div class="col-md-6"><strong>Hembras:</strong> <p id="detalle-hembras"></p></div>
                    <div class="col-md-6"><strong>Total:</strong> <p id="detalle-total"></p></div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cerrarModalDetalles()">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<script>
function resetFilters() {
    document.getElementById('searchNombre').value = '';
    document.getElementById('searchNumeroTanque').value = '';
    document.getElementById('searchFecha').value = '';
}

// Función para abrir la modal
function abrirModalDetalles(btn) {
    //datos usando query
    var ph = $(btn).data('ph') || '0';
    var temperatura = $(btn).data('temperatura') || '0';
    var cloro = $(btn).data('cloro') || '0';
    var alevines = $(btn).data('alevines') || '0';
    var muertes = $(btn).data('muertes') || '0';
    var machos = $(btn).data('machos') || '0';
    var hembras = $(btn).data('hembras') || '0';
    var total = $(btn).data('total') || '0';
    
    // Actualizar contenido
    $('#detalle-ph').text(ph);
    $('#detalle-temperatura').text(temperatura + ' °C');
    $('#detalle-cloro').text(cloro + ' mg/L');
    $('#detalle-alevines').text(alevines);
    $('#detalle-muertes').text(muertes);
    $('#detalle-machos').text(machos);
    $('#detalle-hembras').text(hembras);
    $('#detalle-total').text(total);
    
    $('#modalDetalles').modal('show');
}

// cerrar la modal
function cerrarModalDetalles() {
    $('#modalDetalles').modal('hide');
}

</script>
