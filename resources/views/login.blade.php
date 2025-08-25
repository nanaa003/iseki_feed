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

<body id="page-top" style="background-color: #FFEAEA;">
    <!-- Navigation-->
    <!-- Contact-->
    <section class="page-section" id="contact">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="mt-0">Login</h2>
                    <hr class="divider" />
                    <p class="text-muted mb-5">Let's get started!</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-lg-6">
                    <form method="POST" action="{{ route('login_process') }}">
                        @csrf
                        <!-- Username input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="username" name="Username_User" type="text"
                                placeholder="Enter your username..." required />
                            <label for="username">Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name="Password_User" type="password"
                                placeholder="Enter your password..." required />
                            <label for="password">Password</label>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-xl" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">Copyright &copy; 2025 - Company Name</div>
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

    @yield('script')
</body>

</html>
