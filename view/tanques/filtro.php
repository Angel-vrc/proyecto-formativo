<?php
if ($tanques && pg_num_rows($tanques) > 0) {
    while ($tanque = pg_fetch_assoc($tanques)) {
        echo "<tr>";
            echo "<td>{$tanque['id']}</td>";
            echo "<td>{$tanque['nombre']}</td>";
            echo "<td>{$tanque['tipo_tanque']}</td>";
            echo "<td>{$tanque['cantidad_peces']}</td>";
            echo "<td>{$tanque['medidas']}</td>";
            echo "<td>{$tanque['zoocriadero']}</td>";
            echo "<td>";

                echo "<a href='".getUrl("Tanques","Tanque","getUpdate",array("id"=>$tanque['id']))."' class='btn btn-primary mx-2'>Editar</a>";

                if ($tanque['estado'] == 1) {
                    echo "<a href='".getUrl("Tanques","Tanque","getDelete",array("id"=>$tanque['id']))."' class='btn btn-danger'>Eliminar</a>";
                } else {
                    echo "<a href='".getUrl("Tanques","Tanque","updateStatus",array("id"=>$tanque['id']))."' class='btn btn-success'>Activar</a>";
                }

            echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>No se encontraron registros</td></tr>";
}
