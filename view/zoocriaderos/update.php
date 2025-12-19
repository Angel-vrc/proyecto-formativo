<div class="page-inner">

    <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","lista") ?>" class="btn btn-primary btn-round" >
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Actualizar Zoocriadero</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Zoocriadero</div>
                </div>
                <form id="formZoocriadero" method="POST" action="<?php echo getUrl("Zoocriaderos","Zoocriadero","postUpdate") ?>">
                    
                    <?php
                        while($zoo = pg_fetch_assoc($zoocriadero)){
                            // Parsear dirección existente
                            $direccionParseada = array('tipo_via' => '', 'numero_via' => '', 'complemento' => '');
                            if (isset($zoo['direccion']) && !empty($zoo['direccion'])) {
                                $direccionParseada = parsearDireccion($zoo['direccion']);
                            }                                            
                    ?>

                    <input type="hidden" name="id" value="<?php echo $zoo['id_zoocriadero']; ?>">
                    
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Nombre -->
                                    <div class="form-group">
                                        <label for="nombre">Nombre del Zoocriadero *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                            placeholder="Ej: Zoocriadero Las Acacias" required
                                            maxlength="150" value="<?php echo $zoo['nombre']?>">
                                        <small class="form-text text-muted">Nombre completo del establecimiento</small>
                                    </div>
                                    
                                    <!-- Dirección - Tipo de Vía -->
                                    <div class="form-group">
                                        <label for="tipo_via">Tipo de Vía *</label>
                                        <select class="form-control select2" id="tipo_via" name="tipo_via" required>
                                            <option value="">Seleccione el tipo de vía</option>
                                            <?php foreach ($tiposDirecciones as $tipo): ?>
                                                <option value="<?php echo htmlspecialchars($tipo); ?>" 
                                                    <?php echo (trim($tipo) === trim($direccionParseada['tipo_via'])) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($tipo); ?>
                                                </option>
                                                
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <!-- Dirección - Número de Vía -->
                                    <div class="form-group">
                                        <label for="numero_via">Número de Vía *</label>
                                        <input type="text" class="form-control" id="numero_via" name="numero_via" 
                                               placeholder="Ej: 123" required
                                               maxlength="50" pattern="[0-9A-Za-z\s\-\.#]+"
                                               title="Ingrese el número o identificador de la vía"
                                               value="<?php echo htmlspecialchars($direccionParseada['numero_via']); ?>">
                                        <small class="form-text text-muted">Número, letra o identificador de la vía</small>
                                    </div>
                                    
                                    <!-- Dirección - Complemento -->
                                    <div class="form-group">
                                        <label for="complemento_direccion">Complemento</label>
                                        <input type="text" class="form-control" id="complemento_direccion" name="complemento_direccion" 
                                               placeholder="Ej: #45-67, Apto 201, Casa 5" 
                                               maxlength="100"
                                               value="<?php echo htmlspecialchars($direccionParseada['complemento']); ?>">
                                        <small class="form-text text-muted">Número de casa, apartamento, local, etc. (Opcional)</small>
                                    </div>
                                    
                                    <!-- Dirección completa (oculta, se genera automáticamente) -->
                                    <input type="hidden" id="direccion" name="direccion" value="">
                                    
                                    <!-- Comuna -->
                                    <div class="form-group">
                                        <label for="comuna">Comuna *</label>
                                        <select class="form-control select2" id="comuna" name="comuna" required>                                            
                                            <?php foreach ($comunas as $comuna): ?>
                                                <option value="<?php echo $comuna; ?>" 
                                                    <?php echo ($comuna == $zoo['comuna']) ? 'selected' : ''; ?>>
                                                    <?php echo $comuna; ?>
                                                </option>
                                            <?php endforeach; ?>                                     
                                        </select>
                                    </div>
                                    
                                    <!-- Barrio -->
                                    <div class="form-group">
                                        <label for="barrio">Barrio *</label>
                                        <select class="form-control select2" id="barrio" name="barrio" required>                                             
                                            <?php foreach ($barrios as $barrio): ?>
                                                <option value="<?php echo $barrio; ?>" 
                                                    <?php echo ($barrio == $zoo['barrio']) ? 'selected' : ''; ?>>
                                                    <?php echo $barrio; ?>
                                                </option>
                                            <?php endforeach; ?>                                     
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <!-- Responsable -->
                                    <div class="form-group">
                                        <label for="responsable">Responsable *</label>
                                        <select class="form-control select2" id="responsable" name="responsable" required> 
                                            <?php while($usuario = pg_fetch_assoc($usuarios)){ ?>
                                                <option value="<?php echo $usuario['id']; ?>" 
                                                    <?php echo ($usuario['id'] == $zoo['responsable']) ? 'selected' : ''; ?>>
                                                    <?php echo $usuario['nombre']." ".$usuario['apellido']; ?>
                                                </option>
                                            <?php } ?>                                     
                                        </select>
                                    </div>
                                    
                                    <!-- Teléfono -->
                                    <div class="form-group">
                                        <label for="telefono">Teléfono *</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                                            placeholder="Ej: 3001234567" required
                                            pattern="[0-9]{7,20}" maxlength="20" value="<?php echo $zoo['telefono']?>">
                                        <small class="form-text text-muted">Solo números, mínimo 7 dígitos</small>
                                    </div>
                                    
                                    <!-- Correo -->
                                    <div class="form-group">
                                        <label for="correo">Correo Electrónico *</label>
                                        <input type="email" class="form-control" id="correo" name="correo" 
                                            placeholder="ejemplo@dominio.com" required
                                            maxlength="100" value="<?php echo $zoo['correo']?>">
                                    </div>

                                    <div class="form-group">
                                    <label for="nombre">Coordenadas *</label>
                                    <input type="text" class="form-control" id="coordenadas" name="coordenadas" 
                                           placeholder="Ej: 4.4512,-79.5321" required readonly
                                           maxlength="150" value="<?php echo $zoo['coordenadas'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <input type="submit" value="Actualizar" class="btn btn-success">
                            <a href="<?php echo getUrl("Zoocriaderos","Zoocriadero","list") ?>" class="btn btn-danger">
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
// Función para construir la dirección completa de forma estandarizada
function construirDireccion() {
    var tipoVia = $('#tipo_via').val() || '';
    var numeroVia = $('#numero_via').val() || '';
    var complemento = $('#complemento_direccion').val() || '';
    
    var direccion = '';
    
    // Construir dirección: Tipo de Vía + Número de Vía
    if (tipoVia && numeroVia) {
        direccion = tipoVia + ' ' + numeroVia.trim();
    } else if (tipoVia) {
        direccion = tipoVia;
    } else if (numeroVia) {
        direccion = numeroVia.trim();
    }
    
    // Agregar complemento si existe
    if (complemento && direccion) {
        direccion += ' ' + complemento.trim();
    } else if (complemento) {
        direccion = complemento.trim();
    }
    
    // Actualizar campo oculto
    $('#direccion').val(direccion.trim());
}

// Event listeners para actualizar dirección automáticamente
$(document).ready(function() {
    // Construir dirección inicial cuando se carga la página
    construirDireccion();
    
    // Actualizar dirección cuando cambian los campos
    $('#tipo_via, #numero_via, #complemento_direccion').on('change keyup blur', function() {
        construirDireccion();
    });
    
    // Validar antes de enviar el formulario
    $('#formZoocriadero').on('submit', function(e) {
        // Asegurar que la dirección se construya antes de enviar
        construirDireccion();
        var direccion = $('#direccion').val();
        var tipoVia = $('#tipo_via').val();
        var numeroVia = $('#numero_via').val();
        
        if (!tipoVia || !numeroVia) {
            e.preventDefault();
            alert('Por favor complete los campos de dirección (Tipo de Vía y Número de Vía son obligatorios)');
            return false;
        }
        
        if (!direccion || direccion.trim() === '') {
            e.preventDefault();
            alert('Error al construir la dirección. Por favor verifique los campos.');
            return false;
        }
    });
});
</script>