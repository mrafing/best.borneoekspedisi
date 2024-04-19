<nav class="navbar navbar-expand navbar-dark bg-primary topbar mb-0 static-top border-bottom p-0">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="nav-link bg-white">
                    <img src="{{ asset('img/logo.png') }}" width="200px"/>
                </a>
            </li>
        </ul>
        
        {{-- Top bar search --}}
        <div class="navbar-nav ml-auto">
            <form action="" method="post" class="d-none d-lg-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search pt-3">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="CEK POSISI PAKET" name="no_resi" aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                    <button class="btn bg-white" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                    </div>
                </div>
            </form>
            <div class="nav-item dropdown-togle ml-3">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="mr-3 img-profile rounded-circle" style="width: 32px;" src="{{ asset('img/undraw_profile.svg') }}"/>
                    <span class="mt-1 mr-2">
                        <p class="mb-0" style="line-height: 10px;"><small>{{ strtoupper(Auth::user()->outlet->nama_agen) }}</small></p>
                        <p class="mb-0"><small>{{ Auth::user()->username }}</small></p>
                    </span>
                </a>
                {{-- Dropdown - User --}}
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in p-2" aria-labelledby="userDropdown">
                <a class="dropdown-item p-2" href="">
                    <i class="fa-solid fa-headset fa-fw mr-2 text-gray-400"></i>
                    Informasi Akun
                </a>
                <a href="#" class="dropdown-item p-2" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar
                </a>
                </div>
            </div>
        </div>
    </div>
</nav>