@extends('admin.Layout.Index')
@section('css')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Kustomisasi tampilan Select2 agar konsisten dengan form-control */
        .select2-container--default .select2-selection--single {
            border: 1px solid #ebedf2;
            /* Sesuaikan dengan border form-control */
            border-radius: .25rem;
            /* Sesuaikan dengan border-radius form-control */
            height: calc(2.25rem + 2px);
            /* Sesuaikan dengan tinggi form-control */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            /* Sesuaikan dengan tinggi form-control */
            padding: 0.375rem 0.75rem;
            /* Sesuaikan dengan padding form-control */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
            /* Sesuaikan dengan tinggi form-control */
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
                                <h4 class="card-title">Tambah Tugas</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <form method="POST" action="{{ route('aksi.tambah.tugas') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="sales_id">Sales Yang Ditugaskan</label>
                                                <select class="form-control" id="sales_id" name="sales_id" required>
                                                    @foreach ($users as $user)
                                                        @if ($user->role == 'Sales')
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->sales_id }} - {{ $user->nama }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="outlet_id">Tujuan Outlet</label>
                                                <select class="form-control" id="outlet_id" name="outlet_id" required>
                                                    @foreach ($outlets as $outlet)
                                                        <option value="{{ $outlet->id }}">
                                                            {{ $outlet->id }} - {{ $outlet->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="product_id">Nama Produk</label>
                                                <select class="form-control" id="product_id" name="product_id" required>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->nama_produk }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="qty">Qty Produk</label>
                                                <input type="number" class="form-control" id="qty" name="qty"
                                                    min="1" placeholder="Masukkan Kuantitas Produk" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi Tugas</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Opsional"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm">Tambah Tugas</button>
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
@endsection

@section('scripts')
    <!-- jQuery (harus ada sebelum Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#sales_id').select2({
                placeholder: 'Pilih Sales Yang Akan Ditugaskan',
                allowClear: false
            });

            $('#outlet_id').select2({
                placeholder: 'Pilih Outlet Tujuan',
                allowClear: false
            });

            $('#product_id').select2({
                placeholder: 'Pilih Produk Yang Akan Dikirim',
                allowClear: false
            });
        });
    </script>
@endsection
