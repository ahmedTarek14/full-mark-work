<form class="modal-content ajax-form" action="{{ route('admin.type.update', ['type' => $type->id]) }}" method="PUT">
    @csrf
    @method('PUT')
    <!-- BEGIN: Modal Header -->
    <div class="modal-header">
        <h5 class="fw-medium fs-base me-auto">
            Edit Level
        </h5>
    </div>
    <!-- END: Modal Header -->
    <!-- BEGIN: Modal Body -->
    <div class="modal-body grid columns-12 gap-4 gap-y-3">


        <div class="g-col-12 g-col-sm-12">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $type->name }}">
        </div>
    </div>
    <!-- END: Modal Body -->
    <!-- BEGIN: Modal Footer -->
    <div class="modal-footer text-end">
        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-20 me-1">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    <!-- END: Modal Footer -->
    </div>
</form>
