function fetchLocation() {
    $.ajax({
        url: 'https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyALB6uQiBGnyZAJMiS1MAT8ViJmRQea8W0',
        method: 'POST',
        success: function(data) {
            var latitude = data.location.lat;
            var longitude = data.location.lng;
            $.ajax({
                url: 'https://maps.googleapis.com/maps/api/geocode/json',
                data: {
                    latlng: latitude + ',' + longitude,
                    key: 'AIzaSyALB6uQiBGnyZAJMiS1MAT8ViJmRQea8W0' 
                },
                success: function(response) {
                    var locationName = response.results[0].formatted_address || 'Your location';
                    $('#user-location').text(locationName);
                    fetchWeather(latitude, longitude);
                    initializeMap(latitude, longitude);
                },
                error: function() {
                    $('#user-location').text('Unable to fetch location name');
                }
            });
        },
        error: function() {
            alert('Unable to fetch location');
        }
    });
}
function fetchWeather(latitude, longitude) {
    $.ajax({
        url: 'https://api.openweathermap.org/data/2.5/weather',
        data: {
            lat: latitude,
            lon: longitude,
            appid: '643c0faf080d2508eb001ebc61d7f31c',
            units: 'metric'
        },
        success: function(data) {
            $('#weather').text(data.weather[0].description + ', ' + data.main.temp + '°C');
        },
        error: function() {
            $('#weather').text('Unable to fetch weather data');
        }
    });
}
fetchLocation();
setInterval(fetchLocation, 60000);