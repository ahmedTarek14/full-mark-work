<form class="modal-content ajax-form" action="{{ route('admin.university.update', ['university' => $university->id]) }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- BEGIN: Modal Header -->
    <div class="modal-header">
        <h5 class="fw-medium fs-base me-auto">
            Edit University
        </h5>
    </div>
    <!-- END: Modal Header -->
    <!-- BEGIN: Modal Body -->
    <div class="modal-body grid columns-12 gap-4 gap-y-3">
        <div class="g-col-12 g-col-sm-12">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control" name="logo" id="logo" accept="image/*"
                onchange="previewImage(event)">
            <img id="logo-preview" src="{{ $university->logo_image_path }}" alt="Logo Preview"
                style="display:block; margin-top:10px; max-height: 200px;">
        </div>
        <div class="g-col-12 g-col-sm-12">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $university->name }}">
        </div>
    </div>
    <!-- END: Modal Body -->
    <!-- BEGIN: Modal Footer -->
    <div class="modal-footer text-end">
        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-20 me-1">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    <!-- END: Modal Footer -->
</form>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('logo-preview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
