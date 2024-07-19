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
                                <h4 class="card-title">Tambah Outlet</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <form method="POST" action="{{ route('aksi.tambah.outlet') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="id_outlet">ID Outlet</label>
                                                <input type="text" class="form-control" id="id_outlet" name="id_outlet"
                                                    required>
                                                <small id="id_outlet_status"></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_outlet">Nama Outlet</label>
                                                <input type="text" class="form-control" id="nama_outlet"
                                                    name="nama_outlet" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat_outlet">Alamat Outlet</label>
                                                <textarea class="form-control" id="alamat_outlet" name="alamat_outlet" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="latitude">Latitude</label>
                                                <input type="text" class="form-control" id="latitude" name="latitude"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="longitude">Longitude</label>
                                                <input type="text" class="form-control" id="longitude" name="longitude"
                                                    readonly>
                                            </div>
                                            <button type="submit" id="btn-submit" class="btn btn-success btn-sm">Tambah
                                                Outlet</button>
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
    <script>
        $(document).ready(function() {
            $('#id_outlet').keyup(function() {
                var id_outlet = $(this).val();
                $.ajax({
                    url: '{{ route('check.id.outlet') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_outlet: id_outlet
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#id_outlet_status').removeClass('text-success').addClass(
                                'text-danger').text('ID Outlet sudah digunakan');
                            $('#btn-submit').prop('disabled',
                                true); // Nonaktifkan tombol submit
                        } else {
                            $('#id_outlet_status').removeClass('text-danger').addClass(
                                'text-success').text('ID Outlet tersedia');
                            $('#btn-submit').prop('disabled', false); // Aktifkan tombol submit
                        }
                    }
                });
            });
        });
    </script>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet Control Geocoder JavaScript -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        var map = L.map('mapid').setView([-6.2088, 106.8456], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;

        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            collapsed: false,
            geocoder: L.Control.Geocoder.nominatim(),
            suggestMinLength: 3, // Jumlah minimum karakter sebelum pencarian dimulai
            suggestTimeout: 250, // Waktu penundaan (ms) setelah pengguna berhenti mengetik sebelum memulai pencarian
        }).addTo(map);

        // Fungsi untuk menangani hasil pencarian dan menambahkan marker
        geocoder.on('markgeocode', function(e) {
            var latlng = e.geocode.center;

            // Hapus marker sebelumnya jika ada
            if (marker) {
                map.removeLayer(marker);
            }

            marker = new L.Marker(latlng, {
                draggable: true
            }).addTo(map);

            // Set view peta ke lokasi hasil pencarian dengan zoom level 16
            map.setView(latlng, 16);

            // Update nilai latitude dan longitude di form
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;

            // Event listener untuk menangani perubahan posisi marker
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
            });
        });

        // Event listener untuk menambahkan marker secara manual
        map.on('click', function(e) {
            var clickedLatLng = e.latlng;

            // Hapus marker sebelumnya jika ada
            if (marker) {
                map.removeLayer(marker);
            }

            // Tambahkan marker baru pada posisi yang diklik pengguna
            marker = new L.Marker(clickedLatLng, {
                draggable: true
            }).addTo(map);

            // Set view peta ke lokasi yang diklik dengan zoom level 16
            map.setView(clickedLatLng, 16);

            // Update nilai latitude dan longitude di form
            document.getElementById('latitude').value = clickedLatLng.lat;
            document.getElementById('longitude').value = clickedLatLng.lng;

            // Event listener untuk menangani perubahan posisi marker
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                document.getElementById('latitude').value = position.lat;
                document.getElementById('longitude').value = position.lng;
            });
        });
    </script>
@endsection
