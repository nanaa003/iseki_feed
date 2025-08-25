@extends('layouts.admin')
@section('content')
<style>
    /* Background soft pink untuk section */
    #uploads {
        background-color: #fff0f5;
        padding: 60px 0;
    }

    /* Card */
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
        <h2 class="text-center mt-0">Daftar User</h2>
        <hr class="divider" />

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <b>+</b> Add User
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover datatable mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:35%">Name</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->Name_User }}</td>
                                    <td>{{ $user->Username_User }}</td>
                                    <td>{{ $user->Password_User }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#editUserModal" 
                                            data-id="{{ $user->Id_User }}"
                                            data-username="{{ $user->Username_User }}"
                                            data-name="{{ $user->Name_User }}"
                                            data-password="{{ $user->Password_User }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('user.destroy', $user->Id_User) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Add User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Username_User" class="form-label">Username</label>
                        <input type="text" class="form-control" id="Username_User" name="Username_User" required>
                    </div>
                    <div class="mb-3">
                        <label for="Name_User" class="form-label">Name</label>
                        <input type="text" class="form-control" id="Name_User" name="Name_User" required>
                    </div>
                    <div class="mb-3">
                        <label for="Password_User" class="form-label">Password</label>
                        <input type="text" class="form-control" id="Password_User" name="Password_User" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="Username_User" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_name_user" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name_user" name="Name_User" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="edit_password" name="Password_User">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk modal edit -->
<script>
    var editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var username = button.getAttribute('data-username');
        var name = button.getAttribute('data-name');
        var password = button.getAttribute('data-password');

        var form = document.getElementById('editUserForm');
        form.action = "{{ route('user.update', ':id') }}".replace(':id', id);

        document.getElementById('edit_username').value = username;
        document.getElementById('edit_name_user').value = name;
        document.getElementById('edit_password').value = password;
    });
</script>
@endsection
