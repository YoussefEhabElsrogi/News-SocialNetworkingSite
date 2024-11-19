@extends('layouts.dashboard.app')

@section('title', 'Users')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Users</h1>
        <p class="mb-4">You can manage your categories from this page. If you want to add a new category, click <a
                href="{{ route('dashboard.users.create') }}">here</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Users Table</h6>
            </div>

            @include('dashboard.users.filter.filter')

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Country</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->status == 1 ? 'Active' : 'Not Active' }}</td>
                                    <td>{{ $user->country ?? 'N/A' }}</td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="if(confirm('Do you want to delete the user')){document.getElementById('delete_user_{{ $user->id }}').submit()} return false"><i
                                                class="fa fa-trash"></i></a>
                                        <a href="{{ route('dashboard.users.changeStatus', $user->id) }}"><i
                                                class="fa @if ($user->status == 1) fa-stop @else fa-play @endif"></i></a>
                                        <a href="{{ route('dashboard.users.show', $user->id) }}"><i
                                                class="fa fa-eye"></i></a>
                                        <form id="delete_user_{{ $user->id }}"
                                            action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Country</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
