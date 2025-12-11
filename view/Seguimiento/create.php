<div class="page-inner">

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
                                    <label for="num_alevines">Números de Alevines (Nacimientos)</label>
                                    <input type="number" class="form-control" id="num_alevines" name="num_alevines" 
                                           placeholder="0" min="0" value="">
                                </div>
                                
                                <!-- Número de Muertes -->
                                <div class="form-group">
                                    <label for="num_muertes">Número de Muertes</label>
                                    <input type="number" class="form-control" id="num_muertes" name="num_muertes" 
                                           placeholder="0" min="0" value="">
                                </div>
                                <!-- Número de Machos -->
                                <div class="form-group">
                                    <label for="num_machos">Número de Machos</label>
                                    <input type="number" class="form-control" id="num_machos" name="num_machos" 
                                           placeholder="0" min="0" value="">
                                </div>
                                
                                <!-- Número de Hembras -->
                                <div class="form-group">
                                    <label for="num_hembras">Número de Hembras</label>
                                    <input type="number" class="form-control" id="num_hembras" name="num_hembras" 
                                           placeholder="0" min="0" value="">
                                </div>
                                
                                <!-- Total de Peces Calculado -->
                                <div class="form-group">
                                    <label for="total_peces_calculado">Total de Peces Calculado</label>
                                    <input type="number" class="form-control" id="total_peces_calculado" 
                                           placeholder="0" readonly style="background-color: #e9ecef;">
                                    <small class="form-text text-muted">Total = Cantidad de peces del tanque - Muertes</small>
                                </div>
                                
                                <!-- Cantidad de Peces del Tanque (oculto) -->
                                <input type="hidden" id="cantidad_peces_tanque" name="cantidad_peces_tanque" value="0">
                                
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
                jQuery('#cantidad_peces_tanque').val(0);
                updateTotal();
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
                    console.log('Respuesta AJAX recibida:', response);
                    
                    if(response && response.success !== false && response.tanques) {
                        if(response.tanques.length > 0) {
                            var options = '<option value="">Seleccione un tanque</option>';
                            jQuery.each(response.tanques, function(index, tanque) {
                                var cantidad = tanque.cantidad_peces || 0;
                                var nombre = tanque.nombre || 'Sin nombre';
                                options += '<option value="' + tanque.id + '" data-cantidad="' + cantidad + '">' + nombre + '</option>';
                            });
                            $tanqueSelect.html(options).prop('disabled', false);
                            console.log('Tanques cargados:', response.tanques.length);
                        } else {
                            $tanqueSelect.html('<option value="">No hay tanques disponibles para este zoocriadero</option>').prop('disabled', true);
                            console.log('No hay tanques disponibles');
                        }
                    }
                    jQuery('#cantidad_peces_tanque').val(0);
                    updateTotal();
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

// Cuando se selecciona un tanque, actualizar cantidad_peces
jQuery(document).ready(function() {
    jQuery('#id_tanque').on('change', function() {
        var selectedOption = jQuery(this).find('option:selected');
        var cantidadPeces = selectedOption.data('cantidad') || 0;
        
        jQuery('#cantidad_peces_tanque').val(cantidadPeces);
        
        updateTotal();
    });
    
    // Actualizar total cuando cambian los campos numéricos
    jQuery('#num_alevines, #num_muertes, #num_machos, #num_hembras').on('input', function() {
        updateTotal();
    });
});

// Función para calcular y validar el total de peces
function updateTotal() {
    // Obtener valores de los campos (convertir a número, si está vacío usar 0)
    var num_alevines = parseFloat(jQuery('#num_alevines').val()) || 0;
    var num_hembras = parseFloat(jQuery('#num_hembras').val()) || 0;
    var num_machos = parseFloat(jQuery('#num_machos').val()) || 0;
    var num_muertes = parseFloat(jQuery('#num_muertes').val()) || 0;
    var cantidad_peces_tanque = parseFloat(jQuery('#cantidad_peces_tanque').val()) || 0;
    
    // Suma de alevines, hembras y machos
    var suma_peces = num_alevines + num_hembras + num_machos;
    
    // Calcular total: Cantidad de peces del tanque - Muertes
    var total_calculado = cantidad_peces_tanque - num_muertes;
    
    // Actualizar el campo de total calculado
    jQuery('#total_peces_calculado').val(total_calculado);
    
    // Validar y mostrar feedback
    var $totalField = jQuery('#total_peces_calculado');
    var $formGroup = $totalField.closest('.form-group');
    
    // Remover clases de validación previas
    $totalField.removeClass('is-valid is-invalid');
    $formGroup.find('.invalid-feedback').remove();
    
    // Validar que la suma de alevines, hembras y machos sea igual a la cantidad de peces del tanque
    if (cantidad_peces_tanque > 0) {
        if (suma_peces === cantidad_peces_tanque) {
            $totalField.addClass('is-valid');
        } else {
            $totalField.addClass('is-invalid');
            $formGroup.append('<div class="invalid-feedback">La suma de Alevines (' + num_alevines + ') + Hembras (' + num_hembras + ') + Machos (' + num_machos + ') = ' + suma_peces + ' debe ser igual a la cantidad de peces del tanque (' + cantidad_peces_tanque + ')</div>');
        }
    }
}
</script>