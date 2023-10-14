
<select id="dia"  name="dia">
    <?php
    for ($dia = 1; $dia <= 31; $dia++) {
        echo "<option value='$dia'>$dia</option>";
    }
    ?>
</select>
<label for="dia">Día</label>

<select id="mes" name="mes">
    <?php
    for ($mes = 1; $mes <= 12; $mes++) {
        echo "<option value='$mes'>$mes</option>";
    }
    ?>
</select>
<label for="mes">Mes</label>

<select id="anio" name="anio">
    <?php
    for ($anio = 2023; $anio <= 2030; $anio++) {
        echo "<option value='$anio'>$anio</option>";
    }
    ?>
</select>
<label for="anio">Año</label>

