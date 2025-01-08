<?php
include('db.php');

// Get room IDs from the POST data
$inputData = json_decode(file_get_contents('php://input'), true);
$roomIds = $inputData['roomIds'];

// Validate the input
if (empty($roomIds) || !is_array($roomIds)) {
    echo json_encode(['error' => 'No rooms selected for comparison.']);
    exit;
}

// Prepare the SQL query to fetch the rooms and their facilities based on the selected IDs
$roomIdsList = implode(',', array_map('intval', $roomIds)); // Escape the IDs for SQL

$sql = "SELECT * FROM rooms WHERE id IN ($roomIdsList)";
$result = $conn->query($sql);

// Check if we have any rooms to compare
if ($result->num_rows > 0) {
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        // Add the room facilities along with other room data
        $rooms[] = [
            'id' => $row['id'],
            'room_name' => $row['room_name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'availability' => $row['availability'],
            'wifi' => $row['wifi'],
            'tv' => $row['tv'],
            'ac' => $row['ac'],
            'minibar' => $row['minibar'],
            'bathroom' => $row['bathroom'],
            'balcony' => $row['balcony'],
        ];
    }

    // Return the room data with facilities in JSON format
    echo json_encode($rooms);
} else {
    echo json_encode(['error' => 'No matching rooms found.']);
}

$conn->close();
?>
