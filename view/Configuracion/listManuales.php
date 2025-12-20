<link rel="stylesheet" href="assets/css/arregloTablas.css">

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Listado de Manuales</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manuales PDF</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableManuales" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre del Manual</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $manuales = glob(__DIR__ . '/../assets/manuales/pdf/*.pdf');
                                if ($manuales && count($manuales) > 0) {
                                    $i = 1;
                                    foreach ($manuales as $manual) {
                                        $nombre = basename($manual);
                                        echo "<tr>";
                                        echo "<td>$i</td>";
                                        echo "<td>$nombre</td>";
                                        echo "<td>
                                                <buttom class='btn btn-info mx-1' onclick=\"verManual('$nombre')\">Ver</buttom>
                                                <a href='../web/assets/manuales/download.php?file=" . urlencode($nombre) ."' class='btn btn-success mx-1'>Descargar</a>

                                              </td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>No se encontraron manuales</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<!-- Lista de Videos Manuales -->
<div class="card mt-4">
    <div class="card-header">
        <h4 class="card-title">Video Manuales</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre del Video</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $videos = glob(__DIR__ . '/../assets/manuales/videos/*.mp4');

                    if ($videos && count($videos) > 0) {
                        $i = 1;
                        foreach ($videos as $video) {
                            $nombreVideo = basename($video);
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$nombreVideo</td>";
                            echo "<td>
                                    <button class='btn btn-info mx-1' onclick=\"verVideo('$nombreVideo')\">Ver</button>
                                    <a href='../web/assets/manuales/download.php?file=" . urlencode($nombreVideo) ."' class='btn btn-success mx-1'>Descargar</a>
                                  </td>";
                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>No se encontraron video manuales</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal pdfs Manuales -->
<div class="modal fade" id="modalPdf" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background-color:#1a5a5a; color:white;">
                <h5 class="modal-title">
                    <i class="fas fa-file-pdf"></i> Visualización del Manual
                </h5>
                <button type="button" class="close" onclick="cerrarModalPdf()" style="color:white;">
                </button>
            </div>

            <div class="modal-body p-0">
                <iframe 
                    id="iframePdf"
                    src=""
                    width="100%"
                    height="600px"
                    style="border:none;">
                </iframe>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="cerrarModalPdf()">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal videos Manuales -->
<div class="modal fade" id="modalVideo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background-color:#1a5a5a; color:white;">
                <h5 class="modal-title">
                    <i class="fas fa-video"></i> Video Manual
                </h5>
                <button type="button" class="close" onclick="cerrarModalVideo()" style="color:white;">
                </button>
            </div>

            <div class="modal-body text-center">
                <video id="videoPlayer" width="100%" height="auto" controls>
                    <source src="" type="video/mp4">
                    Tu navegador no soporta videos HTML5.
                </video>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="cerrarModalVideo()">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    function verManual(nombreArchivo) {
        const ruta = "../web/assets/manuales/pdf/" + nombreArchivo;
        document.getElementById('iframePdf').src = ruta;
        $('#modalPdf').modal('show');
    }
    
    function cerrarModalPdf() {
        document.getElementById('iframePdf').src = "";
        $('#modalPdf').modal('hide');
    }

    function verVideo(nombreVideo) {
        const ruta = "../web/assets/manuales/videos/" + nombreVideo;
        const video = document.getElementById('videoPlayer');
        video.src = ruta;
        video.load();
        $('#modalVideo').modal('show');
    }

    function cerrarModalVideo() {
        const video = document.getElementById('videoPlayer');
        video.pause();
        video.src = "";
        $('#modalVideo').modal('hide');
    }
</script>