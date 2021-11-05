
//Main getLocation function, takes in function props
function getLocation(props) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(props);
    }
    else {
        console.log("Geolocation is not supported.")
    }
}


//Function for search bar, which gets latitude and longitude and fills it in the search bar
function search(position) {
    document.getElementById("search").value = position.coords.latitude + ", " + position.coords.longitude
}


//Function to autoset the latitude with current position on subimssion page 
function autoSetLat(position){
    document.getElementById("Latitude").value = position.coords.latitude
}


//Function to autoset the longitude with current position on subimssion page
function autoSetLong(position){
    document.getElementById("Longitude").value = position.coords.longitude
}


// Main function for initializing a map, takes center location, zoom level, and which markers to place as well as if the markers should be opened.
function initMapMain(center, zoom, markers, openMarkers=false) {
    // The map, centered at "center"
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: zoom,
      center: center,
    });

    //Hide points of interests 
    map.setOptions({styles: styles["hide"]});

    //Creates markers based on the given markers array, and opens markers by default if openMarkers is true.
    markers.forEach((marker)=>{
        var Marker = new google.maps.Marker({
            position: marker.coordinates,
            map: map
        })
        var infoWindow = new google.maps.InfoWindow({
            content: marker.content
        })
        Marker.addListener('click', function(){
            infoWindow.open(map, Marker);
        })
        if (openMarkers) {
            infoWindow.open(map, Marker)
        }
    }) 
}


//Map function for results page, initializes center and zoom and creates a list of markers before calling initMapMain
function initMap() {
    // The location of Hamilton
    const center = { lat: 43.2202, lng: -79.8652 };
    const zoom = 13;

    // list of markers
    let markers = [
        {
            coordinates: { lat: 43.2303, lng: -79.8866 },
            content:
            '<h5><a href="individual_sample.html">Hamilton Public Library - Terryberry Branch</a></h5>' + 
            '<h6>3 stars</h6>' +
            '<p>100 Mohawk Rd W, Hamilton, ON</p>'
        },
        {
            coordinates: { lat: 43.2378, lng: -79.8859 },
            content:
            '<h5><a href="individual_sample.html">Mohawk College Library</a></h5>' + 
            '<h6>4 stars</h6>' +
            '<p>135 Fennell Ave W, Hamilton, ON</p>'
        },
        {
            coordinates: { lat: 43.1979, lng: -79.8788 },
            content:
            '<h5><a href="individual_sample.html">Hamilton Public Library - Turner Park Branch</a></h5>' + 
            '<h6>5 stars</h6>' +
            '<p>352 Rymal Rd E, Hamilton, ON</p>'    
        },
        {
            coordinates: { lat: 43.2264, lng: -79.8288 },
            content:
            '<h5><a href="individual_sample.html">Hamilton Public Library - Sherwood Branch</a></h5>' + 
            '<h6>3 stars</h6>' +
            '<p>467 Upper Ottawa St, Hamilton, ON</p>'   
        },
        {
            coordinates: { lat: 43.2409, lng: -79.8513 },
            content:
            '<h5><a href="individual_sample.html">Hamilton Public Library - Concession Branch</a></h5>' + 
            '<h6>4 stars</h6>' +
            '<p>565 Consession St, Hamilton, ON</p>'     
        }
    ]

    initMapMain(center, zoom, markers)
}


//Map function for individual sample page, initializes center and zoom and creates a markers before calling initMapMain
function TerryBerry() {
    const center = { lat: 43.2303, lng: -79.8866 };
    const zoom = 15;
    const openMarkers = true;

    const markers = [
        {
            coordinates: { lat: 43.2303, lng: -79.8866 },
            content:
            '<h5><a href="individual_sample.html">Hamilton Public Library - Terryberry Branch</a></h5>' + 
            '<h6>3 stars</h6>' +
            '<p>100 Mohawk Rd W, Hamilton, ON</p>'
        }
    ]
    initMapMain(center, zoom, markers, openMarkers)
}


//styles for hiding buisnesses and governemnt points of interest (such as libraries)
const styles = {
    default: [],
    hide: [
      {
        featureType: "poi.business",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "poi.government",
        stylers: [{ visibility: "off" }],
      },
    ],
  };


//form validation function that is run to validate each input.
function validate(form) {
    if (!validateName(form.firstName.value, "First name")) {
        return false;
    }
    if (!validateName(form.lastName.value, "Last name")){
        return false;    
    }
    if (!validateGender(form.gender.value)){
        return false;
    }
    if (!validateEmail(form.userEmail.value)){
        return false;
    }
    if (!validatePassword(form.userPassword.value)){
        return false;
    }
    if (!validateDate(form.userBday.value)){
        return false;
    }
    return true;
}


//checks that name is filled in, starts with a capital letter, and only contains letters and spaces.
function validateName(name, text) {
    if (name == "") {
        window.alert(text + " is required.");
        return false;
    }
    if (!(/^([A-Z])/.test(name))) {
        window.alert("Capitalize first letter for " + text);
        return false;
    }
    if (!(/^([a-zA-Z ]){1,30}$/.test(name))) {
        window.alert("Only letters allowed for " + text);
        return false;
    }
    return true;
}


//checks that a gender is selected.
function validateGender(gender) {
    if (!gender){
        window.alert("Gender is required.");
        return false;    
    }
    return true;
}


//checks that email is filled in and follows proper format.
function validateEmail(email){
    if (email == "") {
        window.alert("Email is required.");
        return false;
    }
    if (!(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,})+$/.test(email))) {
        window.alert("Invalid Email");
        return false;
    }
    return true;
}


//checks that a password is given.
function validatePassword(password) {
    if (password == "") {
        window.alert("Password is required.");
        return false;
    }
    return true;
}


//checks that a birthdate is given and follows proper format (also limited to 1800s oldest.)
function validateDate(date){
    if (date == "") {
        window.alert("Birthdate is required.");
        return false;
    }
    if (!(/^(18|19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/.test(date))) {
        window.alert("Invalid date");
        return false;
    }
    return true;
}


//checks that TOS is selected before enabling the registration button.
function validateTOS(){
    const checkbox = document.getElementById("TOS")
    registerBtn = document.getElementById("registerBtn")
    if (checkbox.checked) {
        registerBtn.disabled = false;
    }
    else {
        registerBtn.disabled = true;
    }
}