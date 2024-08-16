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
                                                <label for="nama_produk">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk"
                                                    name="nama_produk"
                                                    value="{{ old('nama_produk', $product->nama_produk) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="qty">Qty</label>
                                                <input type="number" class="form-control" id="qty" name="qty"
                                                    value="{{ old('qty', $product->qty) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga</label>
                                                <input type="number" class="form-control" id="harga" name="harga"
                                                    step="0.01" value="{{ old('harga', $product->harga) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="gambar">Gambar</label>
                                                <input type="file" class="form-control-file" id="gambar"
                                                    name="gambar">
                                                @if ($product->gambar)
                                                    <img src="{{ asset('storage/' . $product->gambar) }}" width="100"
                                                        alt="Gambar Produk">
                                                @endif
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
