

function getLocation(props) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(props);
    }
    else {
        console.log("Geolocation is not supported.")
    }
}


function search(position) {
    document.getElementById("search").value = position.coords.latitude + ", " + position.coords.longitude
}


function autoSetLat(position){
    document.getElementById("Latitude").value = position.coords.latitude
}


function autoSetLong(position){
    document.getElementById("Longitude").value = position.coords.longitude
}


function initMapMain(center, zoom, markers, openMarkers=false) {
    // The map, centered at "center"
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: zoom,
      center: center,
    });

    //Hide points of interests 
    map.setOptions({styles: styles["hide"]});

    if (!openMarkers) {
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
        })
    }
    else {
        markers.forEach((marker)=>{
            var Marker = new google.maps.Marker({
                position: marker.coordinates,
                map: map
            })
            var infoWindow = new google.maps.InfoWindow({
                content: marker.content
            })
            infoWindow.open(map, Marker)
        })

    }   
}


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


function validate(form) {
    validateName(form.firstName.value, "First name")
    validateName(form.lastName.value, "Last name")
    validateGender(form.gender.value)
    validateEmail(form.userEmail.value)
    validatePassword(form.userPassword.value)
    validateDate(form.userBday.value)
}


function validateName(name, text) {
    if (name == "") {
        window.alert(text + " is required.");
        return false;
    }
    if (!(/[A-Za-z-]+/.test(name))) {
        window.alert("Only letters and - allowed for " + text);
        return false;
    }
}


function validateGender(gender) {
    if (!gender){
        window.alert("Gender is required.");
        return false;    
    }
}


function validateEmail(email){
    if (email == "") {
        window.alert("Email is required.");
        return false;
    }
    if (!(/[A-Za-z0-9._-]+/.test(email))) {
        window.alert("Only letters and - allowed for " + text);
        return false;
    }
    
}


function validatePassword(password) {
    if (password == "") {
        window.alert("Password is required.");
        return false;
    }

}


function validateDate(date){
    if (date == "") {
        window.alert("Birthdate is required.");
        return false;
    }
}


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