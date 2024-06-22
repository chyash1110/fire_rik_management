function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}
function showPosition(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    document.getElementById('latitude').value = latitude;
    document.getElementById('longitude').value = longitude;
    var geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyALB6uQiBGnyZAJMiS1MAT8ViJmRQea8W0`;
    fetch(geocodeUrl)
        .then(response => response.json())
        .then(data => {
            if (data.results && data.results.length > 0) {
                document.getElementById('location').value = data.results[0].formatted_address;
            } else {
                document.getElementById('location').value = 'Unable to determine address';
            }
        })
        .catch(error => {
            console.error('Error fetching the address:', error);
            document.getElementById('location').value = 'Unable to determine address';
        });
}
function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}

getLocation();
