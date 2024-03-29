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
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                {{-- SISWA --}}
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->getRoleNames()[0] == 'Siswa')
                <li class="nav-item">
                    <a href="{{ url('data-pembayaran/spp') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Pembayaran SPP </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->getRoleNames()[0] == 'Siswa')
                <li class="nav-item">
                    <a href="{{ url('data-pembayaran/dsp') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Pembayaran DSP </p>
                    </a>
                </li>
                @endif
                {{-- SISWA --}}
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->getRoleNames()[0] == 'Administrator' || Auth::user()->getRoleNames()[0] == 'Kapala Sekolah')
                <li class="nav-header">MASTER DATA</li>
                @endif

                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Siswa']))
                <li class="nav-item">
                    <a href="{{ route('siswa.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Siswa </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Angkatan']))
                <li class="nav-item">
                    <a href="{{ route('angkatan.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Angkatan </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Jurusan']))
                <li class="nav-item">
                    <a href="{{ route('jurusan.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Jurusan </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Kelas']))
                <li class="nav-item">
                    <a href="{{ route('kelas.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Kelas </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Pemasukan Bos']))
                <li class="nav-item">
                    <a href="{{ route('pemasukan-bos.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Pemasukan Bos </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Gol Pengeluaran']))
                <li class="nav-item">
                    <a href="{{ route('golongan-rkas.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Gol Pengaluaran (RKAS) </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->getRoleNames()[0] == 'Administrator' || Auth::user()->getRoleNames()[0] == 'Kapala Sekolah')
                <li class="nav-header">TRANSAKSI</li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Pembayaran DSP']))
                <li class="nav-item">
                    <a href="{{ route('dsp.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Pembayaran DSP </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Pembayaran SPP']))
                <li class="nav-item">
                    <a href="{{ route('spp.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Pembayaran SPP </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Pengeluaran SPP DSP']))
                <li class="nav-item">
                    <a href="{{ route('pengeluaran-spp-dsp.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> Pengeluaran SPP / DSP </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['RKAS']))
                <li class="nav-item">
                    <a href="{{ route('rkas.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p> RKAS </p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->getRoleNames()[0] == 'Administrator' || Auth::user()->getRoleNames()[0] == 'Kapala Sekolah')
                <li class="nav-header">MANAGEMANT USER</li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['User']))
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p class="text">User</p>
                    </a>
                </li>
                @endif
                @if( Auth::user()->getRoleNames()[0] == 'Developer' || Auth::user()->hasAnyPermission(['Golongan User']))
                <li class="nav-item">
                    <a href="{{ route('role.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Golongan User</p>
                    </a>
                </li>
                @endif
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
