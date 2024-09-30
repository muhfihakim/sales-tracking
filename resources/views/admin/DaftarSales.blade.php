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
                                <h4 class="card-title">Daftar Sales</h4>
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
                                                <td>ID</td>
                                                <th>Nama Sales</th>
                                                <th>Email</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Jenis Kendaraan</th>
                                                <th>Plat Kendaraan</th>
                                                <th>Total Tugas</th>
                                                <th>Tugas Selesai</th>
                                                <th>Tugas Pending</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sales as $sale)
                                                <tr>
                                                    <td>{{ $sale->id }}</td>
                                                    <td>{{ $sale->nama }}</td>
                                                    <td>{{ $sale->user->email }}</td>
                                                    <td>{{ $sale->jenis_kelamin }}</td>
                                                    <td>{{ $sale->jenis_kendaraan }}</td>
                                                    <td>{{ $sale->plat_kendaraan }}</td>
                                                    <td>{{ $sale->user->tasks->count() ?? 0 }}</td>
                                                    <td>{{ $sale->tugas_selesai }}</td>
                                                    <td>{{ $sale->tugas_pending }}</td>
                                                    <td>
                                                        <a href="{{ route('lihat.tugas.user', $sale->user->id) }}"
                                                            class="btn btn-info btn-sm ml-1">
                                                            <i class="fa fa-tasks"></i> Lihat Tugas
                                                        </a>
                                                        <a href="{{ route('edit.sales', $sale->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('aksi.hapus.sales', $sale->user->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah yakin ingin menghapus Sales ini?')">
                                                                <i class="fa fa-trash-alt"></i> Hapus
                                                            </button>
                                                        </form>
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
