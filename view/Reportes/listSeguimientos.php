<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Reporte de Seguimientos</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">Reporte de Seguimientos</div>
                        <a href="export_excel.php?modulo=Reportes&controlador=ReporteSeguimiento&funcion=exportarExcel" 
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
                                <i class="fas fa-list"></i> Lista de Seguimientos
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
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Filtros</h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filtro_fecha_desde">Fecha Desde</label>
                                                <input type="date" class="form-control" id="filtro_fecha_desde"
                                                       name="filtro_fecha_desde" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filtro_fecha_hasta">Fecha Hasta</label>
                                                <input type="date" class="form-control" id="filtro_fecha_hasta"
                                                       name="filtro_fecha_hasta" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filtro_zoocriadero">Zoocriadero</label>
                                                <select class="form-control" id="filtro_zoocriadero"
                                                        name="filtro_zoocriadero" disabled>
                                                    <option value="">Todos</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filtro_tanque">Tanque</label>
                                                <select class="form-control" id="filtro_tanque" name="filtro_tanque" disabled>
                                                    <option value="">Todos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary" disabled>
                                        <i class="fas fa-filter"></i> Aplicar Filtros
                                    </button>
                                    <button type="button" class="btn btn-secondary" disabled>
                                        <i class="fas fa-redo"></i> Limpiar
                                    </button>
                                </div>
                            </div>

                            <!-- Tabla de seguimientos -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tablaSeguimientos">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Zoocriadero</th>
                                            <th>Tanque</th>
                                            <th>Actividad</th>
                                            <th>pH</th>
                                            <th>Temperatura</th>
                                            <th>Cloro</th>
                                            <th>Alevines</th>
                                            <th>Hembras</th>
                                            <th>Machos</th>
                                            <th>Muertes</th>
                                            <th>Total</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($seguimientos && pg_num_rows($seguimientos) > 0) {
                                            while ($seg = pg_fetch_assoc($seguimientos)) {
                                                $fecha_formato = $seg['fecha_seguimiento'] ? date('d/m/Y', strtotime($seg['fecha_seguimiento'])) : 'N/A';
                                        ?>
                                                <tr>
                                                    <td><?php echo $seg['id']; ?></td>
                                                    <td><?php echo $fecha_formato; ?></td>
                                                    <td><?php echo isset($seg['nombre_zoocriadero']) && $seg['nombre_zoocriadero'] != '' ? $seg['nombre_zoocriadero'] : 'N/A'; ?></td>
                                                    <td><?php echo isset($seg['nombre_tanque']) && $seg['nombre_tanque'] != '' ? $seg['nombre_tanque'] : 'N/A'; ?></td>
                                                    <td><?php echo isset($seg['nombre_actividad']) && $seg['nombre_actividad'] != '' ? $seg['nombre_actividad'] : 'N/A'; ?></td>
                                                    <td><?php echo $seg['ph']; ?></td>
                                                    <td><?php echo $seg['temperatura']; ?></td>
                                                    <td><?php echo $seg['cloro']; ?></td>
                                                    <td><?php echo $seg['num_alevines']; ?></td>
                                                    <td><?php echo $seg['num_hembras']; ?></td>
                                                    <td><?php echo $seg['num_machos']; ?></td>
                                                    <td><?php echo $seg['num_muertes']; ?></td>
                                                    <td><?php echo $seg['total']; ?></td>
                                                    <td><?php echo substr($seg['observaciones'], 0, 30) . (strlen($seg['observaciones']) > 30 ? '...' : ''); ?></td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='14' class='text-center'>No hay registros de seguimiento</td></tr>";
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
                                        <h5 class="card-title mb-0">Estadísticas de Seguimientos</h5>
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
                label: 'Alevines',
                data: [
                    <?php
                    if ($estadisticas && pg_num_rows($estadisticas) > 0) {
                        pg_result_seek($estadisticas, 0);
                        $data = array();
                        while ($est = pg_fetch_assoc($estadisticas)) {
                            $data[] = isset($est['total_alevines']) ? $est['total_alevines'] : 0;
                        }
                        echo implode(', ', $data);
                    }
                    ?>
                ],
                backgroundColor: 'rgba(220, 53, 69, 0.6)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 2,
                fill: true
            },
            {
                label: 'Hembras',
                data: [
                    <?php
                    if ($estadisticas && pg_num_rows($estadisticas) > 0) {
                        pg_result_seek($estadisticas, 0);
                        $data = array();
                        while ($est = pg_fetch_assoc($estadisticas)) {
                            $data[] = isset($est['total_hembras']) ? $est['total_hembras'] : 0;
                        }
                        echo implode(', ', $data);
                    }
                    ?>
                ],
                backgroundColor: 'rgba(253, 126, 20, 0.6)',
                borderColor: 'rgba(253, 126, 20, 1)',
                borderWidth: 2,
                fill: true
            },
            {
                label: 'Machos',
                data: [
                    <?php
                    if ($estadisticas && pg_num_rows($estadisticas) > 0) {
                        pg_result_seek($estadisticas, 0);
                        $data = array();
                        while ($est = pg_fetch_assoc($estadisticas)) {
                            $data[] = isset($est['total_machos']) ? $est['total_machos'] : 0;
                        }
                        echo implode(', ', $data);
                    }
                    ?>
                ],
                backgroundColor: 'rgba(0, 123, 255, 0.6)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 2,
                fill: true
            },
            {
                label: 'Muertes',
                data: [
                    <?php
                    if ($estadisticas && pg_num_rows($estadisticas) > 0) {
                        pg_result_seek($estadisticas, 0);
                        $data = array();
                        while ($est = pg_fetch_assoc($estadisticas)) {
                            $data[] = isset($est['total_muertes']) ? $est['total_muertes'] : 0;
                        }
                        echo implode(', ', $data);
                    }
                    ?>
                ],
                backgroundColor: 'rgba(108, 117, 125, 0.6)',
                borderColor: 'rgba(108, 117, 125, 1)',
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
                    legend: { display: false },
                    title: { display: true, text: 'Estadísticas de Seguimientos por Mes' }
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
        window.location.href = 'export_excel.php?modulo=Reportes&controlador=ReporteSeguimiento&funcion=exportarExcel';
    }
</script>
