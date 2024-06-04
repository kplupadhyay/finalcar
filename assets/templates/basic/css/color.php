<?php
header("Content-Type:text/css");

if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color) {
    $color = "#069EFF";
}

?>

:root{
--base: <?php echo $color; ?>;
}