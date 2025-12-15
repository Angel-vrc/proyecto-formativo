<?php
if ($tipos && pg_num_rows($tipos) > 0) {
    while ($tipo = pg_fetch_assoc($tipos)) {
        echo "<tr>";
            echo "<td>".$tipo['id']."</td>";
            echo "<td>".$tipo['nombre']."</td>";
            echo "<td>";

                echo "<a href='".getUrl("Actividad","Activida","getUpdate",array("id"=>$tipo['id']))."' class='btn btn-primary mx-2'>Editar</a>";

                if ($tipo['estado'] == 1) {
                    echo "<a href='".getUrl("Actividad","Activida","getDelete",array("id"=>$tipo['id']))."' class='btn btn-danger'>Eliminar</a>";
                } else {
                    echo "<a href='".getUrl("Actividad","Activida","updateStatus",array("id"=>$tipo['id']))."' class='btn btn-success'>Activar</a>";
                }

            echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3' class='text-center'>No se encontraron registros</td></tr>";
}
