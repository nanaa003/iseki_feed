<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="ISEKI Feed TV - Menampilkan produk-produk ISEKI di lobby" />
    <meta name="author" content="ISEKI" />
    <title>ISEKI_FEED</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />

    <!-- Bootstrap Icons-->
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet" />

    <!-- Google Fonts-->
    {{-- <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
        rel="stylesheet" type="text/css" /> --}}

    <!-- SimpleLightbox CSS -->
    <link href={{ asset('assets/css/simpleLightbox.min.cs') }} rel="stylesheet" />

    <!-- Core Theme CSS (Bootstrap + custom) -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/icon.css') }}" />

</head>

<body id="page-top">

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">ISEKI_FEED</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('adminhome') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user') }}">User</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('upload') }}">Upload</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('procedure') }}">Procedure</a></li>

                    @if (!session()->has('login_id'))
                        <!-- Jika belum login, tampilkan tombol Login -->
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @else
                        <!-- Jika sudah login, tampilkan Logout dan bisa Dashboard/Admin -->
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-light py-5">
        <div class="text-center">
            <p class="text-dark my-4 text-sm font-weight-normal">
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>,
                <span class="text-primary">PT. Iseki Indonesia</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- SimpleLightbox JS -->
    <script src="{{ asset('assets/js/simpleLightbox.min.js') }}"></script>

    <!-- Core theme JS -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    <!-- SB Forms JS -->
    <script src="{{ asset('assets/js/sb-forms-latest.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @yield('script')

</body>

</html>
