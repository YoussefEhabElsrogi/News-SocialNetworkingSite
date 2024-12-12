<form action="{{ route('dashboard.related-site.update', $site->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="modal fade" id="edit-site-{{ $site->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editSiteModalLabel-{{ $site->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editSiteModalLabel-{{ $site->id }}">Edit Site: {{ $site->name }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-site-name-{{ $site->id }}" class="font-weight-bold">Site Name</label>
                        <input type="text" id="edit-site-name-{{ $site->id }}" name="name"
                            value="{{ $site->name }}" placeholder="Enter site name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-site-url-{{ $site->id }}" class="font-weight-bold">Site URL</label>
                        <input type="url" id="edit-site-url-{{ $site->id }}" name="url"
                            value="{{ $site->url }}" placeholder="Enter site URL" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Site</button>
                </div>
            </div>
        </div>
    </div>
</form>
