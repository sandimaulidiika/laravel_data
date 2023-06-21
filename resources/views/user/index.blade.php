@extends('layout.main')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User</h1>
            <button onclick="window.location='{{ route('user.create') }}'"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fa-solid fa-plus text-white-50"></i> Tambah Data
            </button>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $key->name }}</td>
                                    <td>{{ $key->email }}</td>
                                    <td>
                                        <button class="btn btn-primary"
                                            onclick="window.location='{{ route('user.edit', ['id' => $key->id]) }}'">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $key->id }}">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal delete-->
    @foreach ($data as $key)
        <div class="modal fade" id="deleteModal{{ $key->id }}" tabindex="-1"
            aria-labelledby="deleteModal{{ $key->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('user.delete', ['id' => $key->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteModal{{ $key->id }}Label">Confirmation Delete Data
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Sure you want to delete the name data <b>{{ $key->name }}</b>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes, i am sure</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
