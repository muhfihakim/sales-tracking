@extends('admin.Layout.Index')
@section('css')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet Control Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
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
                                <h4 class="card-title">Edit Outlet</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <form method="POST" action="{{ route('aksi.edit.outlet', $outlet->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="id_outlet">ID Outlet</label>
                                                <input type="text" class="form-control" id="id_outlet" name="id_outlet"
                                                    value="{{ $outlet->id }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_outlet">Nama Outlet</label>
                                                <input type="text" class="form-control" id="nama_outlet"
                                                    name="nama_outlet" value="{{ $outlet->nama }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat_outlet">Alamat Outlet</label>
                                                <textarea class="form-control" id="alamat_outlet" name="alamat_outlet" rows="3">{{ $outlet->alamat }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="latitude">Latitude</label>
                                                <input type="text" class="form-control" id="latitude" name="latitude"
                                                    value="{{ $outlet->latitude }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="longitude">Longitude</label>
                                                <input type="text" class="form-control" id="longitude" name="longitude"
                                                    value="{{ $outlet->longitude }}">
                                            </div>
                                            <a href="{{ route('daftar.outlet') }}"
                                                class="btn btn-secondary btn-sm">Kembali</a>
                                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="mapid" style="height: 400px;"></div>
                                        <small class="form-text text-muted">Klik pada peta untuk menentukan lokasi.</small>
                                    </div>
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
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet Control Geocoder JavaScript -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        var map = L.map('mapid').setView([{{ $outlet->latitude }}, {{ $outlet->longitude }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;

        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            collapsed: false,
            geocoder: L.Control.Geocoder.nominatim(),
            suggestMinLength: 3, // Minimum number of characters before search starts
            suggestTimeout: 250, // Delay time (ms) after user stops typing before starting search
        }).addTo(map);

        // Function to handle geocoding results and add marker
        geocoder.on('markgeocode', function(e) {
            var latlng = e.geocode.center;

            // Remove previous marker if exists
            if (marker) {
                map.removeLayer(marker);
            }

            marker = new L.Marker(latlng, {
                draggable: true
            }).addTo(map);

            // Set map view to the geocoded location with zoom level 16
            map.setView(latlng, 16);

            // Update latitude and longitude values in form
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;

            // Event listener to handle marker position change
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
            });
        });

        // Event listener to manually add marker on map click
        map.on('click', function(e) {
            var clickedLatLng = e.latlng;

            // Remove previous marker if exists
            if (marker) {
                map.removeLayer(marker);
            }

            // Add new marker at clicked location
            marker = new L.Marker(clickedLatLng, {
                draggable: true
            }).addTo(map);

            // Set map view to clicked location with zoom level 16
            map.setView(clickedLatLng, 16);

            // Update latitude and longitude values in form
            document.getElementById('latitude').value = clickedLatLng.lat;
            document.getElementById('longitude').value = clickedLatLng.lng;

            // Event listener to handle marker position change
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
            });
        });
    </script>
@endsection
