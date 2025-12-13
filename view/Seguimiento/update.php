<div class="page-inner">

    <a href="<?php echo getUrl("Seguimiento","Seguimiento","lista") ?>" class="btn btn-primary btn-round" >
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Actualizar Seguimiento</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Seguimiento</div>
                </div>
                <form id="formSeguimiento" method="POST" action="<?php echo getUrl("Seguimiento","Seguimiento","postUpdate") ?>">
                    
                    <?php
                        while($seg = pg_fetch_assoc($seguimiento)){
                            $id_tanque_actual = isset($seg['id_tanque_actual']) ? $seg['id_tanque_actual'] : 0;
                            $id_tipo_tanque_actual = isset($seg['id_tipo_tanque_actual']) ? $seg['id_tipo_tanque_actual'] : 0;
                            $cantidad_peces_tanque_actual = isset($seg['cantidad_peces_tanque']) ? $seg['cantidad_peces_tanque'] : 0;
                    ?>

                    <input type="hidden" name="id" value="<?php echo $seg['id']; ?>">
                    
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Fecha -->
                                    <div class="form-group">
                                        <label for="fecha">Fecha *</label>
                                        <input type="date" class="form-control" id="fecha" name="fecha" 
                                               value="<?php echo isset($seg['fecha_seguimiento']) ? $seg['fecha_seguimiento'] : ''; ?>" required>
                                        <small class="form-text text-muted">Fecha del seguimiento</small>
                                    </div>
                                    
                                    <!-- Tanque -->
                                    <div class="form-group">
                                        <label for="id_tanque">Tanque *</label>
                                        <select class="form-control" id="id_tanque" name="id_tanque" required>
                                            <option value="">Seleccione un tanque</option>
                                            <?php
                                                // Resetear el puntero del resultado
                                                pg_result_seek($tanques, 0);
                                                while($tanque = pg_fetch_assoc($tanques)){
                                                    $selected = ($tanque['id'] == $id_tanque_actual) ? 'selected' : '';
                                                    echo "<option value='".$tanque['id']."' data-tipo='".$tanque['tipo_tanque']."' data-tipo-id='".$tanque['id_tipo_tanque']."' $selected>".$tanque['nombre']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <small class="form-text text-muted">Seleccione el tanque</small>
                                    </div>
                                    
                                    <!-- Tipo Tanque -->
                                    <div class="form-group">
                                        <label for="id_tipo_tanque">Tipo de Tanque *</label>
                                        <select class="form-control" id="id_tipo_tanque" name="id_tipo_tanque" required>
                                            <option value="">Seleccione un tipo de tanque</option>
                                            <?php
                                                // Resetear el puntero del resultado
                                                pg_result_seek($tipos_tanque, 0);
                                                while($tipo = pg_fetch_assoc($tipos_tanque)){
                                                    $selected = ($tipo['id'] == $id_tipo_tanque_actual) ? 'selected' : '';
                                                    echo "<option value='".$tipo['id']."' $selected>".$tipo['nombre']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <small class="form-text text-muted">Seleccione el tipo de tanque</small>
                                    </div>
                                    
                                    <!-- ID Seguimiento (oculto) -->
                                    <input type="hidden" id="id_seguimiento" name="id_seguimiento" value="<?php echo $seg['id_seguimiento']; ?>">
                                    
                                    <!-- ID Actividad (con nombre) -->
                                    <div class="form-group">
                                        <label for="id_actividad">Actividad *</label>
                                        <select class="form-control" id="id_actividad" name="id_actividad" required>
                                            <option value="">Seleccione una actividad</option>
                                            <?php
                                                while($actividad_option = pg_fetch_assoc($actividades)){
                                                    $selected = ($actividad_option['id'] == $seg['id_actividad']) ? 'selected' : '';
                                                    echo "<option value='".$actividad_option['id']."' $selected>".$actividad_option['nombre']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <small class="form-text text-muted">Seleccione la actividad realizada</small>
                                    </div>
                                    
                                    <!-- pH -->
                                    <div class="form-group">
                                        <label for="ph">pH *</label>
                                        <input type="number" step="0.1" class="form-control" id="ph" name="ph" 
                                               placeholder="Ej: 7.2" min="0" max="14" value="<?php echo $seg['ph']; ?>" required>
                                        <small class="form-text text-muted">Valor del pH (0-14). Use punto (.) como separador decimal</small>
                                    </div>
                                    
                                    <!-- Temperatura -->
                                    <div class="form-group">
                                        <label for="temperatura">Temperatura (°C) *</label>
                                        <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura" 
                                               placeholder="Ej: 25.0" value="<?php echo $seg['temperatura']; ?>" required>
                                        <small class="form-text text-muted">Temperatura en grados Celsius</small>
                                    </div>
                                    
                                    <!-- Cloro -->
                                    <div class="form-group">
                                        <label for="cloro">Cloro (mg/L) *</label>
                                        <input type="number" step="0.1" class="form-control" id="cloro" name="cloro" 
                                               placeholder="Ej: 0.5" min="0" value="<?php echo $seg['cloro']; ?>" required>
                                        <small class="form-text text-muted">Concentración de cloro</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                      <!-- Números de Alevines (Nacimientos) -->
                                    <div class="form-group">
                                        <label for="num_alevines">Números de Alevines (Nacimientos)</label>
                                        <input type="number" class="form-control" id="num_alevines" name="num_alevines" 
                                               placeholder="0" min="0" value="<?php echo $seg['num_alevines']; ?>">
                                    </div>
                                    
                                    <!-- Número de Muertes -->
                                    <div class="form-group">
                                        <label for="num_muertes">Número de Muertes</label>
                                        <input type="number" class="form-control" id="num_muertes" name="num_muertes" 
                                               placeholder="0" min="0" value="<?php echo $seg['num_muertes']; ?>">
                                    </div>
                                    <!-- Número de Machos -->
                                    <div class="form-group">
                                        <label for="num_machos">Número de Machos</label>
                                        <input type="number" class="form-control" id="num_machos" name="num_machos" 
                                               placeholder="0" min="0" value="<?php echo $seg['num_machos']; ?>">
                                    </div>
                                    
                                    <!-- Número de Hembras -->
                                    <div class="form-group">
                                        <label for="num_hembras">Número de Hembras</label>
                                        <input type="number" class="form-control" id="num_hembras" name="num_hembras" 
                                               placeholder="0" min="0" value="<?php echo $seg['num_hembras']; ?>">
                                    </div>
                                    
                                    <!-- Observaciones -->
                                    <div class="form-group">
                                        <label for="observaciones">Observaciones</label>
                                        <textarea class="form-control" id="observaciones" name="observaciones" 
                                                  rows="4" placeholder="Observaciones adicionales..." maxlength="50"><?php echo htmlspecialchars($seg['observaciones']); ?></textarea>
                                        <small class="form-text text-muted">Máximo 50 caracteres</small>
                                    </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <input type="submit" value="Actualizar" class="btn btn-success">
                            <a href="<?php echo getUrl("Seguimiento","Seguimiento","lista") ?>" class="btn btn-danger">
                                Cancelar
                            </a>
                        </div>

                    <?php
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Esperar a que todo esté cargado
(function() {
    function initUpdateForm() {
        // Verificar que jQuery esté cargado
        if(typeof jQuery === 'undefined') {
            setTimeout(initUpdateForm, 100);
            return;
        }
        
        // Función para calcular el total
        function updateTotal() {
            var cantidadPecesTanque = parseInt(jQuery('#cantidad_peces_tanque').val()) || 0;
            var numAlevines = parseInt(jQuery('#num_alevines').val()) || 0;
            var numMuertes = parseInt(jQuery('#num_muertes').val()) || 0;
            var numMachos = parseInt(jQuery('#num_machos').val()) || 0;
            var numHembras = parseInt(jQuery('#num_hembras').val()) || 0;
            
            // Total = cantidad_peces del tanque + alevines - muertes + machos + hembras
            var total = cantidadPecesTanque + numAlevines - numMuertes + numMachos + numHembras;
            
            jQuery('#total').val(total);
        }
        
        // Actualizar total cuando cambian los campos numéricos
        jQuery('#num_alevines, #num_muertes, #num_machos, #num_hembras').on('input', function() {
            updateTotal();
        });
        
        // Calcular total inicial
        updateTotal();
    }
    
    // Intentar inicializar cuando el DOM esté listo
    if(document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initUpdateForm);
    } else {
        if(typeof jQuery !== 'undefined') {
            jQuery(document).ready(initUpdateForm);
        } else {
            setTimeout(initUpdateForm, 100);
        }
    }
})();
</script>

