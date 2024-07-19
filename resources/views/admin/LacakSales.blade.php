@extends('admin.Layout.Index')
@section('css')
    <style>
        /* Custom CSS for the map */
        #map {
            height: 500px;
            width: 100%;
            border: 0;
        }
    </style>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
@endsection
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Sistem Informasi Sales dan Pengiriman</h4>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Peta Lokasi Sales: {{ $task->sales->nama }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine JS -->
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <!-- Leaflet Routing Machine dependencies -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([-6.200000, 106.816666], 5); // Center the map on Indonesia

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© Baraya Bareng Sadulur'
        }).addTo(map);

        // Placeholder for multiple waypoints (sales tasks)
        var waypoints = [
            L.latLng({{ $latestLocation->latitude }}, {{ $latestLocation->longitude }}), // Start at the latest location
            @foreach ($salesTasks as $task)
                L.latLng({{ $task->outlet->latitude }}, {{ $task->outlet->longitude }}),
            @endforeach
        ];

        // Add marker for the latest location (blue)
        var latestLocationMarker = L.marker([{{ $latestLocation->latitude }}, {{ $latestLocation->longitude }}], {
                icon: L.icon({
                    iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                })
            }).addTo(map)
            .bindPopup(
                '<b>Lokasi Terkini</b><br>Latitude: {{ $latestLocation->latitude }}<br>Longitude: {{ $latestLocation->longitude }}'
            )
            .openPopup();

        // Add markers for outlets (red)
        @foreach ($salesTasks as $task)
            var outletMarker = L.marker([{{ $task->outlet->latitude }}, {{ $task->outlet->longitude }}], {
                    icon: L.icon({
                        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    })
                })
                .addTo(map)
                .bindPopup(
                    '<b>Lokasi Outlet</b><br>Nama Outlet: {{ $task->outlet->name }}<br>Latitude: {{ $task->outlet->latitude }}<br>Longitude: {{ $task->outlet->longitude }}'
                );
        @endforeach

        // Add routing control to show the route and directions
        L.Routing.control({
            waypoints: waypoints,
            routeWhileDragging: false,
            geocoder: L.Control.Geocoder.nominatim(),
            lineOptions: {
                styles: [{
                    color: 'blue',
                    opacity: 1,
                    weight: 5
                }]
            }
        }).addTo(map);
    </script>
@endsection
