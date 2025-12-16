<?php
class ConfiguracionController {

    public function listManuales() {
        $rutaPdf = 'assets/manuals/pdf/';
        $rutaVideos = 'assets/manuals/videos/';
        
        $manuales_pdf = glob($rutaPdf . '*.pdf');
        $manuales_video = glob($rutaVideos . '*.{mp4,webm,ogg}', GLOB_BRACE);
        
        require_once '../view/configuracion/listManuales.php';
    }

    public function acercaDe() {
        require_once '../view/configuracion/acercaDe.php';
    }
}
?>