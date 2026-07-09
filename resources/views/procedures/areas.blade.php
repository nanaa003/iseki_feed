@extends('layouts.admin')
@section('content')
    <div class="section-premium" style="padding-top: 90px; padding-bottom: 40px; background-color: #FBEFEF;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge-premium mb-3 d-inline-block">{{ $tractor }}</span>
                <h2 class="section-title">Area Management</h2>
                <p class="text-muted" style="color: #8B6F6F !important;">Kelola area untuk traktor {{ $tractor }}</p>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: -30px; margin-bottom: 60px;">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb breadcrumb-rose">
                <li class="breadcrumb-item"><a href="{{ route('procedure') }}" class="text-decoration-none" style="color: #C47A7A;">Procedure</a></li>
                <li class="breadcrumb-item active fw-semibold" style="color: #4A2E2E;">{{ $tractor }}</li>
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

            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Area
                </button>
            </div>

            <div class="table-responsive">
                <table id="example" class="table table-premium table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tractor</th>
                            <th class="text-center">Area</th>
                            <th class="text-center" style="width: 15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas as $a)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">{{ $a->Name_Tractor }}</td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('procedure.procedure.index', ['Name_Tractor' => $a->Name_Tractor, 'Name_Area' => $a->Name_Area]) }}"
                                        class="fw-semibold" style="color: #C47A7A; text-decoration: none;">
                                        {{ $a->Name_Area }}
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="#" class="btn btn-outline-primary btn-sm btn-icon-rounded" data-bs-toggle="modal"
                                            data-bs-target="#editModal" onclick="setEdit({{ $a }})" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger btn-sm btn-icon-rounded" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" onclick="setDelete({{ $a }})" title="Delete">
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
                <form action="{{ route('procedure.area.create') }}" role="form" method="POST">
                    @csrf
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="addModalLabel">Add Area</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group my-3">
                            <label class="form-label">Name Tractor</label>
                            <input type="text" class="form-control" name="Name_Tractor" value="{{ $tractor }}" readonly required>
                        </div>
                        <div class="form-group my-3">
                            <label class="form-label">Name Area</label>
                            <input type="text" class="form-control" name="Name_Area" value="" required>
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
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="editUserModalLabel">Edit Area</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group my-3">
                            <label class="form-label">Name Tractor</label>
                            <input type="text" class="form-control" name="Name_Tractor" value="" id="edit-tractor" readonly required>
                        </div>
                        <div class="form-group my-3">
                            <label class="form-label">Name Area</label>
                            <input type="text" class="form-control" name="Name_Area" value="" id="edit-area" required>
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

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title text-white" id="deleteUserModalLabel">Delete Area</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this area:</p>
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
@endsection

@section('style')
    <link href="{{ asset('assets/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <script>
        new DataTable('#example');
    </script>
    <script>
        function setEdit(data) {
            // Set form action
            const form = document.getElementById('editForm');
            form.action = 'http://192.168.173.201/iseki_feed/public/procedure/tractor/area/update/' + data.Id_Area; // Sesuaikan route-mu

            // Isi data
            document.getElementById('edit-tractor').value = data.Name_Tractor;
            document.getElementById('edit-area').value = data.Name_Area;

            // Tambahkan class is-filled agar label naik
            document.querySelectorAll('#editModal .input-group').forEach(group => {
                group.classList.add('is-filled');
            });
        }

        function setDelete(data) {
            // Set nama ke <b>
            document.getElementById('delete-name').textContent = data.Name_Area;

            // Set action form
            const form = document.getElementById('deleteForm');
            form.action = `http://192.168.173.201/iseki_feed/public/procedure/tractor/area/delete/${data.Id_Area}`; // Sesuaikan dengan rute sebenarnya jika beda
        }
    </script>
@endsection
