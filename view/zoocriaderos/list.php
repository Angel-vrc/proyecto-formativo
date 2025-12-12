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
                        <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","getCreate") ?>" class="btn btn-primary btn-round mx-4 text-right" >
                            <i class="fa fa-plus mx-2"></i> Nuevo Zoocriadero
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros de búsqueda -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="searchNombre" placeholder="Buscar por nombre...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control select2" id="comuna" name="comuna" required>
                                    <option value="">Todas las comunas</option> 
                                    <?php foreach ($comunas as $comuna): ?>
                                        <option value="<?php echo $comuna; ?>">
                                            <?php echo $comuna; ?>
                                        </option>
                                    <?php endforeach; ?>                                     
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="searchResponsable" placeholder="Buscar por responsable...">
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <button class="btn btn-secondary" onclick="resetFilters()">
                                <i class="fas fa-redo mx-1"></i> Limpiar filtros
                            </button>
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
                                    while($zoo = pg_fetch_assoc($zoocriaderos)){
                                        echo "<tr>";
                                            echo "<td>".$zoo['id_zoocriadero']."</td>";
                                            echo "<td>".$zoo['nombre']."</td>";
                                            echo "<td>".$zoo['direccion']."</td>";
                                            echo "<td>".$zoo['barrio']."</td>";
                                            echo "<td>".$zoo['nombre_responsable']." ".$zoo['apellido_responsable']."</td>";
                                            echo "<td>";
                                                echo "<button type='button' class='btn btn-info mx-2' onclick='abrirModalDetalles(this)'
                                                    data-nombre='".$zoo['nombre']."'
                                                    data-barrio='".$zoo['barrio']."'
                                                    data-direccion='".$zoo['direccion']."'
                                                    data-responsable='".$zoo['nombre_responsable']."'
                                                    data-telefono='".$zoo['telefono']."'
                                                    data-correo='".$zoo['correo']."'
                                                    data-estado='".$zoo['nombre_estado']."'>
                                                    Ver Detalles
                                                </button>";

                                                echo "<a href='".getUrl("Zoocriaderos", "Zoocriadero", "getUpdate", array("id"=>$zoo['id_zoocriadero']))."' class='btn btn-primary mx-2'>Editar</a>";

                                                if ($zoo['id_estado'] == 1) {
                                                    echo "<a href='".getUrl("Zoocriaderos","Zoocriadero","getDelete",array("id"=>$zoo['id_zoocriadero']))."' class='btn btn-danger'>Eliminar</a>";

                                                } elseif ($zoo['id_estado'] == 2) {
                                                    echo "<a href='".getUrl("Zoocriaderos","Zoocriadero","updateStatus",array("id"=>$zoo['id_zoocriadero']))."' class='btn btn-success'>Activar</a>";
                                                }                          
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    $c = pg_num_rows($zoocriaderos);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="dataTables_info" id="info" role="status" aria-live="polite">
                                Mostrando <?php echo $c?> registros
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dataTables_paginate paging_simple_numbers" id="pagination">
                                <!-- Paginación se generará dinámicamente -->
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
                    <div class="col-md-6"><strong>Nombre: </strong> <p id="detalle-nombre"></p></div>
                    <div class="col-md-6"><strong>Barrio: </strong> <p id="detalle-barrio"></p></div>
                    <div class="col-md-6"><strong>Direccion: </strong> <p id="detalle-direccion"></p></div>
                    <div class="col-md-6"><strong>Responsable: </strong> <p id="detalle-responsable"></p></div>
                    <div class="col-md-6"><strong>Telefono: </strong> <p id="detalle-telefono"></p></div>
                    <div class="col-md-6"><strong>Correo: </strong> <p id="detalle-correo"></p></div>
                    <div class="col-md-6"><strong>Estado: </strong> <p id="detalle-estado"></p></div>                
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
    var nombre = $(btn).data('nombre') || '0';
    var responsable = $(btn).data('responsable') || '0';
    var direccion = $(btn).data('direccion') || '0';
    var barrio = $(btn).data('barrio') || '0';
    var responsable = $(btn).data('responsable') || '0';
    var telefono = $(btn).data('telefono') || '0';
    var correo = $(btn).data('correo') || '0';
    var estado = $(btn).data('estado') || '0';
    
    // Actualizar contenido
    $('#detalle-nombre').text(nombre);
    $('#detalle-responsable').text(responsable);
    $('#detalle-barrio').text(barrio);
    $('#detalle-direccion').text(direccion);
    $('#detalle-responsable').text(responsable);
    $('#detalle-telefono').text(telefono);
    $('#detalle-correo').text(correo);
    $('#detalle-estado').text(estado);
    
    $('#modalDetalles').modal('show');
}

// cerrar la modal
function cerrarModalDetalles() {
    $('#modalDetalles').modal('hide');
}

</script>