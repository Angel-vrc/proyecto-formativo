<link rel="stylesheet" href="assets/css/arregloTablas.css">

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Gestión de Usuarios</h4>
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
                        <h4 class="card-title">Listado de Usuarios</h4>
                        <?php if (tienePermiso('usuarios', 'Registrar')): ?>
                        <a href="<?php echo getUrl("Usuarios","Usuario","getCreate") ?>" class="btn btn-primary btn-round mx-4 text-right" >
                            <i class="fa fa-plus mx-2"></i> Nuevo Usuario
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros de búsqueda -->
                    <div class="row mb-3">                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="filtro" name="buscar" placeholder="Buscar por nombre..." data-url="<?php echo getUrl("Usuarios","Usuario","filtro", false, "ajax"); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabla de resultados -->
                    <div class="table-responsive">
                        <table id="tableUsuarios" class="display table table-striped table-hover">                             
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Telefono</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                               <?php
                                    if ($usuarios && pg_num_rows($usuarios) > 0) {
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
                                                        if (tienePermiso('usuarios', 'Eliminar')) {
                                                            echo "<a href='".getUrl("Usuarios","Usuario","updateStatus",array("id"=>$usuario['id']))."' class='btn btn-success'>Activar</a>";
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
                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detalles del Usuario</h5>
                <button type="button" class="close" onclick="cerrarModalDetalles()" style="color:white;">
                   
                </button>
            </div>

            <div class="modal-body">

                <!-- DATOS -->
                <div class="row">
                    <div class="col-md-6"><strong>Nombre: </strong> <p id="detalle-nombre"></p></div>
                    <div class="col-md-6"><strong>Apellido: </strong> <p id="detalle-apellido"></p></div>
                    <div class="col-md-6"><strong>Documento: </strong> <p id="detalle-documento"></p></div>
                    <div class="col-md-6"><strong>Telefono: </strong> <p id="detalle-telefono"></p></div>
                    <div class="col-md-6"><strong>Correo: </strong> <p id="detalle-correo"></p></div>
                    <div class="col-md-6"><strong>Rol: </strong> <p id="detalle-rol"></p></div>
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

// Función para abrir la modal
function abrirModalDetalles(btn) {

    //datos usando query
    var nombre = $(btn).data('nombre') || '0';
    var apellido = $(btn).data('apellido') || '0';
    var documento = $(btn).data('documento') || '0';
    var telefono = $(btn).data('telefono') || '0';
    var correo = $(btn).data('correo') || '0';
    var estado = $(btn).data('estado') || '0';
    var rol = $(btn).data('rol') || '0';
    
    // Actualizar contenido
    $('#detalle-nombre').text(nombre);
    $('#detalle-apellido').text(apellido);
    $('#detalle-documento').text(documento);
    $('#detalle-telefono').text(telefono);
    $('#detalle-correo').text(correo);
    $('#detalle-rol').text(rol);
    $('#detalle-estado').text(estado);
    
    $('#modalDetalles').modal('show');
}

// cerrar la modal
function cerrarModalDetalles() {
    $('#modalDetalles').modal('hide');
}

</script>