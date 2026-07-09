@extends('layouts.admin')
@section('content')
<style>
    #uploads {
        background-color: #FBEFEF;
        padding: 100px 0;
    }

    #uploads .card {
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(196,122,122,0.1);
        border: none;
    }

    #uploads .table-primary th {
        background-color: #C47A7A;
        color: #fff;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .table-bordered td, .table-bordered th {
        border-color: #F9DFDF;
    }
</style>

<section class="page-section" id="uploads">
    <div class="container px-4 px-lg-5 pt-5">
        <h2 class="text-center mt-0">Daftar Video</h2>
        <hr class="divider" />

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVideoModal">
                <b>+</b> Add Video
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0" id="playlistTable">
                        <thead class="table-primary text-center">
                            <tr>
                                <th style="width:10%">Urutan</th>
                                <th style="width:35%">Video</th>
                                <th>Keterangan</th>
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-list">
                            @forelse($uploads as $index => $upload)
                                <tr data-id="{{ $upload->Id_Upload }}" class="align-middle">
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            <button type="button" class="btn btn-sm btn-light border" onclick="moveRow(this, -1)" title="Naikkan"><i class="bi bi-chevron-up"></i></button>
                                            <span class="badge bg-soft-pink text-pink order-label">{{ $index + 1 }}</span>
                                            <button type="button" class="btn btn-sm btn-light border" onclick="moveRow(this, 1)" title="Turunkan"><i class="bi bi-chevron-down"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <video width="250" controls class="rounded">
                                            <source src="{{ asset('storage/' . $upload->Video_Path_Upload) }}" type="video/mp4">
                                            Your browser does not support HTML video.
                                        </video>
                                    </td>
                                    <td>{{ $upload->Desc_Upload }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#editUploadModal"
                                            data-id="{{ $upload->Id_Upload }}"
                                            data-video="{{ $upload->Video_Path_Upload }}"
                                            data-name="{{ $upload->Desc_Upload }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('uploads.destroy', $upload->Id_Upload) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada video.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Add Video -->
<div class="modal fade" id="addVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Video</label>
                        <input type="file" name="video" class="form-control" accept="video/*" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <input type="text" name="desc" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Video -->
<div class="modal fade" id="editUploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editUploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Video Saat Ini</label>
                        <div id="currentVideoContainer" class="mb-2">
                            <video id="currentVideo" width="250" controls class="rounded">
                                <source id="currentVideoSrc" src="" type="video/mp4">
                                Your browser does not support HTML video.
                            </video>
                        </div>
                        <label>Ganti Video (opsional)</label>
                        <input type="file" name="video" class="form-control" accept="video/*">
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <input type="text" name="desc" id="editDesc" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Video</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function moveRow(btn, direction) {
        const row = btn.closest('tr');
        const tbody = row.parentNode;
        
        if (direction === -1 && row.previousElementSibling) {
            tbody.insertBefore(row, row.previousElementSibling);
        } else if (direction === 1 && row.nextElementSibling) {
            tbody.insertBefore(row.nextElementSibling, row);
        } else {
            return; // Nothing to move
        }
        
        updateOrderLabels();
        saveOrder();
    }

    function updateOrderLabels() {
        const rows = document.querySelectorAll('#sortable-list tr');
        rows.forEach((row, index) => {
            const label = row.querySelector('.order-label');
            if (label) label.textContent = index + 1;
        });
    }

    function saveOrder() {
        const rows = document.querySelectorAll('#sortable-list tr');
        const orderData = [];
        rows.forEach((row, index) => {
            const id = row.getAttribute('data-id');
            if (id) {
                orderData.push({ id: id, order: index + 1 });
            }
        });

        fetch("{{ route('uploads.reorder') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ order: orderData })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Urutan tersimpan');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    document.getElementById('editUploadModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var videoPath = button.getAttribute('data-video');

        var form = document.getElementById('editUploadForm');
        form.action = '/uploads/' + id;
        document.getElementById('editDesc').value = name;

        var currentVideoSrc = document.getElementById('currentVideoSrc');
        var currentVideo = document.getElementById('currentVideo');
        
        if (videoPath) {
            currentVideoSrc.src = "{{ asset('storage/') }}/" + videoPath;
            currentVideo.load();
            document.getElementById('currentVideoContainer').style.display = 'block';
        } else {
            document.getElementById('currentVideoContainer').style.display = 'none';
        }
    });
</script>
@endsection
