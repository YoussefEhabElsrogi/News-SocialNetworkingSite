@extends('layouts.dashboard.app')

@section('title', 'Related Sites Management')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-gray-800">Related Sites Management</h1>
            <button class="btn btn-primary" data-toggle="modal" data-target="#add-site">
                <i class="fas fa-plus"></i> Add Related Site
            </button>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Manage Related Sites</h6>
            </div>
            <div class="card-body">
                @if ($sites->isEmpty())
                    <div class="alert alert-info text-center">No Related Sites Found</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sites as $site)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $site->name }}</td>
                                        <td>
                                            <a href="{{ $site->url }}" target="_blank">{{ $site->url }}</a>
                                        </td>
                                        <td>
                                            <!-- Delete Button -->
                                            <button class="btn btn-sm btn-danger" onclick="deleteSite({{ $site->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#edit-site-{{ $site->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Delete Form -->
                                    <form id="delete_site_{{ $site->id }}"
                                        action="{{ route('dashboard.related-site.destroy', $site->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <!-- Edit Site Modal -->
                                    @include('dashboard.relatedsites.edit', ['site' => $site])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $sites->links() }}
                @endif
            </div>
        </div>

        <!-- Add Site Modal -->
        @include('dashboard.relatedsites.create')

    </div>
    <!-- /.container-fluid -->
@endsection

@push('js')

    <!-- Delete Confirmation Script -->
    <script>
        function deleteSite(siteId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this site? This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the delete form if the user confirms
                    const form = document.getElementById(`delete_site_${siteId}`);
                    form.submit();

                    // Show success message
                    Swal.fire(
                        'Deleted!',
                        'The site has been deleted.',
                        'success'
                    ).then(() => {
                        // Optionally, you can perform any action after deletion, e.g., remove the row from the table
                        location.reload(); // Reload the page to reflect changes
                    });
                }
            });
        }
    </script>
@endpush
