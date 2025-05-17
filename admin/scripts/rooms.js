// Room Management Functions
let add_room_form = document.getElementById('add_room_form');
let edit_room_form = document.getElementById('edit_room_form');
let add_image_form = document.getElementById('add_image_form');
let add_360_form = document.getElementById('add_360_form');

// Initialize on page load
window.onload = function() {
    get_all_rooms();
};

// Add Room
add_room_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_room();
});

function add_room() {
    let data = new FormData();
    data.append('add_room', '');
    data.append('name', add_room_form.elements['name'].value);
    data.append('area', add_room_form.elements['area'].value);
    data.append('price', add_room_form.elements['price'].value);
    data.append('quantity', add_room_form.elements['quantity'].value);
    data.append('adult', add_room_form.elements['adult'].value);
    data.append('children', add_room_form.elements['children'].value);
    data.append('desc', add_room_form.elements['desc'].value);

    let features = [];
    add_room_form.elements['features'].forEach(el => {
        if (el.checked) features.push(el.value);
    });

    let facilities = [];
    add_room_form.elements['facilities'].forEach(el => {
        if (el.checked) facilities.push(el.value);
    });

    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function() {
        let modal = bootstrap.Modal.getInstance(document.getElementById('add-room'));
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'New room added!');
            add_room_form.reset();
            get_all_rooms();
        } else {
            alert('error', 'Server Error!');
        }
    }

    xhr.send(data);
}

// Get All Rooms
function get_all_rooms() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        console.log('Rooms List Response:', this.responseText); // Debugging

        if (this.responseText.trim() != "") {
            document.getElementById('rooms-container').innerHTML = this.responseText;
        } else {
            document.getElementById('rooms-container').innerHTML = '<p>No rooms found.</p>';
        }
    }

    xhr.send('get_all_rooms');
}

// Edit Room
function edit_details(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        
        edit_room_form.elements['name'].value = data.roomdata.name;
        edit_room_form.elements['area'].value = data.roomdata.area;
        edit_room_form.elements['price'].value = data.roomdata.price;
        edit_room_form.elements['quantity'].value = data.roomdata.quantity;
        edit_room_form.elements['adult'].value = data.roomdata.adult;
        edit_room_form.elements['children'].value = data.roomdata.children;
        edit_room_form.elements['desc'].value = data.roomdata.description;
        edit_room_form.elements['room_id'].value = data.roomdata.id;

        edit_room_form.elements['features'].forEach(el => {
            el.checked = data.features.includes(Number(el.value));
        });

        edit_room_form.elements['facilities'].forEach(el => {
            el.checked = data.facilities.includes(Number(el.value));
        });
    }

    xhr.send('get_room=' + id);
}

edit_room_form.addEventListener('submit', function(e) {
    e.preventDefault();
    submit_edit_room();
});

function submit_edit_room() {
    let data = new FormData();
    data.append('edit_room', '');
    data.append('room_id', edit_room_form.elements['room_id'].value);
    data.append('name', edit_room_form.elements['name'].value);
    data.append('area', edit_room_form.elements['area'].value);
    data.append('price', edit_room_form.elements['price'].value);
    data.append('quantity', edit_room_form.elements['quantity'].value);
    data.append('adult', edit_room_form.elements['adult'].value);
    data.append('children', edit_room_form.elements['children'].value);
    data.append('desc', edit_room_form.elements['desc'].value);

    let features = [];
    edit_room_form.elements['features'].forEach(el => {
        if (el.checked) features.push(el.value);
    });

    let facilities = [];
    edit_room_form.elements['facilities'].forEach(el => {
        if (el.checked) facilities.push(el.value);
    });

    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function() {
        let modal = bootstrap.Modal.getInstance(document.getElementById('edit-room'));
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'Room updated successfully!');
            get_all_rooms();
        } else {
            alert('error', 'Server Error!');
        }
    }

    xhr.send(data);
}

// Toggle Room Status
function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Status updated!');
            get_all_rooms();
        } else {
            alert('error', 'Server Error!');
        }
    }

    xhr.send('toggle_status=' + id + '&value=' + val);
}

// Room Images Management
add_image_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_image();
});

function add_image() {
    let data = new FormData();
    data.append('image', add_image_form.elements['image'].files[0]);
    data.append('room_id', add_image_form.elements['room_id'].value);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function() {
        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG, PNG, WEBP, or TIFF images allowed!', 'image-alert'); // Updated message
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image must be less than 2MB!', 'image-alert');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Upload failed. Server Error!', 'image-alert');
        } else if (this.responseText == 1) {
            alert('success', 'Image added!', 'image-alert');
            room_images(add_image_form.elements['room_id'].value, document.querySelector("#room-images .modal-title").innerText);
            add_image_form.reset();
        }
    }

    xhr.send(data);
}

function room_images(id, rname) {
    document.querySelector("#room-images .modal-title").innerText = rname;
    add_image_form.elements['room_id'].value = id;
    add_image_form.elements['image'].value = '';

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('room-image-data').innerHTML = this.responseText;
    }

    xhr.send('get_room_images=' + id);
}

function rem_image(img_id, room_id) {
    if (confirm("Are you sure you want to delete this image?")) {
        let data = new FormData();
        data.append('image_id', img_id);
        data.append('room_id', room_id);
        data.append('rem_image', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms.php", true);

        xhr.onload = function() {
            if (this.responseText == 1) {
                alert('success', 'Image deleted!', 'image-alert');
                room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
            } else {
                alert('error', 'Delete failed!', 'image-alert');
            }
        }

        xhr.send(data);
    }
}

function thumb_image(img_id, room_id) {
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id', room_id);
    data.append('thumb_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Thumbnail set!', 'image-alert');
            room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
        } else {
            alert('error', 'Operation failed!', 'image-alert');
        }
    }

    xhr.send(data);
}

// 360° Images Management
function view360Images(id, name) {
    document.getElementById('room-name-title').innerText = name;
    document.querySelector('#add_360_form input[name="room_id"]').value = id;
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        document.getElementById('room-360-image-data').innerHTML = this.responseText;
    }
    
    xhr.send('get_360_images=1&room_id=' + id);
}

add_360_form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    let data = new FormData(this);
    data.append('add_360_images', '1');
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', '360° images uploaded!', '360-alert');
            view360Images(
                document.querySelector('#add_360_form input[name="room_id"]').value,
                document.getElementById('room-name-title').innerText
            );
            add_360_form.reset();
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Images must be under 2MB!', '360-alert');
        } else {
            alert('error', 'Only JPG, PNG, WEBP, or TIFF allowed, or upload failed!', '360-alert'); // Updated message
        }
    }
    
    xhr.send(data);
});

function delete360Image(img_id, room_id) {
    if (confirm("Delete this 360° image permanently?")) {
        let data = new URLSearchParams();
        data.append('delete_360_image', '1');
        data.append('img_id', img_id);
        data.append('room_id', room_id);
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (this.responseText == 1) {
                alert('success', 'Image deleted!', '360-alert');
                view360Images(room_id, document.getElementById('room-name-title').innerText);
            } else {
                alert('error', 'Delete failed!', '360-alert');
            }
        }
        
        xhr.send(data.toString());
    }
}

// Remove Room
function remove_room(room_id) {
    if (confirm("Permanently delete this room and all its images?")) {
        let data = new FormData();
        data.append('room_id', room_id);
        data.append('remove_room', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms.php", true);

        xhr.onload = function() {
            console.log('Server Response:', this.responseText); // Debugging

            if (this.responseText.trim() == "1") { // Ensure response is exactly "1"
                alert('success', 'Room deleted!');
                get_all_rooms(); // Refresh the room list
            } else {
                alert('error', 'Room removal failed!');
            }
        }

        xhr.send(data);
    }
}