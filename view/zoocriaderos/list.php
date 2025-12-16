<link rel="stylesheet" href="assets/css/arregloTablas.css">

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Gestión de Zoocriaderos</h4>
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
                        <h4 class="card-title">Listado de Zoocriaderos</h4>
                        <?php if (tienePermiso('zoocriaderos', 'Registrar')): ?>
                        <a href="<?php echo getUrl("Mapa","Mapa","visualizarZoogit") ?>" class="btn btn-primary btn-round mx-4 text-right" >
                            <i class="fa fa-plus mx-2"></i> Nuevo Zoocriadero
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros de búsqueda -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="filtro" name="buscar" placeholder="Buscar..." data-url="<?php echo getUrl("Zoocriaderos","Zoocriadero","filtro", false, "ajax"); ?>">
                                <small class="form-text text-muted">Buscar por zoocriadero o responsable</small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2" id="comuna" name="comuna" data-url="<?php echo getUrl('Zoocriaderos','Zoocriadero','filtro', false, 'ajax'); ?>">
                                    <option value="">Todas las comunas</option> 
                                    <?php foreach ($comunas as $comuna): ?>
                                        <option value="<?php echo $comuna; ?>">
                                            <?php echo $comuna; ?>
                                        </option>
                                    <?php endforeach; ?>                                     
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2" id="estado" name="estado" data-url="<?php echo getUrl('Zoocriaderos','Zoocriadero','filtro', false, 'ajax'); ?>">
                                    <option value="">Todos los estados</option>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","lista") ?>" class="btn btn-secondary" onclick="resetFilters()">
                                <i class="fas fa-redo mx-1"></i> Limpiar filtros
                            </a>
                        </div>
                    </div>
                    
                    <!-- Tabla de resultados -->
                    <div class="table-responsive">
                        <table id="tableZoocriaderos" class="display table table-striped table-hover">                             
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Barrio</th>
                                    <th>Responsable</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                               <?php
                                    if ($zoocriaderos && pg_num_rows($zoocriaderos) > 0) {
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
                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detalles del Zoocriadero</h5>
                <button type="button" class="close" onclick="cerrarModalDetalles()" style="color:white;" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- Pestañas -->
                <ul class="nav nav-tabs" id="detalleTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="detalles-tab" href="javascript:void(0)" role="tab" aria-controls="detalles" aria-selected="true" onclick="cambiarPestaña('detalles')">
                            <i class="fas fa-info-circle"></i> Detalles
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tanques-tab" href="javascript:void(0)" role="tab" aria-controls="tanques" aria-selected="false" onclick="cambiarPestaña('tanques')">
                            <i class="fas fa-swimming-pool"></i> Tanques
                        </a>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content" id="detalleTabsContent">
                    <!-- Pestaña de Detalles -->
                    <div class="tab-pane fade show active" id="detalles" role="tabpanel" aria-labelledby="detalles-tab">
                        <div class="row mt-3">
                            <div class="col-md-6"><strong>Nombre: </strong> <p id="detalle-nombre"></p></div>
                            <div class="col-md-6"><strong>Comuna: </strong> <p id="detalle-comuna"></p></div>
                            <div class="col-md-6"><strong>Barrio: </strong> <p id="detalle-barrio"></p></div>
                            <div class="col-md-6"><strong>Direccion: </strong> <p id="detalle-direccion"></p></div>
                            <div class="col-md-6"><strong>Coordenadas: </strong> <p id="detalle-coordenadas"></p></div>
                            <div class="col-md-6"><strong>Responsable: </strong> <p id="detalle-responsable"></p></div>
                            <div class="col-md-6"><strong>Telefono: </strong> <p id="detalle-telefono"></p></div>
                            <div class="col-md-6"><strong>Correo: </strong> <p id="detalle-correo"></p></div>
                            <div class="col-md-6"><strong>Estado: </strong> <p id="detalle-estado"></p></div>                
                        </div>
                    </div>

                    <!-- Pestaña de Tanques -->
                    <div class="tab-pane fade" id="tanques" role="tabpanel" aria-labelledby="tanques-tab">
                        <div class="mt-3">
                            <div id="loading-tanques" class="text-center" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Cargando tanques...
                            </div>
                            <div id="lista-tanques">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Cantidad de Peces</th>
                                            <th>Medidas</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tanques-tbody">
                                        <tr>
                                            <td colspan="6" class="text-center">No hay tanques asociados</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
    document.getElementById('comuna').value = '';
    document.getElementById('estado').value = '';
    document.getElementById('filtro').value = '';
}


// Función para abrir la modal
function abrirModalDetalles(btn) {

    //datos usando query
    var id = $(btn).data('id') || '0';
    var nombre = $(btn).data('nombre') || '0';
    var responsable = $(btn).data('responsable') || '0';
    var direccion = $(btn).data('direccion') || '0';
    var coordenadas = $(btn).data('coordenadas') || '0';
    var comuna = $(btn).data('comuna') || '0';
    var barrio = $(btn).data('barrio') || '0';
    var telefono = $(btn).data('telefono') || '0';
    var correo = $(btn).data('correo') || '0';
    var estado = $(btn).data('estado') || '0';
    
    // Actualizar contenido de detalles
    $('#detalle-nombre').text(nombre);
    $('#detalle-responsable').text(responsable);
    $('#detalle-comuna').text(comuna);
    $('#detalle-barrio').text(barrio);
    $('#detalle-direccion').text(direccion);
    $('#detalle-coordenadas').text(coordenadas);
    $('#detalle-telefono').text(telefono);
    $('#detalle-correo').text(correo);
    $('#detalle-estado').text(estado);
    
    // Resetear pestañas - mostrar la primera pestaña
    cambiarPestaña('detalles');
    
    // Limpiar tabla de tanques
    $('#tanques-tbody').html('<tr><td colspan="6" class="text-center">No hay tanques asociados</td></tr>');
    
    // Guardar el ID para cargar tanques cuando se cambie de pestaña
    $('#modalDetalles').data('id-zoocriadero', id);
    
    $('#modalDetalles').modal('show');
}

// Función para cargar los tanques
function cargarTanques(idZoocriadero) {
    if(!idZoocriadero || idZoocriadero == '0') {
        $('#tanques-tbody').html('<tr><td colspan="6" class="text-center">ID de zoocriadero inválido</td></tr>');
        return;
    }
    
    $('#loading-tanques').show();
    $('#lista-tanques').hide();
    
    $.ajax({
        url: '<?php echo getUrl("Zoocriaderos", "Zoocriadero", "getTanquesByZoocriadero", false, "ajax"); ?>',
        type: 'GET',
        data: { id_zoocriadero: idZoocriadero },
        dataType: 'json',
        success: function(response) {
            $('#loading-tanques').hide();
            $('#lista-tanques').show();
            
            if(response.success && response.tanques && response.tanques.length > 0) {
                var html = '';
                response.tanques.forEach(function(tanque) {
                    html += '<tr>';
                    html += '<td>' + tanque.id + '</td>';
                    html += '<td>' + tanque.nombre + '</td>';
                    html += '<td>' + tanque.tipo_tanque + '</td>';
                    html += '<td>' + tanque.cantidad_peces + '</td>';
                    html += '<td>' + tanque.medidas + '</td>';
                    html += '<td>' + tanque.estado + '</td>';
                    html += '</tr>';
                });
                $('#tanques-tbody').html(html);
            } else {
                $('#tanques-tbody').html('<tr><td colspan="6" class="text-center">No hay tanques asociados a este zoocriadero</td></tr>');
            }
        },
        error: function() {
            $('#loading-tanques').hide();
            $('#lista-tanques').show();
            $('#tanques-tbody').html('<tr><td colspan="6" class="text-center text-danger">Error al cargar los tanques</td></tr>');
        }
    });
}

// Función para cambiar de pestaña
function cambiarPestaña(pestaña) {
    // Remover clase active de todas las pestañas
    $('#detalleTabs .nav-link').removeClass('active');
    $('#detalleTabsContent .tab-pane').removeClass('show active');
    
    // Agregar clase active a la pestaña seleccionada
    if(pestaña === 'detalles') {
        $('#detalles-tab').addClass('active');
        $('#detalles').addClass('show active');
    } else if(pestaña === 'tanques') {
        $('#tanques-tab').addClass('active');
        $('#tanques').addClass('show active');
        
        // Cargar tanques cuando se activa la pestaña
        var idZoocriadero = $('#modalDetalles').data('id-zoocriadero');
        if(idZoocriadero && idZoocriadero != '0') {
            cargarTanques(idZoocriadero);
        }
    }
}

// cerrar la modal
function cerrarModalDetalles() {
    $('#modalDetalles').modal('hide');
}

</script>