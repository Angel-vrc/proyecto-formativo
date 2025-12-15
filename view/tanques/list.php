<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Gestión de Tanques</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="" style="display:flex; justify-content: space-between;">
                        <h4 class="card-title">Listado de Tanques</h4>
                        <?php if (tienePermiso('tanques', 'Registrar')): ?>
                        <a href="<?php echo getUrl("Tanques","Tanque","getCreate") ?>" class="btn btn-primary btn-round mx-4 text-right" >
                            <i class="fa fa-plus mx-2"></i> Nuevo tanque
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros de búsqueda -->
                    <form method="GET" action="">
                        <div class="row mb-3">
                            <div class="col-md-3">
                            </div>

                            <div class="col-md-3">
                                <select name="tipo" class="form-control">
                                    <option value="">Tipos de Tanque</option>
                                <?php
                                    while ($tipo = pg_fetch_assoc($tipos)) {
                                        $valorTipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
                                        $selected = ($valorTipo == $tipo['id']) ? 'selected' : '';
                                        echo "<option value='{$tipo['id']}' $selected>{$tipo['nombre']}</option>";
                                    }
                                ?>
                                </select>
                            </div>

                            <div class="col-md-3 mt-2">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search mx-1"></i> Filtrar
                                </button>
                                <a href="<?php echo getUrl("Tanques","Tanque","lista"); ?>" class="btn btn-secondary">
                                    Limpiar
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Tabla de resultados -->
                    <div class="table-responsive">
                        <table id="tableZoocriaderos" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo de Tanque</th>
                                    <th>Cantidad de peces</th>
                                    <th>Medidas del Tanque</th>
                                    <!-- <th>Teléfono</th> -->
                                    <!-- <th>Correo</th> -->
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                               <?php
                                    if ($tanques && pg_num_rows($tanques) > 0) {
                                        while($tanque = pg_fetch_assoc($tanques)){
                                            echo "<tr>";
                                                echo "<td>".$tanque['id']."</td>";
                                                echo "<td>".$tanque['nombre']."</td>";
                                                echo "<td>".$tanque['tipo_tanque']."</td>";
                                                echo "<td>".$tanque['cantidad_peces']."</td>";
                                                echo "<td>".$tanque['medidas']."</td>";
                                                echo "<td>";
                                                    if (tienePermiso('tanques', 'Actualizar')) {
                                                        echo "<a href='".getUrl("Tanques", "Tanque", "getUpdate", array("id"=>$tanque['id']))."' class='btn btn-primary mx-2'>Editar</a>";
                                                    }

                                                    if ($tanque['estado'] == 1) {
                                                        if (tienePermiso('tanques', 'Eliminar')) {
                                                            echo "<a href='".getUrl("Tanques", "Tanque","getDelete",array("id"=>$tanque['id']))."' class='btn btn-danger'>Eliminar</a>";
                                                        }
                                                    } elseif ($tanque['estado'] == 2) {
                                                        if (tienePermiso('tanques', 'Eliminar')) {
                                                            echo "<a href='".getUrl("Tanques", "Tanque","updateStatus",array("id"=>$tanque['id']))."' class='btn btn-success'>Activar</a>";
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