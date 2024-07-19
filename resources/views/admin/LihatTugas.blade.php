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
                                <h4 class="card-title">Daftar Tugas</h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if ($tasks->isEmpty())
                                    <div class="alert alert-info" role="alert">
                                        Tidak ada tugas saat ini.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table id="tasks-table" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID Outlet</th>
                                                    <th>Outlet</th>
                                                    <th>Tujuan Sales</th>
                                                    <th>Deskripsi Tugas</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tasks as $task)
                                                    <tr>
                                                        <td>{{ $task->outlet->id }}</td>
                                                        <td>{{ $task->outlet->nama }}</td>
                                                        <td>{{ excerpt($task->outlet->alamat, 40) }}</td>
                                                        <td>{{ $task->deskripsi }}</td>
                                                        <td>{{ $task->status }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                                <a href="{{ route('daftar.sales') }}" class="btn btn-secondary btn-sm">Kembali</a>
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
            $('#tasks-table').DataTable({});

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
