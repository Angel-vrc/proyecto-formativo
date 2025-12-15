<?php
    if ($zoocriaderos && pg_num_rows($zoocriaderos) > 0) {
        while ($zoo = pg_fetch_assoc($zoocriaderos)) {
?>
            <tr>
                <td><?php echo $zoo['id_zoocriadero']; ?></td>
                <td><?php echo $zoo['nombre']; ?></td>
                <td><?php echo $zoo['direccion']; ?></td>
                <td><?php echo $zoo['comuna']; ?></td>
                <td><?php echo $zoo['barrio']; ?></td>
                <td><?php echo $zoo['nombre_responsable'] . ' ' . $zoo['apellido_responsable']; ?></td>
                <td><?php echo $zoo['telefono']; ?></td>
                <td><?php echo $zoo['correo']; ?></td>
            </tr>
<?php
        }
    } else {
        echo "<tr><td colspan='8' class='text-center'>No hay registros de zoocriaderos</td></tr>";
    }
?>
