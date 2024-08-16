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
                                <div class="table-responsive">
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Outlet</th>
                                                <th>Outlet</th>
                                                <th>ID Produk</th>
                                                <th>Sales</th>
                                                <th>Tujuan Sales</th>
                                                <th>Deskripsi Tugas</th>
                                                <th>Status</th>
                                                <th>Waktu Penyelesaian</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $task)
                                                <tr>
                                                    <td>{{ $task->outlet->id }}</td>
                                                    <td>{{ $task->outlet->nama }}</td>
                                                    <td>{{ $task->product_id }}</td>
                                                    <td>{{ $task->sales->nama }}</td>
                                                    <td>{{ excerpt($task->outlet->alamat, 40) }}</td>
                                                    <td>{{ $task->deskripsi }}</td>
                                                    <td>{{ $task->status }}</td>
                                                    <td>
                                                        @if ($task->status == 'Selesai' && $task->updated_at)
                                                            {{ $task->updated_at->format('H:i / d-m-Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('lacak.sales', $task->id) }}"
                                                            class="btn btn-success btn-sm"><i
                                                                class="fas fa-location-arrow"></i> Lacak Sales</a>
                                                        <a href="{{ route('edit.tugas', $task->id) }}"
                                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit
                                                            Tugas</a>
                                                        <!-- Dropdown untuk mengubah status -->
                                                        <div class="dropdown" style="display:inline;">
                                                            <button class="btn btn-secondary dropdown-toggle btn-sm"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"> <i class="fas fa-truck"></i> Ubah
                                                                Status
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <form action="{{ route('tasks.updateStatus', $task->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="Dibatalkan">
                                                                    <button type="submit" class="dropdown-item">Batalkan
                                                                        Tugas</button>
                                                                </form>
                                                                <form action="{{ route('tasks.updateStatus', $task->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="Selesai">
                                                                    <button type="submit" class="dropdown-item">Tandai
                                                                        Selesai</button>
                                                                </form>
                                                            </div>
                                                        </div>
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
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });
    </script>
@endsection
