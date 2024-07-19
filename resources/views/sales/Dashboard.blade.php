@extends('sales.index')
@section('content')
    <div id="status"></div>
@endsection
@section('scripts')
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
        }, 10000);
    </script>
@endsection
