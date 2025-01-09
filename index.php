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
            background-color: #ffffff; /* Set the entire body background to white */
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .container {
            font-family: 'Arial', sans-serif;
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

        /* Form Container with Background Image */
        .form-container {
            text-align: center;
            max-width: 600px; /* Limited width */
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
            height: 400px; /* Set height to make it longer */
            background-color: rgba(255, 255, 255, 0.8); /* Light background with transparency for content */
            border-radius: 10px; /* Slight border-radius for smooth edges */
            position: relative; /* Ensures other content is properly layered */
            z-index: 1;
        }

        .form-heading {
            font-size: 1.6rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group select,
        .form-group input {
            padding: 8px;
            font-size: 0.9rem;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            width: 100%;
            padding: 12px;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        /* Section for Background Image */
        .background-image-section {
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            height: 400px; /* Height for the background image section */
            position: relative;
            margin-bottom: 30px;
        }

        .room-availability-section {
            background-color: rgba(255, 255, 255, 0.9); /* White background */
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
        }

        .navbar-nav {
            flex-direction: row;
        }

        .image-upload-section {
            margin-top: 20px;
            text-align: center;
            padding: 30px;
            background-color: #f0f0f0; /* Light gray background */
            border-radius: 10px;
        }

        .upload-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
        }

        .upload-btn:hover {
            background-color: #0056b3;
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

    <!-- Background Image Section -->
    <div class="background-image-section">
        <!-- This section serves as a space for background image -->
    </div>

    <!-- Booking Availability Form with Background Image -->
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

    <!-- Room Availability Section with White Background -->
    <div class="container room-availability-section">
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

        <div class="text-center mt-3">
            <button class="btn btn-secondary">More Rooms</button>
        </div>

        <div id="comparison-results" class="comparison-results">
            <!-- Comparison results will be shown here -->
        </div>
    </div>

    <!-- Our Facilities Section -->
    <div class="container">
        <h2 class="text-center my-4">Our Facilities</h2>
        <div class="row">
            <?php
            // Assuming you have a facilities table
            $sql_facilities = "SELECT * FROM facilities"; // Adjust SQL as per your database
            $result_facilities = $conn->query($sql_facilities);
            while ($facility = $result_facilities->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $facility['name']; ?></h5>
                            <p class="card-text"><?php echo $facility['description']; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
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

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
    <script>
        // Function to compare rooms
        function compareRooms() {
            const selectedRooms = [];
            document.querySelectorAll('.room-checkbox:checked').forEach(checkbox => {
                selectedRooms.push(checkbox.value);
            });

            if (selectedRooms.length === 0) {
                alert('Please select at least one room for comparison.');
                return;
            }

            // Send selected room IDs to the server for comparison
            fetch('compare_rooms.php', {
                method: 'POST',
                body: JSON.stringify({ roomIds: selectedRooms }), // Send as JSON
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);  // Display error if there is an issue
                } else {
                    let comparisonTable = '<table class="comparison-table">';
                    comparisonTable += '<thead><tr><th>Room Name</th><th>Description</th><th>Price</th><th>Wi-Fi</th><th>TV</th><th>AC</th><th>Minibar</th><th>Bathroom</th><th>Balcony</th></tr></thead><tbody>';

                    // Loop through each room data and create a table row
                    data.forEach(room => {
                        comparisonTable += `
                            <tr>
                                <td>${room.room_name}</td>
                                <td>${room.description}</td>
                                <td>$${room.price}</td>
                                <td>${room.wifi == 1 ? 'Yes' : 'No'}</td>
                                <td>${room.tv == 1 ? 'Yes' : 'No'}</td>
                                <td>${room.ac == 1 ? 'Yes' : 'No'}</td>
                                <td>${room.minibar == 1 ? 'Yes' : 'No'}</td>
                                <td>${room.bathroom == 1 ? 'Yes' : 'No'}</td>
                                <td>${room.balcony == 1 ? 'Yes' : 'No'}</td>
                            </tr>
                        `;
                    });

                    comparisonTable += '</tbody></table>';

                    // Display the comparison table
                    document.getElementById('comparison-results').innerHTML = comparisonTable;
                }
            })
            .catch(error => {
                console.error('Error fetching comparison data:', error);
            });
        }

        // Function to view details of a room
        function viewDetails(roomId) {
            fetch('get_room_details.php?id=' + roomId)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);  // Show error if room is not found
                        return;
                    }

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
    </script>
</body>

</html>
