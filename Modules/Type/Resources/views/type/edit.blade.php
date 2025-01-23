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
            <label for="name" class="form-label">Level Name</label>
            <input type="text" class="form-control" name="name" value="{{ $type->name }}">
        </div>
        <div class="g-col-12 g-col-sm-12 mt-3">
            <label for="faculty" class="form-label">Faculty Name</label>
            <input type="text" class="form-control" name="faculty" value="{{ $type->faculty_name }}">
        </div>

        <div class="g-col-12 g-col-sm-12 mt-3">
            <label for="university_id" class="form-label">University</label>
            <select class="form-control" id="university_id" name="university_id">
                <option value="0">Choose One</option>
                @foreach ($universities as $university)
                    <option
                        value="{{ $university->id }}"{{ $type->university_id == $university->id ? 'selected' : '' }}>
                        {{ $university->name }}</option>
                @endforeach
            </select>
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
