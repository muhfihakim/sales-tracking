@include('sales.Layout.Header')
@yield('css')
@include('sales.Layout.Navbar')
</div>
@include('sales.Layout.Sidebar')
@yield('content')
{{-- @include('admin.Layout.Footer') --}}
<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<!-- Atlantis JS -->
<script src="{{ asset('assets/js/atlantis.min.js') }}"></script>
<!-- Atlantis DEMO methods, don't include it in your project! -->
<script src="{{ asset('assets/js/setting-demo2.js') }}"></script>
<script>
    // Initialize variables to store the last known location
    let lastLat = null;
    let lastLng = null;

    // Function to send the location to the server
    function sendLocation(lat, lng) {
        const url = '{{ route('sales.update.location') }}'; // Rute yang sesuai
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    sales_id: '{{ auth()->user()->id }}',
                    latitude: lat,
                    longitude: lng
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Location updated successfully');
                    document.getElementById('status').innerText =
                        `Location updated: Latitude: ${lat}, Longitude: ${lng}`;
                } else if (data.status === 'exists') {
                    console.log('Location already exists. No update needed.');
                    document.getElementById('status').innerText =
                        `Location already exists: Latitude: ${lat}, Longitude: ${lng}`;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to check location and send updates
    function checkLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Optionally log the location for debugging
                console.log(`Latitude: ${lat}, Longitude: ${lng}`);

                // Check if the location has changed
                if (lat !== lastLat || lng !== lastLng) {
                    // Update the last known location
                    lastLat = lat;
                    lastLng = lng;

                    // Send location to the server
                    sendLocation(lat, lng);
                } else {
                    console.log('Location has not changed. No need to send update.');
                }
            }, error => {
                console.error('Geolocation error:', error);
            });
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }

    // Set interval to check location every 5 seconds
    setInterval(checkLocation, 5000); // 5000 ms = 5 detik
</script>

@yield('scripts')
</body>

</html>
