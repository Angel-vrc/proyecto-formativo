<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Gestión de Roles</h4>
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
                        <h4 class="card-title">Listado de Roles</h4>
<<<<<<< HEAD
                        <?php if (tienePermiso('roles', 'Registrar')): ?>
                        <a href="<?php echo getUrl("Roles","Rol","getCreate") ?>" class="btn btn-primary btn-round mx-4 text-right" >
                            <i class="fa fa-plus mx-2"></i> Nuevo Rol
                        </a>
                        <?php endif; ?>
=======
                        <a href="<?php echo getUrl("Roles","Rol","getCreate") ?>" class="btn btn-primary btn-round mx-4 text-right" >
                            <i class="fa fa-plus mx-2"></i> Nuevo Rol
                        </a>
>>>>>>> 2428391635581db5217d5f31225b04defed0c745
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros de búsqueda -->
                    <div class="row mb-3">                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="filtro" name="buscar" placeholder="Buscar por nombre o estado" data-url="<?php echo getUrl("Roles","Rol","filtro", false, "ajax"); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabla de resultados -->
                    <div class="table-responsive">
                        <table id="tableRoles" class="display table table-striped table-hover">                             
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                               <?php
                                    if ($roles && pg_num_rows($roles) > 0) {
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
                                                        if (tienePermiso('roles', 'Eliminar')) {
                                                            echo "<a href='".getUrl("Roles","Rol","updateStatus",array("id"=>$rol['id']))."' class='btn btn-success'>Activar</a>";
                                                        }
                                                    }                          
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='text-center'>No se encontraron registros</td></tr>";
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
                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detalles del Rol</h5>
                <button type="button" class="close" onclick="cerrarModalDetalles()" style="color:white;">
                   
                </button>
            </div>

            <div class="modal-body">

                <!-- DATOS -->
                <div class="row">
                    <div class="col-md-6"><strong>Nombre: </strong> <p id="detalle-nombre"></p></div>
                    <div class="col-md-6"><strong>Estado: </strong> <p id="detalle-estado"></p></div>                
                </div>

                <hr>

                <h5><i class="fas fa-lock"></i> Permisos del Rol</h5>

                <div id="contenedorPermisos">
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

    function abrirModalDetalles(btn) {

        var idRol = $(btn).data('id');
        var nombre = $(btn).data('nombre');
        var estado = $(btn).data('estado');

        $('#detalle-nombre').text(nombre);
        $('#detalle-estado').text(estado);

        $('#modalDetalles').modal('show');

        cargarPermisosRol(idRol);
    }

    function cerrarModalDetalles() {
        $('#modalDetalles').modal('hide');
    }

</script>