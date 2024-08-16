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
    // Set interval to send location every 10 seconds
    setInterval(() => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                document.getElementById('status').innerText = `Latitude: ${lat}, Longitude: ${lng}`;

                // Send location to the server
                fetch('{{ route('sales.update.location') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
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
                        } else {
                            console.error('Failed to update location', data);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }, error => {
                console.error(error);
            });
        } else {
            document.getElementById('status').innerText = 'Geolocation is not supported by this browser.';
        }
    }, 5000);
</script>
@yield('scripts')
</body>

</html>
