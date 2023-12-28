<h1 class="nombre-pagina">Panel de Administración</h1>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<p class="descripcion-pagina">Buscar Citas</p>

<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php
    if (count($citas) === 0) {
        echo "<h2>No Hay Citas en esta fecha</h2>";
    }
?>

<div class="citas-admin">
    <ul class="citas">
        <?php
        // Inicializa el ID de la cita y el total de servicios
        $idCita = 0;
        $total = 0;

        // Itera sobre las citas
        foreach ($citas as $key => $cita) {
            // Verifica si es una nueva cita
            if ($idCita !== $cita->id) {
                // Reinicia el total y muestra información de la cita
                $total = 0;
        ?>
                <li>
                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>Teléfono: <span><?php echo $cita->telefono; ?></span></p>

                    <h3>Servicios:</h3>
        <?php
                // Actualiza el ID de la cita actual
                $idCita = $cita->id;
            } // Fin de If

            // Suma el precio del servicio al total
            $total += $cita->precio;
        ?>
                    <p class="servicio"><?php echo $cita->servicio . " $" . $cita->precio; ?></p>

            <?php
                // Verifica si es la última cita
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                if (esUltimo($actual, $proximo)) {
            ?>
                    <p class="total">Total: <span>$ <?php echo $total; ?></span></p>

                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>
            <?php
                } // Fin de If
            ?>
        <?php
        } // Fin de ForEach
        ?>
    </ul>
</div>

<?php

        $script = "<script src='build/js/buscador.js'></script>"

?>
