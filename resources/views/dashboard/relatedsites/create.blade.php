<!-- Modal -->
<form action="{{ route('dashboard.related-site.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="add-site" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Site</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="site-name" class="font-weight-bold">Site Name</label>
                        <input type="text" id="site-name" name="name" placeholder="Enter site name"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="site-url" class="font-weight-bold">Site URL</label>
                        <input type="url" id="site-url" name="url" placeholder="Enter site URL"
                            class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Site</button>
                </div>
            </div>
        </div>
    </div>
</form>
