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

$(document).ready(function() {
    $('#transportation_id').on('change', function() {
        var serviceId = $(this).val();
        if (serviceId) {
            $.ajax({
                url: 'fetch_transport_options.php', 
                type: 'POST',
                data: { service_id: serviceId },
                success: function(response) {
                    $('#service-details').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching service details:', error);
                }
            });
        } else {
            $('#service-details').empty();
        }
    });
});

$(document).ready(function() {
    $('.spread-time').each(function() {
        var incidentId = $(this).data('incident-id');
        var $spreadTimeElement = $(this);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                $.ajax({
                    url: 'predict_fire_spread.php',
                    type: 'POST',
                    data: {
                        incident_id: incidentId,
                        latitude: latitude,
                        longitude: longitude
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.spread_time) {
                            $spreadTimeElement.text(data.spread_time + ' hours');
                        } else {
                            $spreadTimeElement.text('Unable to calculate');
                        }
                    },
                    error: function() {
                        $spreadTimeElement.text('Error fetching data');
                    }
                });
            });
        } else {
            $spreadTimeElement.text('Geolocation not supported');
        }
    });
});

fetchLocation();
setInterval(fetchLocation, 60000);