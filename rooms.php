<?php 
  // Assuming your connection to the database is already established
  require('inc/links.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $settings_r['site_title']; ?> - ROOMS</title>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <?php 
    // Default values for checkin, checkout, adult, and children
    $checkin_default = "";
    $checkout_default = "";
    $adult_default = "";
    $children_default = "";

    if (isset($_GET['check_availability'])) {
      $frm_data = filteration($_GET);
      $checkin_default = $frm_data['checkin'];
      $checkout_default = $frm_data['checkout'];
      $adult_default = $frm_data['adult'];
      $children_default = $frm_data['children'];
    }
  ?>

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
    <div class="h-line bg-dark"></div>
  </div>

  <div class="container-fluid">
    <div class="row">

      <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
          <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2">FILTERS</h4>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
              
              <!-- Check availablity -->
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                  <span>CHECK AVAILABILITY</span>
                  <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                </h5>
                <label class="form-label">Check-in</label>
                <input type="date" class="form-control shadow-none mb-3" value="<?php echo $checkin_default ?>" id="checkin" onchange="chk_avail_filter()">
                <label class="form-label">Check-out</label>
                <input type="date" class="form-control shadow-none" value="<?php echo $checkout_default ?>"  id="checkout" onchange="chk_avail_filter()">
              </div>

              <!-- Facilities -->
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                  <span>FACILITIES</span>
                  <button id="facilities_btn" onclick="facilities_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                </h5>
                <?php 
                  $facilities_q = selectAll('facilities');
                  while($row = mysqli_fetch_assoc($facilities_q)) {
                    echo<<<facilities
                      <div class="mb-2">
                        <input type="checkbox" onclick="fetch_rooms()" name="facilities" value="$row[id]" class="form-check-input shadow-none me-1" id="$row[id]">
                        <label class="form-check-label" for="$row[id]">$row[name]</label>
                      </div>
                    facilities;
                  }
                ?>
              </div>

              <!-- Guests -->
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                  <span>GUESTS</span>
                  <button id="guests_btn" onclick="guests_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                </h5>
                <div class="d-flex">
                  <div class="me-3">
                    <label class="form-label">Adults</label>
                    <input type="number" min="1" id="adults" value="<?php echo $adult_default ?>" oninput="guests_filter()" class="form-control shadow-none">                 
                  </div>
                  <div>
                    <label class="form-label">Children</label>
                    <input type="number" min="1" id="children" value="<?php echo $children_default ?>" oninput="guests_filter()" class="form-control shadow-none">                 
                  </div>
                </div>
              </div>

              <!-- Currency Selector -->
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                  <span>CURRENCY SELECTOR </span>
                </h5>
                <select id="currency-selector" class="form-select">
                    <option value="NPR">Nepalese Rupee (NPR)</option>
                    <option value="USD">US Dollar (USD)</option>
                    <option value="INR">Indian Rupee (INR)</option>
                    <option value="EUR">Euro (EUR)</option>
                </select>
              </div>

            </div>
          </div>
        </nav>
      </div>

      <div class="col-lg-9 col-md-12 px-4" id="rooms-data">
        <!-- Room details will appear here -->
      </div>

    </div>
  </div>

  <script>
    let rooms_data = document.getElementById('rooms-data');
    let checkin = document.getElementById('checkin');
    let checkout = document.getElementById('checkout');
    let chk_avail_btn = document.getElementById('chk_avail_btn');

    let adults = document.getElementById('adults');
    let children = document.getElementById('children');
    let guests_btn = document.getElementById('guests_btn');
    
    let facilities_btn = document.getElementById('facilities_btn');

    // Currency Selector
    let currencySelector = document.getElementById('currency-selector');
    
    // Fetch Room Data
    function fetch_rooms() {
        let chk_avail = JSON.stringify({
            checkin: checkin.value,
            checkout: checkout.value
        });

        let guests = JSON.stringify({
            adults: adults.value,
            children: children.value
        });

        let selectedCurrency = currencySelector.value;
        let facility_list = {"facilities":[]};

        let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
        if(get_facilities.length > 0) {
            get_facilities.forEach((facility) => {
                facility_list.facilities.push(facility.value);
            });
            facilities_btn.classList.remove('d-none');
        } else {
            facilities_btn.classList.add('d-none');
        }

        facility_list = JSON.stringify(facility_list);

        let xhr = new XMLHttpRequest();
        xhr.open("GET", "ajax/rooms.php?fetch_rooms&chk_avail=" + chk_avail + "&guests=" + guests + "&currency=" + selectedCurrency + "&facility_list=" + facility_list, true);

        xhr.onprogress = function() {
            rooms_data.innerHTML = `<div class="spinner-border text-info mb-3 d-block mx-auto" id="loader" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>`;
        }

        xhr.onload = function() {
            rooms_data.innerHTML = this.responseText;
        }

        xhr.send();
    }

    // Handle Check Availability Filter
    function chk_avail_filter() {
        if(checkin.value != '' && checkout.value != '') {
            fetch_rooms();
            chk_avail_btn.classList.remove('d-none');
        }
    }

    // Handle Guests Filter
    function guests_filter() {
        if(adults.value > 0 || children.value > 0) {
            fetch_rooms();
            guests_btn.classList.remove('d-none');
        }
    }

    // Handle Clear Filters
    function chk_avail_clear() {
        checkin.value = '';
        checkout.value = '';
        chk_avail_btn.classList.add('d-none');
        fetch_rooms();
    }

    function guests_clear() {
        adults.value = '';
        children.value = '';
        guests_btn.classList.add('d-none');
        fetch_rooms();
    }

    function facilities_clear() {
        let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
        get_facilities.forEach((facility) => {
            facility.checked = false;
        });
        facilities_btn.classList.add('d-none');
        fetch_rooms();
    }

    // Handle Currency Selection
    currencySelector.addEventListener('change', function() {
        fetch_rooms();
    });

    // Initialize on page load
    window.onload = function() {
        fetch_rooms();
    };

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('book-now-btn')) {
            let login = e.target.getAttribute('data-login');
            let room_id = e.target.getAttribute('data-room-id');
            let selectedCurrency = document.getElementById('currency-selector').value;
            
            if (login === '0' || !login) {
                alert('Please login to book room!');
            } else {
                window.location.href = 'confirm_booking.php?id=' + room_id + '&currency=' + selectedCurrency;
            }
        }
    });
  </script>

  <?php require('inc/footer.php'); ?>

</body>
</html>
