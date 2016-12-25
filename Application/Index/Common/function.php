<?php
defined('THINK_PATH') or exit();
/*
 *
 * 打印信息
 */
function showMessage($info, $href="") {
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    echo"<script> alert('".$info."');</script>";
    if (empty($href)) {
        echo "<script>window.history.go(-1)</script>";
    }
    else {
        echo "<script>javascript:window.location.href='".$href."'</script>";
    }

    exit();
}

?>