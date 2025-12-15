<link rel="stylesheet" href="assets/css/arregloTablas.css">
<div class="modal-content">
    <div class="modal-header" style="background:#1a5a5a;color:white;">
        <h5 id="tituloPDF"></h5>
        <button class="close" data-dismiss="modal"></button>
    </div>
    <div class="modal-body" id="contenidoPDF"></div>
</div>


<!-- MODAL VIDEO -->
<div class="modal fade" id="modalVideo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:#1a5a5a;color:white;">
                <h5 id="tituloVideo"></h5>
                <button class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="contenidoVideo"></div>
        </div>
    </div>
</div>


<script>
    function verPDF(ruta, nombre) {
        document.getElementById('tituloPDF').innerText = nombre;
        document.getElementById('contenidoPDF').innerHTML = `<embed src="${ruta}" type="application/pdf" width="100%" height="700px">`;
        $('#modalPDF').modal('show');
    }


    function verVideo(ruta, nombre) {
        document.getElementById('tituloVideo').innerText = nombre;
        document.getElementById('contenidoVideo').innerHTML = `<video src="${ruta}" controls width="100%"></video>`;
        $('#modalVideo').modal('show');
    }
</script>