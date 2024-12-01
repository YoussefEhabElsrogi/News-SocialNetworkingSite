<!-- Modal -->
<form action="{{ route('dashboard.categories.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <!-- Category Name Input -->
                        <input type="text" name="name" placeholder="Enter Category Name" class="form-control">
                        <br>
                        <!-- Small Description Input -->
                        <textarea name="small_desc" placeholder="Enter Small Description" class="form-control" rows="3"></textarea>
                        <br>
                        <!-- Status Dropdown -->
                        <select name="status" class="form-control">
                            <option disabled selected>Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </div>
        </div>
    </div>
</form>
