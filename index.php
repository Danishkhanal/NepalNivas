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
    background-color: #f8f9fa; /* Light gray background */
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
    color: #e74c3c; /* Vibrant red for headings */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.room-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.room-card:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}

.card-title {
    font-weight: bold;
    color: #3498db; /* Vibrant blue for card titles */
}

.btn-primary,
.btn-danger,
.btn-secondary {
    padding: 12px 24px;
    border-radius: 5px;
    font-weight: bold;
}

.btn-primary {
    background-color: #2980b9; /* Bright blue for primary button */
    border: none;
}

.btn-danger {
    background-color: #e74c3c; /* Vibrant red for danger button */
    border: none;
}

.btn-secondary {
    background-color: #16a085; /* Bright teal for secondary button */
    border: none;
}

.btn:hover {
    opacity: 0.85;
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
    background-color: #2c3e50; /* Darker blue for table header */
    color: white;
}

.comparison-table td {
    background-color: #ecf0f1; /* Light gray for table cells */
}

.comparison-results {
    margin-top: 30px;
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.5rem;
    color: #f39c12; /* Golden color for navbar brand */
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
    color: #34495e; /* Slightly lighter color for nav links */
}

.form-container {
    text-align: center;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 20px;
    height: 400px;
    background-color: rgba(255, 255, 255, 0.9); /* Slightly more transparent white */
    border-radius: 10px;
    position: relative;
}

.form-heading {
    font-size: 1.8rem; /* Slightly larger font size */
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    color: #2980b9; /* Vibrant blue for form labels */
}

.form-group select,
.form-group input {
    padding: 10px;
    font-size: 1rem;
    width: 100%;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-bottom: 15px;
}

.btn-submit {
    background-color: #2980b9;
    color: white;
    font-weight: bold;
    width: 100%;
    padding: 12px;
    border-radius: 5px;
}

.btn-submit:hover {
    background-color: #3498db; /* Lighter blue on hover */
}

.background-image-section {
    background-image: url('images/background.jpg');
    background-size: cover;
    background-position: center;
    height: 450px; /* Increased height for more impact */
    position: relative;
    margin-bottom: 30px;
}

.room-availability-section {
    background-color: rgba(255, 255, 255, 0.9); /* White background with opacity */
    border-radius: 15px;
    padding: 20px;
    margin-top: 30px;
}

.image-upload-section {
    margin-top: 20px;
    text-align: center;
    padding: 30px;
    background-color: #f0f0f0;
    border-radius: 10px;
}

.upload-btn {
    background-color: #16a085; /* Bright teal */
    color: white;
    padding: 12px 24px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
}

.upload-btn:hover {
    background-color: #1abc9c; /* Slightly lighter teal on hover */
}

#testimonialCarousel {
    /* Removed extra padding */
}

#testimonialCarousel .carousel-item {
    transition: transform 0.6s ease-in-out;
}

#testimonialCarousel .card {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    border: none;
    margin: 0 auto;
    max-width: 650px; /* Increased card width */
}

.testimonial-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.carousel-indicators {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 5px;
    background-color: #e74c3c; /* Vibrant red for indicators */
    border: 0;
}

.carousel-indicators .active {
    opacity: 1;
}

.know-more-container {
    margin-top: 2rem;
    text-align: center;
}

.know-more-container .btn {
    padding: 1rem 2rem;
    background-color: #ffffff; /* White background for 'Know More' button */
    color: #212529; /* Text color set to #212529 */
    font-weight: bold;
    border: 1px solid #212529; /* Optional: adds border for contrast */
}

.know-more-container .btn:hover {
    background-color:rgb(54, 57, 60); /* Light gray background on hover */
    color:rgb(237, 237, 237); /* Keep text color dark on hover */
}

.text-warning {
    margin-bottom: 1rem;
    color: #212529; /* Text color set to #212529 */
    background-color: #ffffff; /* White background for warning text */
}
/* Styling for Reach Us Section */
.container {
    font-family: 'Arial', sans-serif;
}

h2 {
    font-size: 2rem;
    font-weight: bold;
    color: #2c3e50; /* Dark color for headings */
}

.map-placeholder {
    margin-bottom: 20px;
}

.phone-contact {
    margin-bottom: 20px;
}

.phone-contact .btn {
    padding: 12px 24px;
    font-weight: bold;
    background-color: #2980b9; /* Bright blue */
    border: none;
    color: white;
}

.phone-contact .btn:hover {
    background-color: #3498db; /* Slightly lighter blue on hover */
}

.social-media .btn {
    padding: 10px 20px;
    font-weight: bold;
    color: white;
}

.social-media .btn:hover {
    opacity: 0.85;
}

.social-media .btn-primary {
    background-color: #3b5998; /* Facebook Blue */
}

.social-media .btn-info {
    background-color: #00acee; /* Twitter Blue */
}

.social-media .btn-danger {
    background-color: #c13584; /* Instagram Red */
}
/* Styling for Footer */
.footer {
  background-color: #333;
  color: white;
}

.footer h3, .footer h5 {
  font-weight: bold;
}

.footer a {
  text-decoration: none;
}

.footer a:hover {
  text-decoration: underline;
}

.footer .row {
  display: flex;
  justify-content: space-between;
}

.footer .col-md-4 {
  flex: 1;
}

.footer .m-2 {
  margin: 0 10px;
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

    <!-- More Facilities Button -->
<div class="container text-center mb-5">
    <button class="btn btn-outline-dark">More Facilities >>></button>
</div>

<div class="container mb-5">
    <h2 class="text-center mb-4">Guests</h2>

    <div class="testimonial-container">
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <div class="carousel-item active">  <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="Testimonials\Rambo.jpg" class="rounded-circle me-3" alt="Profile">
                                <h5 class="card-title mb-0">Rambo</h5>
                            </div>
                            <p class="card-text">asdlkfj Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos voluptate vero
sed tempore illo atque beatae asperiores, adipisci dicta quia nisi voluptates impedit
perspiciatis, nobis libero culpa error officiis totam</p>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item"> <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="Testimonials\Sita.jpg" class="rounded-circle me-3" alt="Profile">
                                <h5 class="card-title mb-0">Sita</h5>
                            </div>
                            <p class="card-text">asdlkfj Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos voluptate vero
sed tempore illo atque beatae asperiores, adipisci dicta quia nisi voluptates impedit
perspiciatis, nobis libero culpa error officiis totam</p>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item"> <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="Testimonials\bill.jpg" class="rounded-circle me-3" alt="Profile">
                                <h5 class="card-title mb-0">Bill</h5>
                            </div>
                            <p class="card-text">asdlkfj Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos voluptate vero
sed tempore illo atque beatae asperiores, adipisci dicta quia nisi voluptates impedit
perspiciatis, nobis libero culpa error officiis totam</p>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2" aria-label="Slide 2"></button>
            </div>
        </div>

        <div class="know-more-container">
            <button class="btn btn-outline-dark btn-lg">Know More >>></button>
        </div>
    </div>
</div>

<script>
    var testimonialCarousel = new bootstrap.Carousel(document.getElementById('testimonialCarousel'), {
        interval: 30
    });
</script>

<!-- Reach Us Section -->
<div class="container text-center mt-5">
    <h2 class="mb-4">Reach us with</h2>

    <!-- Map Placeholder -->
    <div class="map-placeholder mb-4">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.270639087445!2d85.3240!3d27.7172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19178b97e8cf%3A0x9ebc47bdfb99b97d!2sKathmandu!5e0!3m2!1sen!2snp!4v1606444823271!5m2!1sen!2snp" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <!-- Phone Contact -->
    <div class="phone-contact mb-4">
        <p><strong>Contact Us By Phone:</strong></p>
        <p><a href="tel:+97701565656" class="btn btn-secondary">Call Us: -9779822222222</a></p>
    </div>

    <!-- Social Media Links -->
    <div class="social-media mb-4">
        <p><strong>Connect with us on Social Media:</strong></p>
        <a href="https://facebook.com" target="_blank" class="btn btn-primary m-2">Facebook</a>
        <a href="https://twitter.com" target="_blank" class="btn btn-info m-2">Twitter</a>
        <a href="https://instagram.com" target="_blank" class="btn btn-danger m-2">Instagram</a>
    </div>
</div>
<!-- Footer Section -->
<footer class="footer mt-5 py-4 bg-dark text-white">
  <div class="container">
    <div class="row">
      <!-- Left Section: Website Name/Logo and Brief Description -->
      <div class="col-md-4 mb-4">
        <h3 class="text-white">NepalNvas</h3>
        <p class="text-white">NepalNvas is your gateway to the best accommodations and travel experiences in Nepal. Discover a unique blend of comfort and culture, tailored just for you.</p>
      </div>

      <!-- Center Section: Links (Site Map/Navigation) -->
      <div class="col-md-4 mb-4">
        <h5 class="text-white">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-white">Home</a></li>
          <li><a href="#" class="text-white">Rooms</a></li>
          <li><a href="#" class="text-white">Facilities</a></li>
          <li><a href="#" class="text-white">Contact Us</a></li>
          <li><a href="#" class="text-white">About</a></li>
        </ul>
      </div>

      <!-- Right Section: Social Media Links -->
      <div class="col-md-4 mb-4">
        <h5 class="text-white">Follow Us</h5>
        <div>
          <a href="https://facebook.com" target="_blank" class="text-white m-2">
            <i class="fab fa-facebook-f"></i> Facebook
          </a>
          <a href="https://twitter.com" target="_blank" class="text-white m-2">
            <i class="fab fa-twitter"></i> Twitter
          </a>
          <a href="https://instagram.com" target="_blank" class="text-white m-2">
            <i class="fab fa-instagram"></i> Instagram
          </a>
        </div>
      </div>
    </div>

    <!-- Footer Bottom Section: Copyright Information -->
    <div class="row">
      <div class="col-12 text-center">
        <p class="mb-0">&copy; 2025 NepalNvas. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
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

            // Display room details
            document.getElementById('roomDetailsModalLabel').textContent = data.room_name;
            document.getElementById('roomDetailsModalBody').innerHTML = `
                <img src="${data.image}" class="img-fluid mb-3" alt="Room Image">
                <p><strong>Description:</strong> ${data.description}</p>
                <p><strong>Price:</strong> $${data.price}</p>
                
                <p><strong>Amenities:</strong></p>
                <ul>
                    ${data.wifi == 1 ? "<li>Wi-Fi</li>" : ""}
                    ${data.tv == 1 ? "<li>TV</li>" : ""}
                    ${data.ac == 1 ? "<li>AC</li>" : ""}
                    ${data.minibar == 1 ? "<li>Minibar</li>" : ""}
                    ${data.bathroom == 1 ? "<li>Bathroom</li>" : ""}
                    ${data.balcony == 1 ? "<li>Balcony</li>" : ""}
                </ul>
            `;
            var myModal = new bootstrap.Modal(document.getElementById('roomDetailsModal'));
            myModal.show();
        })
        .catch(error => {
            console.error('Error fetching room details:', error);
        });
}

    </script>
</body>

</html>