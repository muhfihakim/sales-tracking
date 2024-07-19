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
                                <h4 class="card-title">Tambah Tugas</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <form method="POST" action="{{ route('aksi.tambah.tugas') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="sales_id">Sales yang Ditugaskan</label>
                                                <select class="form-control" id="sales_id" name="sales_id" required>
                                                    @foreach ($users as $user)
                                                        @if ($user->role == 'Sales')
                                                            <!-- Pastikan hanya menampilkan Sales -->
                                                            <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="outlet_id">Tujuan Outlet</label>
                                                <select class="form-control" id="outlet_id" name="outlet_id" required>
                                                    @foreach ($outlets as $outlet)
                                                        <option value="{{ $outlet->id }}">{{ $outlet->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi Tugas</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
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
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
@endsection
