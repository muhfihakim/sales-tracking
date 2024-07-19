<!-- Sidebar -->
<div class="sidebar sidebar-style-2">

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth::user()->nama }}
                            <span class="user-level">{{ Auth::user()->role }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <a href="{{ route('edit.profil') }}">
                                <span class="link-collapse">Edit Profil</span>
                            </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item">
                    <a href="{{ route('page.admin') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#sales">
                        <i class="fas fa-user-friends"></i>
                        <p>Sales</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sales">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('tambah.sales') }}">
                                    <span class="sub-item">Tambah Sales</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('daftar.sales') }}">
                                    <span class="sub-item">Daftar Sales</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#outlet">
                        <i class="fas fa-building"></i>
                        <p>Outlet</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="outlet">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('tambah.outlet') }}">
                                    <span class="sub-item">Tambah Outlet</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('daftar.outlet') }}">
                                    <span class="sub-item">Daftar Outlet</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#tugas">
                        <i class="fas fa-tasks"></i>
                        <p>Tugas</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tugas">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('tambah.tugas') }}">
                                    <span class="sub-item">Tambah Tugas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('daftar.tugas') }}">
                                    <span class="sub-item">Daftar Tugas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#produk">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Produk</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="produk">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="#">
                                    <span class="sub-item">Tambah Produk</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Daftar Produk</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
