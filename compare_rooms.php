<?php
require('admin/inc/db_config.php');

if (isset($_POST['room_ids'])) {
    $room_ids = explode(',', $_POST['room_ids']);

    if (count($room_ids) < 2) {
        echo "<p>Please select at least two rooms to compare.</p>";
        exit;
    }