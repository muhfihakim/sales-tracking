@extends('sales.Layout.Index')
@section('css')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }

        .leaflet-routing-container {
            display: none;
        }
    </style>
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
                                <h4 class="card-title">Daftar Tugas</h4>
                                {{-- <div id="status">Lokasi Loading...</div> --}}
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <!-- Add map container here -->
                                <div id="map"></div>
                                <div class="table-responsive">
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Outlet</th>
                                                <th>Alamat Outlet</th>
                                                <th>Status</th>
                                                <th>Jarak (km)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $task)
                                                <tr>
                                                    <td>{{ $task->outlet->nama }}</td>
                                                    <td>{{ strlen($task->outlet->alamat) > 10 ? substr($task->outlet->alamat, 0, 10) . '...' : $task->outlet->alamat }}
                                                    </td>
                                                    <td>{{ $task->status }}</td>
                                                    <td>{{ $task->distance ? number_format($task->distance, 2) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if ($task->status == 'Selesai')
                                                            <span class="badge badge-success">Diselesaikan</span>
                                                        @else
                                                            @if ($task->distance && $task->distance <= 0.1)
                                                                <form action="{{ route('tugas.sales.selesai', $task->id) }}"
                                                                    method="POST" style="margin-top: 5px;">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm">Selesaikan</button>
                                                                </form>
                                                            @else
                                                                <span class="badge badge-secondary">Anda Diluar
                                                                    Jangkauan</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });
    </script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine JS -->
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <!-- Leaflet Routing Machine dependencies -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <!-- Turf.js for spatial analysis -->
    <script src="https://unpkg.com/@turf/turf"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the map
            var map = L.map('map').setView([-6.200000, 106.816666], 5); // Center the map on Indonesia

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Cek apakah salesLocation ada dan memiliki latitude dan longitude
            @if (isset($salesLocation) && $salesLocation->latitude && $salesLocation->longitude)
                // Add marker for the sales location (blue)
                L.marker([{{ $salesLocation->latitude }}, {{ $salesLocation->longitude }}], {
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
                        '<b>Lokasi Sales</b><br>Latitude: {{ $salesLocation->latitude }}<br>Longitude: {{ $salesLocation->longitude }}'
                    );

                // Prepare waypoints for routing
                var waypoints = [
                    L.latLng({{ $salesLocation->latitude }},
                        {{ $salesLocation->longitude }}), // Start at the sales location
                    @foreach ($tasks as $task)
                        L.latLng({{ $task->outlet->latitude }}, {{ $task->outlet->longitude }}),
                    @endforeach
                ];

                // Add routing control to show the route and directions
                if (waypoints.length > 1) {
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
                } else {
                    console.log(
                    'Not enough waypoints for routing'); // Debugging: Check if enough waypoints are present
                }

                // Add geofence as a circle around the sales location and each outlet
                function addGeofence(lat, lng, radius, color) {
                    return L.circle([lat, lng], {
                        color: color,
                        fillColor: color,
                        fillOpacity: 0.2,
                        radius: radius // Radius in meters
                    }).addTo(map);
                }

                var geofenceRadius = 50; // Meters
                addGeofence({{ $salesLocation->latitude }}, {{ $salesLocation->longitude }}, geofenceRadius,
                    'green');

                @foreach ($tasks as $task)
                    addGeofence({{ $task->outlet->latitude }}, {{ $task->outlet->longitude }}, geofenceRadius,
                        'red');
                @endforeach
            @else
                // Jika lokasi tidak tersedia, tampilkan pesan
                var message = "Tunggu sampai aplikasi mendapatkan lokasi kamu";
                var popup = L.popup()
                    .setLatLng([-6.200000, 106.816666]) // Posisi popup di tengah peta
                    .setContent(message)
                    .openOn(map);
            @endif
        });
    </script>
@endsection
