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
                                <h4 class="card-title">Daftar Produk</h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Total Harga</th>
                                                <th>Gambar</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{ $product->id }}</td>
                                                    <td>{{ $product->nama_produk }}</td>
                                                    <td>{{ $product->qty }}</td>
                                                    <td>Rp. {{ number_format($product->harga, 2, ',', '.') }}</td>
                                                    <td>Rp.
                                                        {{ number_format($product->harga * $product->qty, 2, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        @if ($product->gambar)
                                                            <button type="button" class="btn btn-info btn-sm"
                                                                data-toggle="modal" data-target="#gambarModal"
                                                                data-image="{{ asset('storage/' . $product->gambar) }}">
                                                                <i class="fa fa-eye"></i> Lihat Gambar
                                                            </button>
                                                        @else
                                                            Tidak ada gambar
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('edit.produk', $product->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('aksi.hapus.produk', $product->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah yakin ingin menghapus Produk ini?')">
                                                                <i class="fa fa-trash-alt"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="gambarModal" tabindex="-1" role="dialog"
                                    aria-labelledby="gambarModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="gambarModalLabel">Gambar Produk</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img id="modalImage" src="" alt="Gambar Produk"
                                                    style="width: 100%;">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
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
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Ketika modal ditampilkan
            $('#gambarModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var imageUrl = button.data('image'); // Ambil URL gambar dari data atribut

                var modal = $(this);
                modal.find('#modalImage').attr('src', imageUrl); // Update src gambar di modal
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});

            $('#multi-filter-select').DataTable({
                "pageLength": 5,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-control"><option value=""></option></select>'
                            )
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d +
                                '</option>')
                        });
                    });
                }
            });
        });
    </script>
@endsection
