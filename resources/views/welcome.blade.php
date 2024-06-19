<!DOCTYPE html>
<html>

<head>
    <title>Get Accurate Location</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <button onclick="getLocation()">Get Accurate Location</button>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            const accuracy = position.coords.accuracy;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Kirim koordinat ke backend
            fetch('/save-location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        latitude: latitude,
                        longitude: longitude,
                        accuracy: accuracy
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Location saved:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
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
    </script>
</body>

</html>
