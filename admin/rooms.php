<?php
  require('inc/essentials.php');
  require('inc/db_config.php');
  adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Rooms</title>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        <h3 class="mb-4">ROOMS</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <div class="text-end mb-4">
              <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                <i class="bi bi-plus-square"></i> Add
              </button>
            </div>

            <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
    <table class="table table-hover border text-center">
        <thead>
            <tr class="bg-dark text-light">
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Area</th>
                <th scope="col">Guests</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="rooms-container">
        </tbody>
    </table>
</div>

          </div>
        </div>

      </div>
    </div>
  </div>
  

  <!-- Add room modal -->
  <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="add_room_form" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Room</h5>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Area</label>
                <input type="number" min="1" name="area" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Price</label>
                <input type="number" min="1" name="price" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Quantity</label>
                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Adult (Max.)</label>
                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Children (Max.)</label>
                <input type="number" min="1" name="children" class="form-control shadow-none" required>
              </div>
              <div class="col-12 mb-3">
                <label class="form-label fw-bold">Features</label>
                <div class="row">
                  <?php 
                    $res = selectAll('features');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                </div>
              </div>
              <div class="col-12 mb-3">
                <label class="form-label fw-bold">Facilities</label>
                <div class="row">
                  <?php 
                    $res = selectAll('facilities');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                </div>
              </div>
              <div class="col-12 mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
            <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit room modal -->
  <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="edit_room_form" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Room</h5>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Area</label>
                <input type="number" min="1" name="area" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Price</label>
                <input type="number" min="1" name="price" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Quantity</label>
                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Adult (Max.)</label>
                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Children (Max.)</label>
                <input type="number" min="1" name="children" class="form-control shadow-none" required>
              </div>
              <div class="col-12 mb-3">
                <label class="form-label fw-bold">Features</label>
                <div class="row">
                  <?php 
                    $res = selectAll('features');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                </div>
              </div>
              <div class="col-12 mb-3">
                <label class="form-label fw-bold">Facilities</label>
                <div class="row">
                  <?php 
                    $res = selectAll('facilities');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                </div>
              </div>
              <div class="col-12 mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
              </div>
              <input type="hidden" name="room_id">
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
            <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Manage room images modal -->
  <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Room Name</h5>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="image-alert"></div>
          <div class="border-bottom border-3 pb-3 mb-3">
            <form id="add_image_form">
              <label class="form-label fw-bold">Add Image</label>
              <input type="file" name="image" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none mb-3" required>
              <button class="btn custom-bg text-white shadow-none">ADD</button>
              <input type="hidden" name="room_id">
            </form>
          </div>
          <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
            <table class="table table-hover border text-center">
              <thead>
                <tr class="bg-dark text-light sticky-top">
                  <th scope="col" width="60%">Image</th>
                  <th scope="col">Thumb</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody id="room-image-data">                 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Manage 360° images modal -->
  <div class="modal fade" id="room-360-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">360° Images - <span id="room-name-title"></span></h5>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="360-alert"></div>
          <div class="border-bottom border-3 pb-3 mb-3">
            <form id="add_360_form" enctype="multipart/form-data">
              <label class="form-label fw-bold">Add 360° Image Sequence</label>
              <div class="alert alert-info">
                <i class="bi bi-info-circle-fill"></i> Upload images (e.g., room1_001.jpg, room1_002.jpg, etc.)
              </div>
              <input type="file" name="360_images[]" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none mb-3" multiple required>
              <button class="btn custom-bg text-white shadow-none">UPLOAD 360° IMAGES</button>
              <input type="hidden" name="room_id">
            </form>
          </div>
          <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
            <table class="table table-hover border text-center">
              <thead>
                <tr class="bg-dark text-light sticky-top">
                  <th scope="col">Image</th>
                  <th scope="col">Sequence</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody id="room-360-image-data">                 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require('inc/scripts.php'); ?>

  <script src="scripts/rooms.js"></script>
  <script>
    // Function to open 360 images modal
    function view360Images(id, name) {
      document.getElementById('room-name-title').innerText = name;
      document.querySelector('#add_360_form input[name="room_id"]').value = id;
      
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/rooms.php", true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      
      xhr.onload = function() {
        document.getElementById('room-360-image-data').innerHTML = this.responseText;
      }
      
      xhr.send('get_360_images=1&room_id='+id);
      $('#room-360-images').modal('show');
    }

    // Handle 360 image upload
    document.getElementById('add_360_form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      let data = new FormData(this);
      data.append('add_360_images', '1');
      
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/rooms.php", true);
      
      xhr.onload = function() {
        if(this.responseText == 'inv_size') {
          alert('error', 'Only images up to 2MB are allowed!');
        } else if(this.responseText == 'inv_type') {
          alert('error', 'Only JPG, PNG & WEBP images are allowed!');
        } else if(this.responseText == 'upd_failed') {
          alert('error', 'Image upload failed. Server Error!');
        } else {
          alert('success', 'Images uploaded successfully!');
          document.getElementById('room-360-image-data').innerHTML = this.responseText;
          document.getElementById('add_360_form').reset();
        }
      }
      
      xhr.send(data);
    });

    // Delete 360 image
    function delete360Image(img_id, room_id) {
      if(confirm("Are you sure you want to delete this image?")) {
        let data = new URLSearchParams();
        data.append('delete_360_image', '1');
        data.append('img_id', img_id);
        data.append('room_id', room_id);
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
          if(this.responseText == 1) {
            alert('success', 'Image deleted successfully!');
            view360Images(room_id, document.getElementById('room-name-title').innerText);
          } else {
            alert('error', 'Image deletion failed!');
          }
        }
        
        xhr.send(data.toString());
      }
    }
  </script>
</body>
</html>