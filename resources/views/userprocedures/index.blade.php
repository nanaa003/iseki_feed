@extends('layouts.index')
@section('content')

    <style>
        /* Background soft pink untuk section video */
        #uploads {
            background-color: #fff0f5;
            /* pink sangat soft */
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

        #uploads .card-img-top {
            width: 100%;
            /* lebar penuh card */
            height: 200px;
            /* tinggi seragam, bisa disesuaikan */
            object-fit: cover;
            /* supaya gambar memenuhi area dan tetap proporsional */
            border-top-left-radius: 12px;
            /* agar radius card tetap sama */
            border-top-right-radius: 12px;
        }

        #uploads .card-img-top {
            width: 100%;
            height: 200px;
            /* tinggi seragam */
            object-fit: contain;
            /* gambar tidak terpotong */
            background-color: #f0f0f0;
            /* optional, biar ada latar saat ada padding */
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
    </style>

    <section class="page-section" id="uploads">
        <div class="container px-4 px-lg-5 pt-5">
            <h2 class="text-center mt-0">Procedure</h2>
            <hr class="divider" />
        </div>

        <section class="pt-3 pb-4" id="count-stats">
            <div class="container">
                @if ($errors->any())
                    <div class="row">
                        @foreach ($errors->all() as $error)
                            <div class="col-12 col-lg-6">
                                <div class="alert alert-danger text-white text-xs alert-dismissible fade show"
                                    role="alert">
                                    {{ $error }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Tombol Add -->

                <div class="row">
                    @foreach ($tractors as $t)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset($t->Photo_Tractor ?? 'assets/img/default-tractor.png') }}"
                                    class="card-img-top" alt="{{ $t->Name_Tractor }}">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title text-center">
                                        <a href="{{ route('userprocedure.area.index', ['Name_Tractor' => $t->Name_Tractor]) }}"
                                            class="text-primary">
                                            {{ $t->Name_Tractor }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        </div>

        <!-- Modal Add -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('userprocedure.tractor.create') }}" role="form" method="POST">
                        @csrf
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white" id="addModalLabel">Add Tractor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Name Tractor</label>
                                <input type="text" class="form-control" name="Name_Tractor" value="" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-primary w-100 my-2">Submit</button>
                            <button type="button" class="btn bg-gradient-secondary w-100 my-2 mb-2"
                                data-bs-dismiss="modal">Cancel</button>
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
                            <h5 class="modal-title text-white" id="editUserModalLabel">Edit Tractor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Name Tractor</label>
                                <input type="text" class="form-control" name="Name_Tractor" id="edit-name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-primary w-100 my-2">Update</button>
                            <button type="button" class="btn bg-gradient-secondary w-100 my-2 mb-2"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

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
                form.action = '/iseki_aspro/public/procedure/tractor/update/' + data.Id_Tractor; // Sesuaikan route-mu

                // Isi data
                document.getElementById('edit-name').value = data.Name_Tractor;

                // Tambahkan class is-filled agar label naik
                document.querySelectorAll('#editModal .input-group').forEach(group => {
                    group.classList.add('is-filled');
                });
            }

            function setDelete(data) {
                // Set nama ke <b>
                document.getElementById('delete-name').textContent = data.Name_Tractor;

                // Set action form
                const form = document.getElementById('deleteForm');
                form.action =
                    `/iseki_aspro/public/procedure/tractor/delete/${data.Id_Tractor}`; // Sesuaikan dengan rute sebenarnya jika beda
            }
        </script>
    @endsection

</section>
<div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6">
