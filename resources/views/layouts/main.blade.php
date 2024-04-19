<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="">
        <title>BEST - {{ $title }}</title>
        {{-- Font family --}}
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        
        {{-- Bootstrab 4 SB Admin --}}
        <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" />

        {{-- Datatables link --}}
        {{-- <link href="{{ asset('css/DataTables-1.13.4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css" rel="stylesheet" /> --}}

        {{-- Select2 link --}}
        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

        {{-- My Style --}}
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        
    </head>

    <body id="page-top">
        {{-- Page wrapper --}}
        <div id="wrapper">
            @yield('container')
        </div>

        {{-- Scroll top --}}
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        {{-- Logout modal --}}
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin ingin Keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Keluar" di bawah jika anda siap untuk mengakhiri sesi.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <form action="{{ URL::to('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary" href="">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>

        {{-- Date range Picker --}}
        {{-- <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" /> --}}

        {{-- Bootstrap script --}}
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

        {{-- Core plugin JavaScript --}}
        <script src="{{ asset('js/jquery.easing.min.js') }}"></script>

        {{-- SB Admin script --}}
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

        {{-- Font Awesome script --}}
        <script src="https://kit.fontawesome.com/88e6f231cb.js" crossorigin="anonymous"></script>

        {{-- Datatables scripts --}}
        {{-- <script src="{{ asset('js/DataTables-1.13.4/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/DataTables-1.13.4/js/dataTables.bootstrap4.min.js') }}"></script> --}}

        {{-- Select2 Script --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @yield('script')
    </body>
</html>
