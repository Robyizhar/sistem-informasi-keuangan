<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">SMKS AL MUKHLISIYAH</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image"> </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="pages/gallery.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-header">MASTER DATA</li>
                <li class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Siswa </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('angkatan.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Angkatan </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jurusan.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Jurusan </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kelas.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Kelas </p>
                    </a>
                </li>
                <li class="nav-header">TRANSAKSI</li>
                <li class="nav-item">
                    <a href="{{ route('dsp.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Pembayaran DSP </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('spp.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Pembayaran SPP </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengeluaran_spp_dsp.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Pengeluaran SPP Dan DSP </p>
                    </a>
                </li>
                <li class="nav-header">MANAGEMANT USER</li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p class="text">User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Golongan User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="nav-link dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                            Logout
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
