<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Reporte de Zoocriaderos</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">Reporte de Zoocriaderos</div>
                        <a href="#" onclick="exportarZoocriaderoExcel(); return false;" 
                           class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Exportar a Excel
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Pestañas -->
                    <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-lista-tab" data-bs-toggle="tab"
                               href="#pills-lista" role="tab" aria-selected="true">
                                <i class="fas fa-list"></i> Lista de Zoocriaderos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-estadisticas-tab" data-bs-toggle="tab"
                               href="#pills-estadisticas" role="tab" aria-selected="false">
                                <i class="fas fa-chart-area"></i> Estadísticas
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="pills-tabContent">
                        <!-- Pestaña 1: Lista -->
                        <div class="tab-pane fade show active" id="pills-lista" role="tabpanel"
                             aria-labelledby="pills-lista-tab">

                            <!-- Filtros -->
                            <div class="row mb-3">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2" id="comuna2" name="comuna" data-url="<?php echo getUrl('Reportes','ReporteZoocriadero','filtro', false, 'ajax'); ?>">
                                    <option value="">Todas las comunas</option> 
                                    <?php foreach ($comunas as $comuna): ?>
                                        <option value="<?php echo $comuna; ?>">
                                            <?php echo $comuna; ?>
                                        </option>
                                    <?php endforeach; ?>                                     
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <a href="<?php echo getUrl("Reportes","ReporteZoocriadero","listZoocriadero") ?>" class="btn btn-secondary" onclick="resetFilters()">
                                <i class="fas fa-redo mx-1"></i> Limpiar filtros
                            </a>
                        </div>
                    </div>

                            <!-- Tabla de zoocriaderos -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tablaZoocriaderos">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Dirección</th>
                                            <th>Comuna</th>
                                            <th>Barrio</th>
                                            <th>Responsable</th>
                                            <th>Teléfono</th>
                                            <th>Correo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <?php
                                        if ($zoocriaderos && pg_num_rows($zoocriaderos) > 0) {
                                            while ($zoo = pg_fetch_assoc($zoocriaderos)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $zoo['id_zoocriadero']; ?></td>
                                                    <td><?php echo $zoo['nombre']; ?></td>
                                                    <td><?php echo $zoo['direccion']; ?></td>
                                                    <td><?php echo $zoo['comuna']; ?></td>
                                                    <td><?php echo $zoo['barrio']; ?></td>
                                                    <td><?php echo $zoo['nombre_responsable'] . ' ' . $zoo['apellido_responsable']; ?></td>
                                                    <td><?php echo $zoo['telefono']; ?></td>
                                                    <td><?php echo $zoo['correo']; ?></td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>No hay registros de zoocriaderos</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
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

                        <div class="tab-pane fade" id="pills-estadisticas" role="tabpanel"
                             aria-labelledby="pills-estadisticas-tab">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Estadísticas de Zoocriaderos</h5>
                                        <button type="button" class="btn btn-success btn-sm" onclick="exportarGrafico()">
                                            <i class="fas fa-file-excel"></i> Exportar
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div style="position: relative; height: 400px;">
                                        <canvas id="estadisticasChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
</div>

<script>
    var estadisticasData = {
        labels: [
            <?php
            if ($estadisticas && is_array($estadisticas) && count($estadisticas) > 0) {
                $labels = array();
                foreach ($estadisticas as $est) {
                    $labels[] = "'" . addslashes(trim($est['comuna'])) . "'";
                }
                echo implode(', ', $labels);
            } else {
                echo "'Sin datos'";
            }
            ?>
        ],
        datasets: [
            {
                label: 'Zoocriaderos por Comuna',
                data: [
                    <?php
                    if ($estadisticas && is_array($estadisticas) && count($estadisticas) > 0) {
                        $data = array();
                        foreach ($estadisticas as $est) {
                            $data[] = isset($est['total_zoocriaderos']) ? intval($est['total_zoocriaderos']) : 0;
                        }
                        echo implode(', ', $data);
                    }
                    ?>
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true
            }
        ]
    };

    var estadisticasChart = null;

    // Crear gráfico
    function crearGrafico() {
        var canvas = document.getElementById('estadisticasChart');
        if (!canvas) return;
        if (estadisticasChart) {
            estadisticasChart.destroy();
        }

        estadisticasChart = new Chart(canvas.getContext('2d'), {
            type: 'bar',
            data: estadisticasData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                scales: { y: { beginAtZero: true } },
                plugins: {
                    legend: { display: true },
                    title: { display: true, text: 'Distribución de Zoocriaderos por Comuna' }
                }
            }
        });
    }

    // Evento: Crear gráfico al mostrar la pestaña de estadísticas
    document.getElementById('pills-estadisticas-tab').addEventListener('shown.bs.tab', function () {
        crearGrafico();
    });

    // Exportar Excel
    function exportarGrafico() {
        exportarZoocriaderoExcel();
    }

    // Función para exportar a Excel con filtros
    function exportarZoocriaderoExcel() {
        var url = 'export_excel.php?modulo=Reportes&controlador=ReporteZoocriadero&funcion=exportarExcel';
        
        // Obtener valores de los campos o de la URL actual
        var urlParams = new URLSearchParams(window.location.search);
        var comuna = document.getElementById('comuna2') ? document.getElementById('comuna2').value : (urlParams.get('comuna') || '');
        
        if (comuna) {
            url += '&comuna=' + encodeURIComponent(comuna);
        }
        
        window.location.href = url;
    }
</script>

