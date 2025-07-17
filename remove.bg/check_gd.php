<?php
// Check if GD library is enabled
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "GD library is enabled on this server.<br>";

    // Display GD library information
    $gd_info = gd_info();
    echo "<pre>";
    print_r($gd_info);
    echo "</pre>";
} else {
    echo "GD library is NOT enabled on this server.";
}
?>