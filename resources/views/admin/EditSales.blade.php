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
                                <h4 class="card-title">Edit Sales</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <form action="{{ route('aksi.edit.sales', $sales->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="nama">Nama Sales</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ $sales->nama }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $sales->user->email }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Biarkan kosong jika tidak ingin mengubah password">
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                                                    required>
                                                    <option value="Laki-laki"
                                                        {{ $sales->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki</option>
                                                    <option value="Perempuan"
                                                        {{ $sales->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                                <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan"
                                                    required>
                                                    <option value="Motor"
                                                        {{ $sales->jenis_kendaraan == 'Motor' ? 'selected' : '' }}>Motor
                                                    </option>
                                                    <option value="Mobil"
                                                        {{ $sales->jenis_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="plat_kendaraan">Plat Kendaraan</label>
                                                <input type="text" class="form-control" id="plat_kendaraan"
                                                    name="plat_kendaraan" value="{{ $sales->plat_kendaraan }}" required>
                                            </div>
                                            <a href="{{ route('daftar.sales') }}"
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
@section('scripts')
@endsection
