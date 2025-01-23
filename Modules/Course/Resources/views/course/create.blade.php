@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Add New Course</h5>
                <div class="card">
                    <div class="card-body">
                        <form class="ajax-form" id="courseForm" method="post" action="{{ route('admin.course.store') }}">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="course_name" class="form-label">Course Name</label>
                                <input type="text" class="form-control" id="course_name" name="course_name">
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Course Price</label>
                                <input type="text" class="form-control" id="price" name="price">
                            </div>

                            <div class="mb-3">
                                <label for="university_id" class="form-label">University</label>
                                <select class="form-control universities" id="university_id" name="university_id">
                                    <option value="0">Choose One</option>
                                    @foreach ($universities as $university)
                                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="type_id" class="form-label">Course Level</label>
                                <select class="form-control levels" id="type_id" name="type_id">
                                    <option value="0">Choose One</option>

                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="pdf" class="form-label">Upload PDF</label>
                                <input type="file" class="form-control" id="pdf_upload" name="pdf"
                                    accept="application/pdf">
                            </div>

                            <div class="mb-3">
                                <iframe id="pdf_preview" style="width: 100%; height: 500px; display: none;"></iframe>
                            </div>

                            <div class="mb-3">
                                <label for="link_title" class="form-label">Video Title</label>
                                <input type="text" class="form-control" id="link_title" name="link_title[]">
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Link</label>
                                <input type="text" class="form-control" id="link" name="link[]">
                            </div>

                            <div class="mb-3" id="additionalInputs"></div>

                            <button type="button" class="mb-3 btn btn-success d-block" onclick="addInput()">Add
                                More</button>

                            <div class="mb-3">
                                <label for="user_id" class="form-label">Users</label>
                                <select id="user_id" multiple="multiple" class="select2 form-control" name="user_id[]">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function addInput() {
            var additionalInputs = document.getElementById('additionalInputs');

            var titleGroup = document.createElement('div');
            titleGroup.className = 'mb-3';

            var linkGroup = document.createElement('div');
            linkGroup.className = 'mb-3';

            var titleLabel = document.createElement('label');
            titleLabel.className = 'form-label';
            titleLabel.textContent = 'Video Title';

            var titleInput = document.createElement('input');
            titleInput.type = 'text';
            titleInput.className = 'form-control';
            titleInput.name = 'link_title[]';

            var linkLabel = document.createElement('label');
            linkLabel.className = 'form-label';
            linkLabel.textContent = 'Link';

            var linkInput = document.createElement('input');
            linkInput.type = 'text';
            linkInput.className = 'form-control';
            linkInput.name = 'link[]';

            titleGroup.appendChild(titleLabel);
            titleGroup.appendChild(titleInput);
            linkGroup.appendChild(linkLabel);
            linkGroup.appendChild(linkInput);

            additionalInputs.appendChild(titleGroup);
            additionalInputs.appendChild(linkGroup);
        }

        $(document).on('change', '.universities', function() {

            var url = "{{ route('admin.ajax.levels') }}";
            var university_id = $(this).val()

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    university_id: university_id
                },
                dataType: 'json',
                success: function(response) {
                    $('.levels').html(response);
                }
            })

            return false;
        });

        document.getElementById('pdf_upload').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file.type === 'application/pdf') {
                var url = URL.createObjectURL(file);
                var iframe = document.getElementById('pdf_preview');
                iframe.src = url;
                iframe.style.display = 'block';
            }
        });
    </script>
@endpush
