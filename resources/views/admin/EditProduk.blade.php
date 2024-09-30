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
                                <h4 class="card-title">Edit Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <form action="{{ route('aksi.edit.produk', $product->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="nama_produk">ID Produk</label>
                                                <input type="text" class="form-control" id="id_produk" name="id_produk"
                                                    value="{{ old('id_produk', $product->id) }}"
                                                    placeholder="Masukkan Nama Produk" disabled>
                                                <small>ID Outlet Tidak Bisa Diubah.</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_produk">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk"
                                                    name="nama_produk"
                                                    value="{{ old('nama_produk', $product->nama_produk) }}"
                                                    placeholder="Masukkan Nama Produk" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="qty">Qty Produk</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="qty" name="qty"
                                                        value="{{ old('qty', $product->qty) }}"
                                                        placeholder="Masukkan Kuantitas Produk/Dus" aria-describedby="dus"
                                                        required>
                                                    <span class="input-group-text" id="dus">Dus</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga Produk</label>
                                                <input type="number" class="form-control" id="harga" name="harga"
                                                    step="0.01" value="{{ old('harga', $product->harga) }}"
                                                    placeholder="Masukkan Harga Produk" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="gambar">Gambar</label>
                                                <div class="d-flex">
                                                    <input type="file" class="form-control-file" id="gambar"
                                                        name="gambar">
                                                    <img id="image-preview"
                                                        src="{{ $product->gambar ? asset('storage/' . $product->gambar) : '' }}"
                                                        alt="Pratinjau Gambar"
                                                        style="display: {{ $product->gambar ? 'block' : 'none' }}; max-width: 200px; margin-left: 20px;">
                                                </div>
                                            </div>
                                            <a href="{{ route('daftar.produk') }}"
                                                class="btn btn-secondary btn-sm">Kembali</a>
                                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                        </form>
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
        // Pratinjau gambar
        $('#gambar').on('change', function() {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result).show();
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                $('#image-preview').hide();
            }
        });
    </script>
@endsection
