<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Gestión de Zoocriaderos</h4>
    </div>
    
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
                                <select class="form-control" id="filterComuna">
                                    <option value="">Todas las comunas</option>
                                    <option value="Comuna 1">Comuna 1</option>
                                    <option value="Comuna 2">Comuna 2</option>
                                    <option value="Comuna 3">Comuna 3</option>
                                    <!-- Agregar más opciones -->
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
                                    <th>Comuna</th>
                                    <th>Barrio</th>
                                    <th>Responsable</th>
                                    <!-- <th>Teléfono</th> -->
                                    <!-- <th>Correo</th> -->
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                               <?php
                                    while($zoo = pg_fetch_assoc($zoocriaderos)){
                                        echo "<tr>";
                                            echo "<td>".$zoo['id']."</td>";
                                            echo "<td>".$zoo['nombre']."</td>";
                                            echo "<td>".$zoo['direccion']."</td>";
                                            echo "<td>".$zoo['comuna']."</td>";
                                            echo "<td>".$zoo['barrio']."</td>";
                                            echo "<td>".$zoo['responsable']."</td>";
                                            // echo "<td>".$zoo['telefono']."</td>";
                                            // echo "<td>".$zoo['correo']."</td>";
                                            echo "<td>";
                                                echo "<a href='".getUrl("Zoocriaderos", "Zoocriadero", "getUpdate", array("id"=>$zoo['id']))."' class='btn btn-primary mx-2'>Editar</a>";

                                                if ($zoo['estado'] == 1) {
                                                    echo "<a href='".getUrl("Zoocriaderos","Zoocriadero","getDelete",array("id"=>$zoo['id']))."' class='btn btn-danger'>Eliminar</a>";

                                                } elseif ($zoo['estado'] == 2) {
                                                    echo "<a href='".getUrl("Zoocriaderos","Zoocriadero","updateStatus",array("id"=>$zoo['id']))."' class='btn btn-success'>Activar</a>";
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

<!-- Modal para confirmar eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea eliminar este zoocriadero? Esta acción no se puede deshacer.
                <input type="hidden" id="deleteId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
            </div>
        </div>
    </div>
</div>