<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tipo de tanque</h4>
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
                        <h4 class="card-title">Listado de Tipos de Tanque</h4>
                        <a href="<?php echo getUrl("Tipo_tanques","Tipotanque","getCreate") ?>" class="btn btn-primary">
                            <i class="fa fa-plus mx-2"></i> Nuevo tipo de Tanque
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Tabla de resultados -->
                    <div class="table-responsive">
                        <table id="tableTipoTanques" class="display table table-striped table-hover">
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
                                                echo "<a href='".getUrl("Tipo_tanques", "Tipotanque", "getUpdate", array("id"=>$tipo['id']))."' class='btn btn-primary mx-2'>Editar</a>";
                                                if ($tipo['estado'] == 1) {
                                                    echo "<a href='".getUrl("Tipo_tanques", "Tipotanque","getDelete",array("id"=>$tipo['id']))."' class='btn btn-danger'>Eliminar</a>";

                                                } elseif ($tipo['estado'] == 2) {
                                                    echo "<a href='".getUrl("Tipo_tanques", "Tipotanque","updateStatus",array("id"=>$tipo['id']))."' class='btn btn-success'>Activar</a>";
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