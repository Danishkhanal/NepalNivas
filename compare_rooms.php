<?php
require('admin/inc/db_config.php');

if (isset($_POST['room_ids'])) {
    $room_ids = explode(',', $_POST['room_ids']);

    if (count($room_ids) < 2) {
        echo "<p>Please select at least two rooms to compare.</p>";
        exit;
    }
    $placeholders = implode(',', array_fill(0, count($room_ids), '?'));
    $sql = "SELECT r.name AS room_name, r.adult, r.children, 
            GROUP_CONCAT(DISTINCT f.name ORDER BY f.name SEPARATOR ', ') AS features, 
            GROUP_CONCAT(DISTINCT fac.name ORDER BY fac.name SEPARATOR ', ') AS facilities
            FROM rooms r
            LEFT JOIN room_features rf ON r.id = rf.room_id
            LEFT JOIN features f ON rf.features_id = f.id
            LEFT JOIN room_facilities rfac ON r.id = rfac.room_id
            LEFT JOIN facilities fac ON rfac.facilities_id = fac.id
            WHERE r.id IN ($placeholders)
            GROUP BY r.id";

    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        $types = str_repeat('i', count($room_ids));
        mysqli_stmt_bind_param($stmt, $types, ...$room_ids);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $rooms_data = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $rooms_data[] = [
                    'room_name' => $row['room_name'],
                    'adult' => $row['adult'],
                    'children' => $row['children'],
                    'features' => $row['features'] ?? 'None',
                    'facilities' => $row['facilities'] ?? 'None',
                ];
            }

            // Generate HTML table with Bootstrap styling
            echo "<div class='table-responsive'>"; // Responsive wrapper
            echo "<table class='table table-bordered table-hover'>"; // Bootstrap table classes
            echo "<thead class='table-light'><tr>"; // Light header background
            echo "<th>Room</th><th>Guests (Adults)</th><th>Guests (Children)</th><th>Features</th><th>Facilities</th>";
            echo "</tr></thead>";
            echo "<tbody>";