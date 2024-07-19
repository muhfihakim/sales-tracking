<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales and Delivery Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    @yield('css')
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Sales Management</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Sales
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('daftar.sales') }}">Daftar Sales</a></li>
                            <li><a href="{{ route('tambah.sales') }}">Tambah Sales</a></li>
                            <li><a href="#">Lacak Sales</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tugas
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('daftar.tugas') }}">Daftar Tugas</a></li>
                            <li><a href="{{ route('tambah.tugas') }}">Tambah Tugas</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Outlet
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('daftar.outlet') }}">Daftar Outlet</a></li>
                            <li><a href="{{ route('tambah.outlet') }}">Tambah Outlet</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Produk
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Daftar Produk</a></li>
                            <li><a href="#">Tambah Produk</a></li>
                        </ul>
                    </li>
                    <li>
                        <form action="{{ route('aksi.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>

@yield('scripts')

</html>
