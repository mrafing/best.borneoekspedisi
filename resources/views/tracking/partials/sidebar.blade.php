<!-- SIDEBAR -->
<ul class="navbar-nav sidebar accordion" id="accordionSidebar" style="background-color: #DEDEDE;">
    <!-- SIDEBAR BRAND -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ URL::to('dashboard/mainmenu') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/logo2.png') }}" width="100">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
    </a>
    <!-- END SIDEBAR BRAND -->

    <hr class="sidebar-divider my-0" />
    <div class="sidebar-heading p-0">
        <ul class="pl-0 bullet-none">
            <li class="costume-bullet">
                <p class="mb-0 mt-3 text-dark" style="font-size: 15px;"><b>LACAK PAKET</b></p>
            </li>
        </ul>
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link text-dark" href="{{ URL::to('dashboard/mainmenu') }}">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span>Main Menu</span>
        </a>
    </li>

    <div class="text-center mt-5">
        {{-- <a class="btn-primary rounded-circle border-0 p-3" href=""><i class="fa-solid fa-chevron-left"></i></a> --}}
        <button id="sidebarToggleTop" class="btn-primary rounded-circle border-0 px-4 py-3">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>
</ul>
<!-- END SIDE BAR -->