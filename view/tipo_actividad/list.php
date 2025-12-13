<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tipo de Actividad</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="" style="display:flex; justibetween;">fy-content: space-
                        <h4 class="card-title">Listado de Tipos de Actividad</h4>
                        <a href="<?php echo getUrl("Tipo_actividad","Tipoactivida","getCreate") ?>" class="btn btn-primary btn-round mx-4 text-right" >
                            <i class="fa fa-plus mx-2"></i> Nuevo tipo de actividad
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
                                    while($tipo = pg_fetch_assoc($tipos)){
                                        echo "<tr>";
                                            echo "<td>".$tipo['id']."</td>";
                                            echo "<td>".$tipo['nombre']."</td>";
                                            echo "<td>";
                                                echo "<a href='".getUrl("Tipo_actividad", "Tipoactivida", "getUpdate", array("id"=>$tipo['id']))."' class='btn btn-primary mx-2'>Editar</a>";
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