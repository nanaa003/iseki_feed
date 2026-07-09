@extends('layouts.admin')
@section('content')

{{-- ===================== HERO / CAROUSEL ===================== --}}
<header class="masthead" style="background-color:#FCF8F8; padding-top:76px; padding-bottom:15px;">
    <div id="adminCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
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

        <button class="carousel-control-prev" type="button" data-bs-target="#adminCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#adminCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#adminCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#adminCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#adminCarousel" data-bs-slide-to="2"></button>
        </div>
    </div>

    <div class="container text-center mt-3">
        <h3 class="display-4 fw-bold" style="font-family:'Playfair Display',serif;color:#4A2E2E;">Dashboard Admin</h3>
        <p class="lead mb-4" style="color:#8B6F6F !important;max-width:600px;margin:0 auto 1.5rem;">
            Kelola presentasi layar lobby TV, prosedur operasional, dan hak akses pengguna
        </p>
    </div>
</header>

{{-- ===================== QUICK ACCESS CARDS ===================== --}}
<section style="background-color:#FBEFEF;padding:3rem 0;">
    <div class="container px-4 px-lg-5">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('upload') }}" class="text-decoration-none">
                    <div class="admin-card text-center p-5">
                        <div class="icon-wrap mb-4 mx-auto">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                        </div>
                        <h4 class="card-title">Upload Video</h4>
                        <p class="card-text">Kelola presentasi video utama</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('procedure') }}" class="text-decoration-none">
                    <div class="admin-card text-center p-5">
                        <div class="icon-wrap mb-4 mx-auto">
                            <i class="bi bi-tools"></i>
                        </div>
                        <h4 class="card-title">Prosedur Standard</h4>
                        <p class="card-text">Atur spesifikasi & prosedur mesin</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('user') }}" class="text-decoration-none">
                    <div class="admin-card text-center p-5">
                        <div class="icon-wrap mb-4 mx-auto">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4 class="card-title">Manajemen User</h4>
                        <p class="card-text">Kelola hak akses operator</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===================== VIDEOS ===================== --}}
<section style="background-color:#FCF8F8;padding:4rem 0 5rem;">
    <div class="container px-4 px-lg-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <span class="badge px-3 py-2 rounded-pill mb-2 d-inline-block"
                      style="background:#F9DFDF;color:#8B6F6F;font-size:0.75rem;letter-spacing:2px;font-weight:600;">
                    ✦ PRESENTED
                </span>
                <h2 class="fw-bold mb-0" style="font-family:'Playfair Display',serif;color:#4A2E2E;font-size:2rem;">
                    Video Aktif
                </h2>
            </div>
            <a href="{{ route('upload') }}" class="btn btn-outline-secondary rounded-pill px-4"
               style="border-color:#C47A7A;color:#C47A7A;font-weight:600;">
                Kelola Video
            </a>
        </div>

        <div class="row justify-content-center g-4">
            @forelse ($videos as $index => $videoPath)
            <div class="col-12 col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background:#FFF;">
                    <div class="ratio ratio-16x9">
                        <video controls poster="{{ asset('images/placeholder.svg') }}">
                            <source src="{{ asset('storage/' . $videoPath) }}" type="video/mp4">
                            Browser tidak mendukung video.
                        </video>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-camera-video-off" style="font-size:3rem;color:#F9DFDF;"></i>
                <p class="text-muted mt-3" style="color:#8B6F6F !important;">Tidak ada video yang ditampilkan saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection

@section('style')
<style>
.admin-card {
    background: #fffbfb;
    border-radius: 24px;
    box-shadow: 0 12px 40px rgba(196,122,122,0.12), 0 4px 12px rgba(196,122,122,0.06);
    border: 1px solid rgba(245,175,175,0.25);
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.admin-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(196,122,122,0.2), 0 8px 24px rgba(196,122,122,0.1);
}
.icon-wrap {
    width: 76px; height: 76px;
    background: linear-gradient(135deg, #FBEFEF, #F9DFDF);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem;
    color: #d19fa0;
    box-shadow: inset 0 2px 6px rgba(255,255,255,0.9), 0 8px 20px rgba(209,159,160,0.2);
    transition: transform 0.3s ease, color 0.3s ease;
}
.admin-card:hover .icon-wrap {
    transform: scale(1.08) translateY(-4px);
    color: #b58081;
}
.card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: #5a3e3e;
    margin-bottom: 0.5rem;
}
.card-text {
    font-size: 0.9rem;
    color: #8a7676;
    margin-bottom: 0;
}
</style>
@endsection
