<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="ISEKI Feed TV - Menampilkan produk-produk ISEKI di lobby" />
    <meta name="author" content="ISEKI" />
    <title>Innovation Feed</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/simpleLightbox.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/icon.css') }}" />

    <script src="/iseki_pro_app/js/dynamic-favicon.js"></script>
    <script>document.addEventListener("DOMContentLoaded", function() { setDynamicFavicon("photo_frame", "Innovation"); });</script>
</head>

<body id="page-top" class="page-fade-in">

    <nav class="navbar navbar-light bg-white shadow-sm navbar-expand-lg fixed-top py-3">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand fw-bold" href="#page-top" style="font-family:'Playfair Display',serif; color:#4A2E2E;">
                <span style="color: #C47A7A; font-size: 1.6rem; line-height: 0; margin-right: 6px;">✦</span> Innovation Feed
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('adminhome') }}" style="color:#4A2E2E;">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user') }}" style="color:#4A2E2E;">User</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('upload') }}" style="color:#4A2E2E;">Upload</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('procedure') }}" style="color:#4A2E2E;">Procedure</a></li>
                    @if (!session()->has('login_id'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}" style="color:#4A2E2E;">Login</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" style="color:#4A2E2E;">Logout</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-white border-top border-light py-4">
        <div class="container px-4 px-lg-5 text-center">
            <p class="mb-1 fs-5 fw-semibold" style="font-family: 'Playfair Display', serif; color:#4A2E2E;">ISEKI Innovation Feed</p>
            <p class="mb-0 small" style="color:#8B6F6F;">
                &copy; <script>document.write(new Date().getFullYear())</script> PT. Iseki Indonesia
            </p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/simpleLightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    @yield('script')

    {{-- Page transition animation --}}
    <style>
        body { animation: pageFadeIn 0.45s ease both; }
        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        document.querySelectorAll('a[href]').forEach(function(link) {
            if (link.hostname !== window.location.hostname) return;
            if (link.getAttribute('href').startsWith('#')) return;
            link.addEventListener('click', function(e) {
                var href = this.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript')) return;
                e.preventDefault();
                document.body.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                document.body.style.opacity = '0';
                document.body.style.transform = 'translateY(-10px)';
                setTimeout(function() { window.location.href = href; }, 300);
            });
        });
    </script>

</body>

</html>