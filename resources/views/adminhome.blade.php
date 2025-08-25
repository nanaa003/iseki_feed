@extends('layouts.admin')
@section('content')
    <!-- Masthead / Carousel -->
    <header class="masthead" style="background-color:#fff0f5; padding-top:70px; padding-bottom:50px;">
        <!-- soft pink pastel -->
        <!-- Carousel Gambar -->
        <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

            <div class="carousel-inner" style="height:450px;">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img src="{{ asset('assets/img/bg3.jpg') }}" class="d-block w-100 h-100" style="object-fit:cover;"
                        alt="Slide 1">
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/bg2.jpg') }}" class="d-block w-100 h-100" style="object-fit:cover;"
                        alt="Slide 2">
                </div>
                <!-- Slide 3 -->
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/bg5.jpg') }}" class="d-block w-100 h-100" style="object-fit:cover;"
                        alt="Slide 3">
                </div>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2"></button>
            </div>
        </div>

        <!-- Teks + Button di bawah carousel -->
        <div class="container text-center mt-4">
            <h1 class="font-weight-bold mb-3" style="color: #f4f9ff;">Welcome to ISEKI</h1> <br>
            <a class="btn btn-primary btn-xl" href="#services">Lihat Produk</a>
        </div>
    </header>

    <!-- Presented / Videos Section -->
    <section class="page-section" id="services" style="background-color:#fff0f5; padding-top:150px; padding-bottom:80px;">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0 mb-4">Presented</h2>
            <hr class="divider mb-5" />

            @forelse ($videos as $videoPath)
                <div class="d-flex justify-content-center mb-5">
                    <div class="w-100" style="max-width: 1000px;">
                        <div class="card shadow-lg rounded-lg overflow-hidden">
                            <div class="ratio ratio-16x9">
                                <video class="w-100 h-100" controls poster="{{ asset('images/placeholder.jpg') }}">
                                    <source src="{{ asset($videoPath) }}" type="video/mp4">
                                    Browser tidak mendukung video.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada video untuk ditampilkan.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
