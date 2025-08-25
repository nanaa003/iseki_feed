@extends('layouts.admin')
@section('content')
<style>
    /* Background soft pink untuk section video */
    #uploads {
        background-color: #fff0f5; /* pink sangat soft */
        padding: 60px 0;
    }

    /* Card di atas background pink tetap terlihat */
    #uploads .card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    /* Tabel header */
    #uploads .table-primary th {
        background-color: #ffd6e0;
        color: #000;
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
                    <table class="table table-bordered table-hover datatable mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:35%">Video</th>
                                <th>Keterangan</th>
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($uploads as $index => $upload)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
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

<!-- Script untuk modal edit -->
<script>
    var editUploadModal = document.getElementById('editUploadModal');
    editUploadModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var video = button.getAttribute('data-video');
        var name = button.getAttribute('data-name');

        var form = document.getElementById('editUploadForm');
        form.action = "{{ route('uploads.update', ':id') }}".replace(':id', id); // action sesuai route PUT /uploads/{id}/update

        document.getElementById('editDesc').value = name;

        var videoSrc = document.getElementById('currentVideoSrc');
        videoSrc.src = "{{ asset('storage') }}/" + video;
        document.getElementById('currentVideo').load();
    });
</script>
@endsection
