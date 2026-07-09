@extends('layouts.admin')
@section('content')
    <div class="section-premium" style="padding-top: 90px; padding-bottom: 40px; background-color: #FBEFEF;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge-premium mb-3 d-inline-block">{{ $tractor }} / {{ $area }}</span>
                <h2 class="section-title">Procedure Management</h2>
                <p class="text-muted" style="color: #8B6F6F !important;">Kelola prosedur untuk {{ $tractor }} - {{ $area }}</p>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: -30px; margin-bottom: 60px;">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb breadcrumb-rose">
                <li class="breadcrumb-item"><a href="{{ route('procedure') }}" class="text-decoration-none" style="color: #C47A7A;">Procedure</a></li>
                <li class="breadcrumb-item"><a href="{{ route('procedure.area.index', ['Name_Tractor' => $tractor]) }}" class="text-decoration-none" style="color: #C47A7A;">{{ $tractor }}</a></li>
                <li class="breadcrumb-item active fw-semibold" style="color: #4A2E2E;">{{ $area }}</li>
            </ol>
        </nav>

        <div class="card-premium bg-white p-4">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif

            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Procedure
                </button>
                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#itemModal" style="border-color: #C47A7A; color: #C47A7A;">
                    <i class="bi bi-list-check me-1"></i> Multiple Items
                </button>
            </div>

            <div class="table-responsive">
                <table id="example" class="table table-premium table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tractor</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">Procedure</th>
                            <th class="text-center">Video</th>
                            <th class="text-center" style="width: 18%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($procedures as $p)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">{{ $p->Name_Tractor }}</td>
                                <td class="text-center align-middle">{{ $p->Name_Area }}</td>
                                <td class="text-center align-middle">
                                    <a href="#" class="fw-semibold" style="color: #C47A7A; text-decoration: none;"
                                        onclick="previewPdf('{{ asset('storage/procedures/' . $p->Name_Tractor . '/' . $p->Name_Area . '/' . $p->Name_Procedure . '.pdf') }}', '{{ $p->Name_Procedure }}')">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>{{ $p->Name_Procedure }}
                                    </a>
                                </td>
                                <td class="text-center align-middle">
                                    @if ($p->Video_Path_Procedure)
                                        <a href="{{ asset('storage/' . $p->Video_Path_Procedure) }}" target="_blank"
                                            class="text-decoration-none" style="color: #C47A7A;">
                                            <i class="bi bi-play-circle me-1"></i>View
                                        </a>
                                    @else
                                        <span class="text-muted"><i class="bi bi-dash"></i></span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="#" class="btn btn-outline-primary btn-sm btn-icon-rounded" data-bs-toggle="modal"
                                            data-bs-target="#editModal" onclick="setEdit({{ $p }})" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-warning btn-sm btn-icon-rounded" data-bs-toggle="modal"
                                            data-bs-target="#uploadModal" onclick="setUpload({{ $p }})" title="Re-upload">
                                            <i class="bi bi-cloud-upload"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger btn-sm btn-icon-rounded" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" onclick="setDelete({{ $p }})" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('procedure.procedure.create') }}" role="form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="addModalLabel">Add Procedure</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Nama Tractor -->
                        <div class="form-group my-3">
                            <label class="form-label">Name Tractor</label>
                            <input type="text" class="form-control" name="Name_Tractor" value="{{ $tractor }}"
                                required readonly>
                        </div>
                        <!-- Nama Area -->
                        <div class="form-group my-3">
                            <label class="form-label">Name Area</label>
                            <input type="text" class="form-control" name="Name_Area" value="{{ $area }}"
                                required readonly>
                        </div>
                        <!-- Upload Procedure PDF -->
                        <div class="form-group my-3">
                            <label class="form-label">Upload Procedure (PDF)</label>
                            <input type="file" class="form-control" name="File_Procedure[]" accept="application/pdf"
                                multiple>
                        </div>
                        <!-- Upload Video Procedure -->
                        <div class="form-group my-3">
                            <label class="form-label">Upload Video (optional)</label>
                            <input type="file" class="form-control" name="Video_Procedure" accept="video/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="editUserModalLabel">Edit Procedure</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group my-3">
                            <label class="form-label">Name Tractor</label>
                            <input type="text" class="form-control" name="Name_Tractor" id="edit-tractor" required
                                readonly>
                        </div>
                        <div class="form-group my-3">
                            <label class="form-label">Name Area</label>
                            <input type="text" class="form-control" name="Name_Area" id="edit-area" required
                                readonly>
                        </div>
                        <div class="form-group my-3">
                            <label class="form-label">Name Procedure</label>
                            <input type="text" class="form-control" name="Name_Procedure" id="edit-procedure"
                                required>
                        </div>
                        <!-- Upload PDF -->
                        <div class="form-group my-3">
                            <label class="form-label">Upload Procedure (PDF)</label>
                            <input type="file" class="form-control" name="File_Procedure" accept="application/pdf">
                        </div>

                        <div class="form-group my-3">
                            <label class="form-label">Upload Video (optional)</label>
                            <input type="file" class="form-control" name="Video_Procedure" accept="video/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white" id="deleteUserModalLabel">Delete Procedure</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this procedure:</p>
                        <table>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td><b class="text-danger" id="delete-name"></b></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Upload -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="uploadForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="uploadUserModalLabel">Re-Upload Procedure</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group my-3">
                            <label class="form-label">Name Tractor</label>
                            <input type="text" class="form-control" name="Name_Tractor" id="upload-tractor" required
                                readonly>
                        </div>
                        <div class="form-group my-3">
                            <label class="form-label">Name Area</label>
                            <input type="text" class="form-control" name="Name_Area" id="upload-area" required
                                readonly>
                        </div>
                        <div class="form-group my-3">
                            <label class="form-label">Name Procedure</label>
                            <input type="text" class="form-control" name="Name_Procedure" id="upload-procedure"
                                required readonly>
                        </div>
                        <!-- Upload PDF -->
                        <div class="form-group my-3">
                            <label class="form-label">Upload Procedure (PDF)</label>
                            <input type="file" class="form-control" name="File_Procedure" accept="application/pdf">
                        </div>
                        <!-- Upload Video -->
                        <div class="form-group my-3">
                            <label class="form-label">Upload Video (video)</label>
                            <input type="file" class="form-control" name="Video_Procedure" accept="video/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview PDF -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="previewModalLabel">Preview Procedure <span
                            id="title"></span></h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdf-frame" src="" width="100%" height="600px" style="border:none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Item -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('procedure.procedure.item') }}" role="form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="addModalLabel">Add Multiple Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="Name_Tractor" value="{{ $tractor }}">
                        <input type="hidden" name="Name_Area" value="{{ $area }}">
                        <label class="form-label">Paste Procedure Items (support multiple row)</label>
                        <div class="input-group input-group-outline my-3 is-filled">
                            <label class="form-label">Item</label>
                            <textarea class="form-control" name="Item_Tractors" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link href="{{ asset('assets/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <script>
        // new DataTable('#example');
        $(document).ready(function() {
            var table;

            if ($.fn.DataTable.isDataTable('#example')) {
                table = $('#example').DataTable();
                table.page.len(100).draw(); // ✅ paksa default 100
            } else {
                table = $('#example').DataTable({
                    pageLength: 100,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ]
                });
            }
        });
    </script>
    <script>
        function setEdit(data) {
            // Set form action
            const form = document.getElementById('editForm');
            form.action = 'http://192.168.173.201/iseki_feed/public/procedure/tractor/area/procedure/update/' + data
                .Id_Procedure; // Sesuaikan route-mu

            // Isi data
            document.getElementById('edit-tractor').value = data.Name_Tractor;
            document.getElementById('edit-area').value = data.Name_Area;
            document.getElementById('edit-procedure').value = data.Name_Procedure;
            document.getElementById('edit-item').value = data.Item_Procedure;

            // Tambahkan class is-filled agar label naik
            document.querySelectorAll('#editModal .input-group').forEach(group => {
                group.classList.add('is-filled');
            });
        }

        function setDelete(data) {
            // Set nama ke <b>
            document.getElementById('delete-name').textContent = data.Name_Procedure;

            // Set action form
            const form = document.getElementById('deleteForm');
            form.action =
                `http://192.168.173.201/iseki_feed/public/procedure/tractor/area/procedure/delete/${data.Id_Procedure}`; // Sesuaikan dengan rute sebenarnya jika beda
        }

        function setUpload(data) {
            // Set form action
            const form = document.getElementById('uploadForm');
            form.action = 'http://192.168.173.201/iseki_feed/public/procedure/tractor/area/procedure/upload/' + data
                .Id_Procedure; // Sesuaikan route-mu

            // Isi data
            document.getElementById('upload-tractor').value = data.Name_Tractor;
            document.getElementById('upload-area').value = data.Name_Area;
            document.getElementById('upload-procedure').value = data.Name_Procedure;
            document.getElementById('upload-item').value = data.Item_Procedure;

            // Tambahkan class is-filled agar label naik
            document.querySelectorAll('#uploadModal .input-group').forEach(group => {
                group.classList.add('is-filled');
            });
        }
    </script>
    <script>
        function previewPdf(fileUrl, title) {
            document.getElementById('pdf-frame').src = fileUrl;
            document.getElementById('title').textContent = '( ' + title + ' )';

            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        }
    </script>
@endsection
