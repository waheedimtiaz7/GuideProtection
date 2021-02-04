<table class="table table-bordered table-hover datatable">
    <thead>
    <tr>
        <?php
        $falg = true;
        if ($table){
        foreach ($table as $caption => $row){
        if ($falg) {
        foreach ($row as $caption => $col) {
            ?>
            <th><?php echo $caption ?></th>
            <?php
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $falg = false;
    } ?>
    <tr>
        <?php
        foreach ($row as $caption => $col) {
            ?>
            <td><?php echo $col; ?></td>
            <?php
        } ?>
    </tr>
    <?php
    }
    }
    ?>
    </tbody>
</table>