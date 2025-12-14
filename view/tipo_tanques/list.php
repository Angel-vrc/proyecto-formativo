<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tipo de tanque</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="" style="display:flex; justify-content: space-between;">
                        <h4 class="card-title">Listado de Tipos de Tanque</h4>
                        <a href="<?php echo getUrl("Tipo_tanques","Tipotanque","getCreate") ?>" class="btn btn-primary btn-round mx-4 text-right">
                            <i class="fa fa-plus mx-2"></i> Nuevo tipo de Tanque
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Tabla de resultados -->
                    <div class="table-responsive">
                        <table id="tableZoocriaderos" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                               <?php
                                    if ($tipos && pg_num_rows($tipos) > 0) {
                                        while($tipo = pg_fetch_assoc($tipos)){
                                            echo "<tr>";
                                                echo "<td>".$tipo['id']."</td>";
                                                echo "<td>".$tipo['nombre']."</td>";
                                                echo "<td>";
                                                    echo "<a href='".getUrl("Tipo_tanques","Tipotanque","getUpdate",array("id"=>$tipo['id']))."' class='btn btn-primary mx-2'>Editar</a>";
                                                    if ($tipo['estado'] == 1) {
                                                        echo "<a href='".getUrl("Tipo_tanques", "Tipotanque","getDelete",array("id"=>$tipo['id']))."' class='btn btn-danger'>Eliminar</a>";

                                                    } elseif ($tipo['estado'] == 2) {
                                                        echo "<a href='".getUrl("Tipo_tanques", "Tipotanque","updateStatus",array("id"=>$tipo['id']))."' class='btn btn-success'>Activar</a>";
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