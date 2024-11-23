@extends('layouts.dashboard.app')

@section('title', 'Roles')

@push('css')
    <style>
        /* Card Section */
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Table Style */
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            vertical-align: middle;
        }

        .table th {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Button Style */
        .btn-info {
            background-color: #17a2b8;
            border: none;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .btn-icon {
            font-size: 18px;
            padding: 10px;
            cursor: pointer;
            color: #6c757d;
            transition: color 0.3s;
        }

        .btn-icon:hover {
            color: #007bff;
        }

        /* Alert Style */
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            font-weight: bold;
        }

        /* Pagination Style */
        .pagination {
            margin-top: 20px;
            justify-content: center;
        }

        .pagination .page-item .page-link {
            color: #495057;
            padding: 8px 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
            color: white;
        }

        /* Hover effect for delete/edit links */
        .fa-edit:hover,
        .fa-trash:hover {
            color: #007bff;
        }
    </style>
@endpush

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Roles Management</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Roles Management</h6>
            </div>
            <div class="col-3 mt-3 mb-3">
                <a href="{{ route('dashboard.authorizations.create') }}" class="btn btn-info">Create New Role</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Related Admins</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Related Admins</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($authorizations as $authorization)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $authorization->role }}</td>
                                    <td>
                                        @foreach ($authorization->permessions as $permession)
                                            {{ $permession }}{{ !$loop->last ? ',' : '' }}
                                        @endforeach
                                    </td>
                                    <td>{{ $authorization->admins->count() }}</td>
                                    <td>{{ $authorization->created_at->format('Y-m-d h:i A') }}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="if(confirm('Do you want to delete this Role?')){document.getElementById('delete_role_{{ $authorization->id }}').submit()}">
                                            <i class="fa fa-trash btn-icon"></i>
                                        </a>
                                        <a href="{{ route('dashboard.authorizations.edit', $authorization->id) }}">
                                            <i class="fa fa-edit btn-icon"></i>
                                        </a>
                                    </td>
                                </tr>

                                <form id="delete_role_{{ $authorization->id }}"
                                    action="{{ route('dashboard.authorizations.destroy', $authorization->id) }}"
                                    method="post" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="5">No Authorizations Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $authorizations->appends(request()->input())->links() }}
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
