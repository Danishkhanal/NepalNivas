<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NepalNivas - Hotel Rooms</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 20px;
        }

        header {
            margin-bottom: 30px;
        }

        h1 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2c3e50;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .room-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .room-card:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-weight: bold;
            color: #2c3e50;
        }

        .btn-primary,
        .btn-danger,
        .btn-secondary {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-secondary {
            background-color: #95a5a6;
            border: none;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .room-checkbox {
            margin-top: 10px;
        }

        .comparison-table {
            margin-top: 30px;
            border-collapse: collapse;
            width: 100%;
        }

        .comparison-table th,
        .comparison-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .comparison-table th {
            background-color: #34495e;
            color: white;
        }

        .comparison-table td {
            background-color: #ecf0f1;
        }

        .comparison-results {
            margin-top: 30px;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-nav {
            flex-direction: row;
        }

        .navbar-nav .nav-item {
            padding-left: 15px;
            padding-right: 15px;
        }

        .navbar-nav .nav-link {
            font-size: 1rem;
        }

        .form-container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-heading {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group select,
        .form-group input {
            padding: 10px;
            font-size: 1rem;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Site Name/Logo on the left -->
            <a class="navbar-brand" href="#">NepalNivas</a>
            
            <!-- Navigation Links in the center -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
            </div>

            <!-- Login/Register Buttons on the right -->
            <div class="d-flex">
                <?php if (isset($_SESSION['username'])): ?>
                    <p class="mb-0 me-3">Welcome, <?php echo $_SESSION['username']; ?>!</p>
                    <a href="profile.php" class="btn btn-secondary">Profile</a>
                    <a href="logout.php" class="btn btn-danger ms-2">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary me-2">Login</a>
                    <a href="register.php" class="btn btn-success">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Booking Availability Form -->
    <div class="container">
        <div class="form-container">
            <h2 class="form-heading">Check Room Availability</h2>
            <form>
                <!-- Check-in Date -->
                <div class="form-group mb-3">
                    <label for="checkinDate">Check-in Date</label>
                    <input type="date" class="form-control" id="checkinDate" required>
                </div>

                <!-- Check-out Date -->
                <div class="form-group mb-3">
                    <label for="checkoutDate">Check-out Date</label>
                    <input type="date" class="form-control" id="checkoutDate" required>
                </div>

                <!-- Adults -->
                <div class="form-group mb-3">
                    <label for="adults">Adults</label>
                    <select class="form-control" id="adults">
                        <option value="1">1 Adult</option>
                        <option value="2">2 Adults</option>
                        <option value="3">3 Adults</option>
                        <option value="4">4 Adults</option>
                        <option value="5">5 Adults</option>
                        <option value="6">6 Adults</option>
                    </select>
                </div>

                <!-- Children -->
                <div class="form-group mb-3">
                    <label for="children">Children</label>
                    <select class="form-control" id="children">
                        <option value="0">No Children</option>
                        <option value="1">1 Child</option>
                        <option value="2">2 Children</option>
                        <option value="3">3 Children</option>
                        <option value="4">4 Children</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-submit">Check Availability</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <header class="my-4 text-center">
            <h1>NepalNivas - Available Rooms</h1>
        </header>

        <!-- Available Rooms Section -->
        <div class="row">
            <?php
            include('db.php');
            $sql = "SELECT * FROM rooms WHERE availability = 1";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card room-card">
                        <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="Room Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['room_name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <p><strong>Price: $<?php echo $row['price']; ?></strong></p>
                            <input type="checkbox" class="room-checkbox" value="<?php echo $row['id']; ?>"> Select this room for comparison
                            <br>
                            <button type="button" class="btn btn-info mt-2" onclick="viewDetails(<?php echo $row['id']; ?>)">View Details</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <form onsubmit="event.preventDefault(); compareRooms();">
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Compare</button>
            </div>
        </form>

        <!-- Modal for Room Comparison -->
        <div class="modal fade" id="comparisonModal" tabindex="-1" aria-labelledby="comparisonModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="comparisonModalLabel">Room Comparison</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="comparisonModalBody">
                        <!-- Comparison content will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </div>

        <div id="comparison-results" class="comparison-results">
            <!-- Comparison results will be shown here -->
        </div>
    </div>

    <!-- Modal for Room Details -->
    <div class="modal fade" id="roomDetailsModal" tabindex="-1" aria-labelledby="roomDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomDetailsModalLabel">Room Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="roomDetailsModalBody">
                    <!-- Room details will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function viewDetails(roomId) {
            // Fetch room details using AJAX and populate the modal
            fetch('get_room_details.php?id=' + roomId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('roomDetailsModalLabel').textContent = data.room_name;
                    document.getElementById('roomDetailsModalBody').innerHTML = `
                        <img src="${data.image}" class="img-fluid mb-3" alt="Room Image">
                        <p><strong>Description:</strong> ${data.description}</p>
                        <p><strong>Price: $${data.price}</strong></p>
                        <p><strong>Capacity:</strong> ${data.capacity} people</p>
                    `;
                    var myModal = new bootstrap.Modal(document.getElementById('roomDetailsModal'));
                    myModal.show();
                });
        }

        function compareRooms() {
            const selectedRooms = [];
            document.querySelectorAll('.room-checkbox:checked').forEach(checkbox => {
                selectedRooms.push(checkbox.value);
            });

            if (selectedRooms.length === 0) {
                alert('Please select at least one room for comparison.');
                return;
            }

            // Send the selected rooms to the server for comparison
            fetch('compare_rooms.php', {
                method: 'POST',
                body: JSON.stringify({ roomIds: selectedRooms }),
                headers: { 'Content-Type': 'application/json' }
            })
                .then(response => response.json())
                .then(data => {
                    let comparisonTable = '<table class="comparison-table">';
                    comparisonTable += '<thead><tr><th>Room Name</th><th>Description</th><th>Price</th><th>Capacity</th></tr></thead><tbody>';
                    data.forEach(room => {
                        comparisonTable += `
                            <tr>
                                <td>${room.room_name}</td>
                                <td>${room.description}</td>
                                <td>${room.price}</td>
                                <td>${room.capacity}</td>
                            </tr>
                        `;
                    });
                    comparisonTable += '</tbody></table>';
                    document.getElementById('comparison-results').innerHTML = comparisonTable;
                });
        }
    </script>
</body>

</html>
