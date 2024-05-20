<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('img/logo3.svg') }}">
    <title>BEST - Login</title>
    {{-- Custom styles for this template --}}
        <link href="{{ asset('css/signin.css') }}" rel="stylesheet">

    {{-- Bootstrap link --}}
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />

    {{-- Select2 link --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Lokal css --}}
        <style>
            * {
                font-family: 'Nunito', sans-serif;
                color: #858796;
            }
            .form-control {
                color: #858796;
            }
            .form-control::-webkit-input-placeholder{
                color: #CCCDD4;
            }
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
                }
            }

            body {
                background-image: url({{ asset('img/bg.png') }});
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
            }

            .login-box .user-box {
                position:relative;
            }

            .login-box .user-box input{
                width:100%;
                padding:10px 0;
                font-size: 16px;
                color: #858796;
                margin-bottom: 30px;
                border:none;
                border-bottom:1px solid #3d3d3d;
                outline:none;
                background: transparent;
            }
            .login-box .user-box label{
                position:absolute;
                top:0;
                left:0;
                padding:10px 0;
                font-size: 16px;
                color:black;
                pointer-events:none;
                transition:.5s;
            }
            .login-box .user-box input:focus ~ label,
            .login-box .user-box input:valid ~ label{
                top:-20px;
                left:0;
                font-size: 12px;
            }
        </style>
</head>

<body class="row p-0 m-0">
    <div class="col-md-6 text-center mb-3">
        <img src="{{ asset('img/logo4.png') }}" alt="" width="500px">
    </div>
    <div class="col-md-6 mb-3 login-box">
        <form class="form-signin bg-white px-5 py-4 text-center" method="post" action="">
            <img class="mb-4" src="{{ asset('img/logo.png') }}" alt="" width="200" />
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $item)
                        <span class="mb-0">{{ $item }}</span>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @csrf
            <div class="user-box">
                <input type="text" name="username" autofocus>
                <label style="color: #858796;"><i class="fa-solid fa-user"></i> Username</label>
            </div>
    
            <div class="user-box">
                <input type="password" name="password">
                <label style="color: #858796;"><i class="fa-solid fa-lock"></i> Password</label>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" >Masuk</button>
        </form>
    </div>

    {{-- Ajax Script --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    
    {{-- Js script --}}
        <script src="{{ asset('js/jquery.min.js') }}"></script>

    {{-- Bootstrap script --}}
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

   {{-- Font awesome script --}}
        <script src="https://kit.fontawesome.com/88e6f231cb.js" crossorigin="anonymous"></script>

    {{-- Select2 script --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>