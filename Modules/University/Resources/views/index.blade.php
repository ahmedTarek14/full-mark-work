@extends('layouts.master')
@push('models')
    <!-- Modal Add Employees -->
    <div class="modal fade " id="add-class">
        <div class="modal-dialog">
            <form class="modal-content ajax-form" action="{{ route('admin.university.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="fw-medium fs-base me-auto">Add New University</h5>
                </div>
                <div class="modal-body grid columns-12 gap-4 gap-y-3">

                    <div class="g-col-12 g-col-sm-12">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" name="logo" id="logo" accept="image/*"
                            onchange="previewImage(event)">
                        <img id="logo-preview" src="" alt="Logo Preview"
                            style="display:none; margin-top:10px; margin-bottom:10px; max-height: 150px;">
                    </div>
                    <div class="g-col-12 g-col-sm-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                </div>
                <div class="modal-footer text-end">
                    <button type="button" data-bs-dismiss="modal"
                        class="btn btn-outline-secondary w-20 me-1">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="text-center" style="display:flex; justify-content:space-between;">
                        <h5 class="card-title fw-semibold mb-4">All Universities</h5>
                        <button class="btn btn-primary shadow-md me-2" data-bs-toggle="modal" data-bs-target="#add-class"
                            style="height: 50%;margin-top: 40px;">
                            <i class="ti ti-plus"></i> Add New University
                        </button>
                    </div>
                    {{-- <h5 class="card-title fw-semibold mb-4">All Classes</h5> --}}
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">#</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">University Logo</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">University name</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Levels Count</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Created At</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Actions</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($universities as $index => $university)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $index + 1 }}</h6>
                                        </td>

                                        <td class="border-bottom-0">
                                            <img src="{{ $university['logo'] }}" width="75" height="75"
                                                class="rounded-circle">
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $university['name'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $university['levels'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $university['created_at'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{!! $university['btn'] !!}</p>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $universities->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
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
@endpush
