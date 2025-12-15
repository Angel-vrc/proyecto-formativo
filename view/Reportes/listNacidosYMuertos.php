<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Reporte de Nacidos y Muertos</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">Reporte de Nacidos y Muertos</div>
                        <a href="export_excel.php?modulo=Reportes&controlador=ReporteNacidosYMuertos&funcion=exportarExcel" 
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
                                <i class="fas fa-list"></i> Lista de Nacidos y Muertos
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
        <input type="date"
               class="form-control"
               id="filtro_fecha_desde"
               data-url="<?php echo getUrl('Reportes','ReporteNacidosYMuertos','filtro', false, 'ajax'); ?>">
        <small class="text-muted">Fecha desde</small>
    </div>

    <div class="col-md-3">
        <input type="date"
               class="form-control"
               id="filtro_fecha_hasta"
               data-url="<?php echo getUrl('Reportes','ReporteNacidosYMuertos','filtro', false, 'ajax'); ?>">
        <small class="text-muted">Fecha hasta</small>
    </div>

    <div class="col-md-3 mt-4">
        <a href="<?php echo getUrl('Reportes','ReporteNacidosYMuertos','listNacidosYMuertos') ?>"
           class="btn btn-secondary">
            <i class="fas fa-redo"></i> Limpiar
        </a>
    </div>
</div>


                            <!-- Tabla de nacidos y muertos -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tablaNacidosYMuertos">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Nacidos (Alevines)</th>
                                            <th>Muertos</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <?php
                                        if ($nacidosYMuertos && pg_num_rows($nacidosYMuertos) > 0) {
                                            while ($reg = pg_fetch_assoc($nacidosYMuertos)) {
                                                $fecha_formato = $reg['fecha_seguimiento'] ? date('d/m/Y', strtotime($reg['fecha_seguimiento'])) : 'N/A';
                                        ?>
                                                <tr>
                                                    <td><?php echo $fecha_formato; ?></td>
                                                    <td><?php echo $reg['nacidos']; ?></td>
                                                    <td><?php echo $reg['muertos']; ?></td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='3' class='text-center'>No hay registros de nacidos y muertos</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-estadisticas" role="tabpanel"
                             aria-labelledby="pills-estadisticas-tab">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Estadísticas de Nacidos y Muertos</h5>
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
            if ($estadisticas && pg_num_rows($estadisticas) > 0) {
                $labels = array();
                while ($est = pg_fetch_assoc($estadisticas)) {
                    $labels[] = "'" . addslashes(trim($est['mes_nombre'])) . "'";
                }
                echo implode(', ', $labels);
            } else {
                echo "'Sin datos'";
            }
            ?>
        ],
        datasets: [
            {
                label: 'Nacidos (Alevines)',
                data: [
                    <?php
                    if ($estadisticas && pg_num_rows($estadisticas) > 0) {
                        pg_result_seek($estadisticas, 0);
                        $data = array();
                        while ($est = pg_fetch_assoc($estadisticas)) {
                            $data[] = isset($est['total_nacidos']) ? $est['total_nacidos'] : 0;
                        }
                        echo implode(', ', $data);
                    }
                    ?>
                ],
                backgroundColor: 'rgba(40, 167, 69, 0.6)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 2,
                fill: true
            },
            {
                label: 'Muertos',
                data: [
                    <?php
                    if ($estadisticas && pg_num_rows($estadisticas) > 0) {
                        pg_result_seek($estadisticas, 0);
                        $data = array();
                        while ($est = pg_fetch_assoc($estadisticas)) {
                            $data[] = isset($est['total_muertos']) ? $est['total_muertos'] : 0;
                        }
                        echo implode(', ', $data);
                    }
                    ?>
                ],
                backgroundColor: 'rgba(220, 53, 69, 0.6)',
                borderColor: 'rgba(220, 53, 69, 1)',
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
            type: 'line',
            data: estadisticasData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                scales: { y: { beginAtZero: true } },
                plugins: {
                    legend: { display: true },
                    title: { display: true, text: 'Estadísticas de Nacidos y Muertos por Mes' }
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
        window.location.href = 'export_excel.php?modulo=Reportes&controlador=ReporteNacidosYMuertos&funcion=exportarExcel';
    }


</script>

