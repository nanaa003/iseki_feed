@extends('layouts.index')
@section('content')

{{-- ===================== HERO / CAROUSEL ===================== --}}
<header class="masthead" style="background-color:#FCF8F8; padding-top:76px; padding-bottom:15px;">
    <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner" style="height:450px;">
            <div class="carousel-item active">
                <img src="{{ asset('assets/img/bg3.jpg') }}"
                    class="d-block w-100 h-100"
                    style="object-fit:cover;object-position:center top;"
                    alt="ISEKI 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/img/bg2.jpg') }}"
                    class="d-block w-100 h-100"
                    style="object-fit:cover;object-position:center top;"
                    alt="ISEKI 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/img/bg5.jpg') }}"
                    class="d-block w-100 h-100"
                    style="object-fit:cover;object-position:center top;"
                    alt="ISEKI 3">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2"></button>
        </div>
    </div>

    <div class="container text-center mt-3">
        <h3 class="display-4 fw-bold" style="font-family:'Playfair Display',serif;color:#4A2E2E;">Welcome to ISEKI</h3>
        <p class="lead text-muted mb-4" style="color:#8B6F6F !important;max-width:600px;margin:0 auto 1.5rem;">
            Teknologi & inovasi pertanian modern terbaik di kelasnya
        </p>
        <a class="btn btn-primary btn-lg px-5 rounded-pill" href="#services">
            <i class="bi bi-play-circle-fill me-2"></i>Lihat Produk
        </a>
    </div>
</header>

{{-- ===================== VIDEOS ===================== --}}
<section class="page-section" id="services" style="background-color:#FBEFEF;padding:5rem 0 6rem;">
    <div class="container px-4 px-lg-5">
        <div class="text-center mb-5">
            <span class="badge bg-rose-subtle text-rose-dark px-3 py-2 rounded-pill mb-3 d-inline-block"
                style="background:#F9DFDF;color:#8B6F6F;font-size:0.75rem;letter-spacing:2px;font-weight:600;">
                ✦ PRESENTED
            </span>
            <h2 class="fw-bold" style="font-family:'Playfair Display',serif;color:#4A2E2E;font-size:2.2rem;">
                Featured Videos
            </h2>
        </div>

        <div class="row justify-content-center g-4">
            @forelse ($videos as $videoPath)
            <div class="col-12 col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background:#FFF;">
                    <div class="ratio ratio-16x9">
                        <video controls poster="{{ asset('images/placeholder.svg') }}">
                            <source src="{{ asset($videoPath) }}" type="video/mp4">
                            Browser tidak mendukung video.
                        </video>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-camera-video-off" style="font-size:3rem;color:#F9DFDF;"></i>
                <p class="text-muted mt-3">Belum ada video untuk ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection