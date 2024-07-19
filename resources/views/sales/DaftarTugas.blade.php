@extends('sales.index')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Daftar Tugas</h2>
            <table id="tasks-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Outlet</th>
                        <th>Alamat Outlet</th>
                        <th>Deskripsi Tugas</th>
                        <th>Status</th>
                        <th>Jarak (km)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->outlet->nama }}</td>
                            <td>{{ $task->outlet->alamat }}</td>
                            <td>{{ $task->deskripsi }}</td>
                            <td>{{ $task->status }}</td>
                            <td>{{ $task->distance ? number_format($task->distance, 2) : 'N/A' }}</td>
                            <td>
                                @if ($task->status == 'Selesai')
                                    <span class="badge badge-success">Diselesaikan</span>
                                @else
                                    <form action="{{ route('tugas.sales.selesai', $task->id) }}" method="POST"
                                        style="margin-top: 5px;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger">Selesaikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tasks-table').DataTable();
        });
    </script>
@endsection
