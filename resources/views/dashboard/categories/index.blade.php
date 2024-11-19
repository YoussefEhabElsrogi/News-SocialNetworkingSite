@extends('layouts.dashboard.app')

@section('title')
    Categories
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-2 text-gray-800">Categories</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-category">
                Create Category
            </button>
        </div>

        <p class="mb-4">You can manage your categories from this page. If you want to add a new category, click <a
                href="javascript:void(0);" data-toggle="modal" data-target="#add-category">here</a>.</p>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Categories Management</h6>
            </div>

            @include('dashboard.categories.filter.filter')
            {{-- table data --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posts Count</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Posts Count</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->status == 1 ? 'Active' : 'Not Active' }}</td>
                                    <td>{{ $category->posts_count }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="if(confirm('Do you want to delete the category')){document.getElementById('delete_category_{{ $category->id }}').submit()} return false"><i
                                                class="fa fa-trash"></i></a>
                                        <a href="{{ route('dashboard.categories.changeStatus', $category->id) }}"><i
                                                class="fa @if ($category->status == 1) fa-stop @else fa-play @endif"></i></a>
                                        <a href="javascript:void(0)"><i class="fa fa-edit" data-toggle="modal"
                                                data-target="#edit-category-{{ $category->id }}"></i></a>
                                    </td>
                                </tr>

                                <form id="delete_category_{{ $category->id }}"
                                    action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                {{-- edit Category modal --}}
                                @include('dashboard.categories.edit')
                                {{-- end edit category modal --}}
                            @empty
                                <tr>
                                    <td class="alert alert-info" colspan="6"> No categories</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $categories->appends(request()->input())->links() }}
                </div>

            </div>
        </div>

        {{-- modal add new category --}}
        @include('dashboard.categories.create')
    </div>
    <!-- /.container-fluid -->
@endsection
