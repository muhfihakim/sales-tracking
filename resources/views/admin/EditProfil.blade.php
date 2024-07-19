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
                                <h4 class="card-title">Edit Profil</h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if ($errors->any() && $errors->has('current_password'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('current_password') }}
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <form action="{{ route('aksi.update.profil') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" id="name" name="nama" class="form-control"
                                                    value="{{ old('name', $user->nama) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" id="email" name="email" class="form-control"
                                                    value="{{ old('email', $user->email) }}" required>
                                            </div>
                                            <hr>
                                            <h3>Ganti Password</h3>
                                            <div class="form-group">
                                                <label for="current_password">Password Saat Ini</label>
                                                <input type="password" id="current_password" name="current_password"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password Baru</label>
                                                <input type="password" id="password" name="password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                                <input type="password" id="password_confirmation"
                                                    name="password_confirmation" class="form-control">
                                            </div>
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
