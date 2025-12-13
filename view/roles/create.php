<link rel="stylesheet" href="assets/css/arregloTablas.css">

<div class="page-inner">

    <a href="<?php echo getUrl("Roles","Rol","lista") ?>" class="btn btn-primary btn-round" >
        <i class="fa fa-chevron-left mx-2"></i>Regresar
    </a>
    <div class="page-header mt-3">
        <h4 class="page-title">Registrar Nuevo Rol</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Información del Rol</div>
                </div>
                <form id="formRoles" method="POST" action="<?php echo getUrl("Roles","Rol","postCreate") ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <!-- Nombre -->
                                <div class="form-group">
                                    <label for="nombre">Nombre del Rol *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           placeholder="Ej: Juan" required
                                           maxlength="150">
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="table-responsive" style="overflow-x:auto;">
                                <table id="tableRoles" class="table table-stripped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Accion/Modulo</th>
                                            <?php
                                                $modulosArray = array();

                                                while($modulo=pg_fetch_assoc($modulos)){
                                                    echo "<th>".$modulo['nombre']."</th>";
                                                    $modulosArray[] = $modulo;                                        
                                                }   
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($accion=pg_fetch_assoc($acciones)){
                                                echo "<tr>";
                                                    echo "<td>".$accion['nombre']."</td>";
                                                    foreach ($modulosArray as $mod) {
                                                        echo "<td>
                                                            <input type='checkbox' name='permisos[".$mod['id']."][".$accion['id']."]'
                                                        </td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="submit" value="Registrar" class="btn btn-success">
                        <a href="<?php echo getUrl("Roles","Rol","lista") ?>" class="btn btn-danger">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>