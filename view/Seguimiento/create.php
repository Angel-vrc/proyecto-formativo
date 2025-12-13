<div class="page-inner">

<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
    </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>


    <a href="<?php echo getUrl("Seguimiento","Seguimiento","lista") ?>" class="btn btn-primary btn-round" >
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Registrar Nuevo Seguimiento</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Seguimiento</div>
                </div>
                <form id="formSeguimiento" method="POST" action="<?php echo getUrl("Seguimiento","Seguimiento","postCreate") ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Fecha -->
                                <div class="form-group">
                                    <label for="fecha">Fecha *</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" 
                                           required>
                                    <small class="form-text text-muted">Fecha del seguimiento</small>
                                </div>
                                
                                <!-- Zoocriadero -->
                                <div class="form-group">
                                    <label for="id_zoocriadero">Zoocriadero *</label>
                                    <select class="form-control" id="id_zoocriadero" name="id_zoocriadero" required>
                                        <option value="">Seleccione un zoocriadero</option>
                                        <?php
                                            while($zoo = pg_fetch_assoc($zoocriaderos)){
                                                echo "<option value='".$zoo['id_zoocriadero']."'>".$zoo['nombre']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <small class="form-text text-muted">Seleccione el zoocriadero</small>
                                </div>
                                
                                <!-- Tanque -->
                                <div class="form-group">
                                    <label for="id_tanque">Tanque *</label>
                                    <select class="form-control" id="id_tanque" name="id_tanque" required disabled>
                                        <option value="">Primero seleccione un zoocriadero</option>
                                    </select>
                                    <small class="form-text text-muted">Seleccione el tanque (se cargará según el zoocriadero)</small>
                                </div>
                                
                                <!-- ID Actividad (con nombre) -->
                                <div class="form-group">
                                    <label for="id_actividad">Actividad *</label>
                                    <select class="form-control" id="id_actividad" name="id_actividad" required>
                                        <option value="">Seleccione una actividad</option>
                                        <?php
                                            while($act = pg_fetch_assoc($actividades)){
                                                echo "<option value='".$act['id']."'>".$act['nombre']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <small class="form-text text-muted">Seleccione la actividad realizada</small>
                                </div>
                                
                                <!-- pH -->
                                <div class="form-group">
                                    <label for="ph">pH *</label>
                                    <input type="number" step="0.1" class="form-control" id="ph" name="ph" 
                                           placeholder="Ej: 7.2" min="0" max="14" value="" required>
                                    <small class="form-text text-muted">Valor del pH (0-14). Use punto (.) como separador decimal</small>
                                </div>
                                
                                <!-- Temperatura -->
                                <div class="form-group">
                                    <label for="temperatura">Temperatura (°C) *</label>
                                    <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura" 
                                           placeholder="Ej: 25.0" value="" required>
                                    <small class="form-text text-muted">Temperatura en grados Celsius</small>
                                </div>
                                
                                <!-- Cloro -->
                                <div class="form-group">
                                    <label for="cloro">Cloro (mg/L) *</label>
                                    <input type="number" step="0.1" class="form-control" id="cloro" name="cloro" 
                                           placeholder="Ej: 0.5" min="0" value="" required>
                                    <small class="form-text text-muted">Concentración de cloro</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- Números de Alevines (Nacimientos) -->
                                <div class="form-group">
                                    <label for="num_alevines">Números de Alevines (Nacimientos) *</label>
                                    <input type="number" class="form-control" id="num_alevines" name="num_alevines" 
                                           placeholder="0" min="0" value="">
                                </div>
                                
                                <!-- Número de Muertes -->
                                <div class="form-group">
                                    <label for="num_muertes">Número de Muertes *</label>
                                    <input type="number" class="form-control" id="num_muertes" name="num_muertes" 
                                           placeholder="0" min="0" value="">
                                </div>
                                <!-- Número de Machos -->
                                <div class="form-group">
                                    <label for="num_machos">Número de Machos *</label>
                                    <input type="number" class="form-control" id="num_machos" name="num_machos" 
                                           placeholder="0" min="0" value="">
                                </div>
                                
                                <!-- Número de Hembras -->
                                <div class="form-group">
                                    <label for="num_hembras">Número de Hembras *</label>
                                    <input type="number" class="form-control" id="num_hembras" name="num_hembras" 
                                           placeholder="0" min="0" value="">
                                </div>
                                
                                <!-- Observaciones -->
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" 
                                              rows="4" placeholder="Observaciones adicionales..." maxlength="200"></textarea>
                                    <small class="form-text text-muted">Máximo 200 caracteres</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" value="Registrar" class="btn btn-success">
                        <a href="<?php echo getUrl("Seguimiento","Seguimiento","lista") ?>" class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Esperar a que todo esté cargado
(function() {
    function initTanquesAjax() {
        
        // Cuando se selecciona un zoocriadero, cargar tanques con AJAX
        jQuery('#id_zoocriadero').off('change').on('change', function() {
            var id_zoocriadero = jQuery(this).val();
            var $tanqueSelect = jQuery('#id_tanque');
                        
            if(!id_zoocriadero || id_zoocriadero == '' || id_zoocriadero == null) {
                $tanqueSelect.html('<option value="">Primero seleccione un zoocriadero</option>').prop('disabled', true);
                return;
            }
            
            // Llamada AJAX usando ajax.php 
            var urlAjax = 'ajax.php?modulo=Seguimiento&controlador=Seguimiento&funcion=getTanquesByZoocriadero&id_zoocriadero=' + id_zoocriadero;
            
            jQuery.ajax({
                url: urlAjax,
                type: 'GET',
                dataType: 'json',
                cache: false,
                success: function(response) {   
                    
                    if(response && response.success !== false && response.tanques) {
                        if(response.tanques.length > 0) {
                            var options = '<option value="">Seleccione un tanque</option>';
                            jQuery.each(response.tanques, function(index, tanque) {
                                var nombre = tanque.nombre || 'Sin nombre';
                                options += '<option value="' + tanque.id + '">' + nombre + '</option>';
                            });
                            $tanqueSelect.html(options).prop('disabled', false);
                        } else {
                            $tanqueSelect.html('<option value="">No hay tanques disponibles para este zoocriadero</option>').prop('disabled', true);
                        }
                    }
                },
            });
        });
    }
    
    // Intentar inicializar cuando el DOM esté listo
    if(document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTanquesAjax);
    } else {
        // Si ya está cargado, usar jQuery ready
        if(typeof jQuery !== 'undefined') {
            jQuery(document).ready(initTanquesAjax);
        } else {
            setTimeout(initTanquesAjax, 100);
        }
    }
})();
</script>