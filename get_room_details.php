<?php
include('db.php');

if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    // Prevent SQL injection by using a prepared statement
    $sql = "SELECT * FROM rooms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId); // Bind the room ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();

        // Fix image path to use forward slashes
        $room['image'] = str_replace('\\', '/', $room['image']);

        // Return the room details as a JSON response
        echo json_encode($room);
    } else {
        echo json_encode(['error' => 'Room not found']);
    }
}
?>
