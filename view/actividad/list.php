<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tipo de Actividad</h4>
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
                        <h4 class="card-title">Listado de Tipos de Actividad</h4>
                        <a href="<?php echo getUrl("Actividad","Activida","getCreate") ?>" class="btn btn-primary btn-round mx-4 text-right" >
                            <i class="fa fa-plus mx-2"></i> Nuevo tipo de actividad
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
                        <div class="col-md-3 offset-md-5 mt-2">
                            <button class="btn btn-secondary" onclick="resetFilters()">
                                <i class="fas fa-redo mx-1"></i> Limpiar filtros
                            </button>
                        </div>
                    </div>
                    <!-- Tabla de resultados -->
                    <div class="table-responsive">
                        <table id="tableActividad" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                               <?php
                                    while($tipo = pg_fetch_assoc($tipos)){
                                        echo "<tr>";
                                            echo "<td>".$tipo['id']."</td>";
                                            echo "<td>".$tipo['nombre']."</td>";
                                            echo "<td>";
                                                echo "<a href='".getUrl("Actividad", "Activida", "getUpdate", array("id"=>$tipo['id']))."' class='btn btn-primary mx-2'>Editar</a>";
                                                if ($tipo['estado'] == 1) {
                                                    echo "<a href='".getUrl("Actividad", "Activida","getDelete",array("id"=>$tipo['id']))."' class='btn btn-danger'>Eliminar</a>";

                                                } elseif ($tipo['estado'] == 2) {
                                                    echo "<a href='".getUrl("Actividad", "Activida","updateStatus",array("id"=>$tipo['id']))."' class='btn btn-success'>Activar</a>";
                                                }
                                            echo "</td>";
                                        echo "</tr>";
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
                                Mostrando 0 registros
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