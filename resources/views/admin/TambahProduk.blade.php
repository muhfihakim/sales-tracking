@extends('admin.Layout.Index')
@section('css')
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
                                <h4 class="card-title">Tambah Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <form method="POST" action="{{ route('aksi.tambah.produk') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="id_produk">ID Produk</label>
                                                <input type="text" class="form-control" id="id_produk" name="id_produk"
                                                    placeholder="Masukkan ID Produk" required>
                                                <small id="id_produk_status"></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_produk">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk"
                                                    name="nama_produk" placeholder="Masukkan Nama Produk" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="qty">Qty Produk</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="qty" name="qty"
                                                        placeholder="Masukkan Kuantitas Produk/Dus" aria-describedby="dus"
                                                        required>
                                                    <span class="input-group-text" id="dus">Dus</span>
                                                </div>
                                                @error('qty')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga Produk (Satuan Dus)</label>
                                                <input type="number" class="form-control" id="harga" name="harga"
                                                    step="0.01" placeholder="Masukkan Harga Produk/Dus" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="gambar">Gambar</label>
                                                <div class="d-flex">
                                                    <input type="file" class="form-control-file" id="gambar"
                                                        name="gambar" accept="image/*">
                                                    <img id="image-preview" src="" alt="Pratinjau Gambar"
                                                        style="display: none; max-width: 200px; margin-left: 20px;">
                                                </div>
                                            </div>
                                            <button type="submit" id="btn-submit" class="btn btn-success btn-sm">Tambah
                                                Produk</button>
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
        $(document).ready(function() {
            $('#id_produk').keyup(function() {
                var id_produk = $(this).val();
                $.ajax({
                    url: '{{ route('check.id.produk') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_produk: id_produk
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#id_produk_status').removeClass('text-success').addClass(
                                'text-danger').text('ID Produk sudah digunakan');
                            $('#btn-submit').prop('disabled',
                                true); // Nonaktifkan tombol submit
                        } else {
                            $('#id_produk_status').removeClass('text-danger').addClass(
                                'text-success').text('ID Produk tersedia');
                            $('#btn-submit').prop('disabled', false); // Aktifkan tombol submit
                        }
                    }
                });
            });

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
        });
    </script>
@endsection
