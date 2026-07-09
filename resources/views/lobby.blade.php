<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISEKI Lobby Auto-Play</title>
    <!-- Google Fonts for the button -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body, html { 
            margin: 0; 
            padding: 0; 
            width: 100%; 
            height: 100%; 
            background: #000; 
            overflow: hidden; 
            font-family: 'Inter', sans-serif;
        }
        
        #lobbyVideo { 
            width: 100vw; 
            height: 100vh; 
            object-fit: cover; /* Memastikan video memenuhi layar TV */
            transition: opacity 0.5s ease;
        }

        /* Overlay Kontrol yang hanya muncul saat kursor bergerak (hover) */
        #controls-overlay { 
            position: absolute; 
            bottom: 30px; 
            right: 30px; 
            z-index: 10; 
            opacity: 0; 
            transition: opacity 0.5s ease; 
            display: flex;
            gap: 15px;
        }
        body:hover #controls-overlay { 
            opacity: 1; 
        }

        .btn-lobby { 
            background: rgba(0, 0, 0, 0.4); 
            color: white; 
            border: 1px solid rgba(255,255,255,0.3); 
            padding: 12px 24px; 
            border-radius: 50px; 
            text-decoration: none; 
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer; 
            backdrop-filter: blur(8px); 
            transition: all 0.3s ease;
        }
        .btn-lobby:hover { 
            background: rgba(255, 255, 255, 0.15); 
            border-color: rgba(255,255,255,0.6);
        }
        
        .empty-state {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>

    @if(count($videos) > 0)
        <video id="lobbyVideo" autoplay muted></video>
        
        <div id="controls-overlay">
            <button onclick="toggleMute()" id="muteBtn" class="btn-lobby">Unmute Suara</button>
            <a href="{{ route('home') }}" class="btn-lobby">Kembali ke Dashboard</a>
        </div>

        <script>
            // Data playlist dari controller
            const playlist = @json($videos);
            const videoElement = document.getElementById('lobbyVideo');
            const muteBtn = document.getElementById('muteBtn');
            let currentIndex = 0;

            function playNext() {
                if (playlist.length === 0) return;
                
                // Efek fade out singkat
                videoElement.style.opacity = 0;

                setTimeout(() => {
                    // Loop kembali ke awal jika sudah di akhir playlist
                    if (currentIndex >= playlist.length) {
                        currentIndex = 0;
                    }

                    // Set sumber video baru
                    videoElement.src = "{{ asset('storage') }}/" + playlist[currentIndex];
                    
                    // Mainkan video
                    videoElement.play().then(() => {
                        videoElement.style.opacity = 1;
                    }).catch(e => {
                        console.log("Auto-play dicegah oleh browser. Membutuhkan interaksi user.", e);
                    });
                    
                    currentIndex++;
                }, 300); // jeda transisi
            }

            function toggleMute() {
                if (videoElement.muted) {
                    videoElement.muted = false;
                    muteBtn.innerHTML = "Mute Suara";
                } else {
                    videoElement.muted = true;
                    muteBtn.innerHTML = "Unmute Suara";
                }
            }

            // Dengarkan event video selesai diputar, lalu lanjut ke video berikutnya
            videoElement.addEventListener('ended', playNext);
            
            // Jika ada error pada satu video (misal corrupt), langsung skip ke video berikutnya
            videoElement.addEventListener('error', playNext);

            // Mulai memutar video pertama
            playNext();
        </script>
    @else
        <div class="empty-state">
            <h2>Belum ada video di playlist</h2>
            <p>Silakan upload video melalui Admin Control Panel</p>
            <a href="{{ route('home') }}" class="btn-lobby" style="margin-top:20px; display:inline-block;">Kembali</a>
        </div>
    @endif

</body>
</html>
