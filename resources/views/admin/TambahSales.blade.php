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
                                <h4 class="card-title">Tambah Sales</h4>
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
                                        <form method="POST" action="{{ route('aksi.tambah.sales') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nama">Nama Sales</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    placeholder="Masukkan Nama Sales" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Masukkan Email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Masukkan Password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                                                    required>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                                <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan"
                                                    required>
                                                    <option value="Motor">Motor</option>
                                                    <option value="Mobil">Mobil</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="plat_kendaraan">Plat Kendaraan</label>
                                                <input type="text" class="form-control" id="plat_kendaraan"
                                                    name="plat_kendaraan" placeholder="Gunakan Format : X XXXX XX" required>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm">Tambah Sales</button>
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
@endsection
