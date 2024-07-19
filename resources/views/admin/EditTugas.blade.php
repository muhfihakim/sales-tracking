@extends('admin.Layout.Index')
@section('css')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
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
                                <h4 class="card-title">Edit Tugas</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <form action="{{ route('aksi.edit.tugas', $task->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="sales_id">Sales</label>
                                                <select class="form-control" id="sales_id" name="sales_id" required>
                                                    @foreach ($sales as $s)
                                                        <option value="{{ $s->id }}"
                                                            {{ $task->sales_id == $s->id ? 'selected' : '' }}>
                                                            {{ $s->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="outlet_id">Outlet</label>
                                                <select class="form-control" id="outlet_id" name="outlet_id" required>
                                                    @foreach ($outlets as $outlet)
                                                        <option value="{{ $outlet->id }}"
                                                            data-alamat="{{ $outlet->alamat }}"
                                                            data-lat="{{ $outlet->latitude }}"
                                                            data-lng="{{ $outlet->longitude }}"
                                                            {{ $task->outlet_id == $outlet->id ? 'selected' : '' }}>
                                                            {{ $outlet->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat_outlet">Alamat Outlet</label>
                                                <input type="text" class="form-control" id="alamat_outlet" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi Tugas</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" required>{{ $task->deskripsi }}</textarea>
                                            </div>
                                            <a href="{{ route('daftar.tugas') }}"
                                                class="btn btn-secondary btn-sm">Kembali</a>
                                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="map" style="height: 400px;"></div>
                                        <small class="form-text text-muted">Peta tersebut menjadi acuan titik
                                            lokasi.</small>
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
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var outletSelect = document.getElementById('outlet_id');
            var alamatInput = document.getElementById('alamat_outlet');

            var map = L.map('map').setView([-6.1751, 106.8650], 13); // Default ke Jakarta

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker = L.marker([-6.1751, 106.8650]).addTo(map); // Default ke Jakarta

            function updateMap(lat, lng) {
                map.setView([lat, lng], 13);
                marker.setLatLng([lat, lng]);
            }

            function updateAlamat(alamat) {
                alamatInput.value = alamat;
            }

            outletSelect.addEventListener('change', function() {
                var selectedOption = outletSelect.options[outletSelect.selectedIndex];
                var alamat = selectedOption.getAttribute('data-alamat');
                var lat = selectedOption.getAttribute('data-lat');
                var lng = selectedOption.getAttribute('data-lng');

                updateAlamat(alamat);
                updateMap(lat, lng);
            });

            // Trigger change event to set initial map and address
            outletSelect.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
