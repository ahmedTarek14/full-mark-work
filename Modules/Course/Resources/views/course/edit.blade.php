@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Course</h5>
                <div class="card">
                    <div class="card-body">
                        <form class="ajax-form" id="courseForm" method="put"
                            action="{{ route('admin.course.update', $course->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="course_name" class="form-label">Course Name</label>
                                <input type="text" class="form-control" id="course_name" name="course_name"
                                    value="{{ old('course_name', $course->name) }}">
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Course Price</label>
                                <input type="text" class="form-control" id="price" name="price"
                                    value="{{ old('price', $course->price) }}">
                            </div>

                            <div class="mb-3">
                                <label for="university_id" class="form-label">University</label>
                                <select class="form-control universities" id="university_id" name="university_id">
                                    <option value="0">Choose One</option>
                                    @foreach ($universities as $university)
                                        <option
                                            value="{{ $university->id }}"{{ $course->university_id == $university->id ? 'selected' : '' }}>
                                            {{ $university->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="type_id" class="form-label">Course Level</label>
                                <select class="form-control levels" id="type_id" name="type_id">
                                    <option value="0">Choose One</option>
                                    @foreach ($types as $type)
                                        <option
                                            value="{{ $type->id }}"{{ $course->type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pdf_upload" class="form-label">Upload PDF</label>
                                <input type="file" class="form-control" id="pdf_upload" name="pdf"
                                    value = "{{ $course->pdf_path }}" accept="application/pdf">
                            </div>
                            <div class="mb-3">
                                @if ($course->pdf)
                                    <label for="pdf_preview" class="form-label">Current PDF</label>
                                    <iframe id="pdf_preview" src="{{ $course->pdf_path }}"
                                        style="width: 100%; height: 500px;"></iframe>
                                @else
                                    <iframe id="pdf_preview" style="width: 100%; height: 500px; display: none;"></iframe>
                                @endif
                            </div>
                            <div class="mb-3" id="additionalInputs">
                                @foreach ($course->links as $index => $link)
                                    <div>
                                        <div class="mb-3">
                                            <label for="link_title" class="form-label">Video Title</label>
                                            <input type="text" class="form-control" id="link_title" name="link_title[]"
                                                value="{{ $link->name }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="link" class="form-label">Link</label>
                                            <input type="text" class="form-control" id="link" name="link[]"
                                                value="{{ $link->url }}">
                                        </div>
                                        @if ($index > 0)
                                            <button type="button" class="btn btn-danger mb-3"
                                                onclick="deleteInput(this)">Delete</button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="mb-3 btn btn-success d-block" onclick="addInput()">Add
                                More</button>

                            <div class="mb-3">
                                <label for="user_id" class="form-label">Users</label>
                                <select id="user_id" multiple="multiple" class="select2 form-control" name="user_id[]">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ (in_array($user->id, $course->usersPivot->pluck('user_id')->toArray()) ?: []) ? 'selected' : '' }}>
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

            var inputGroup = document.createElement('div');
            inputGroup.className = 'mb-3';

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
            titleInput.value = '{{ old('link_title') }}';

            var linkLabel = document.createElement('label');
            linkLabel.className = 'form-label';
            linkLabel.textContent = 'Link';

            var linkInput = document.createElement('input');
            linkInput.type = 'text';
            linkInput.className = 'form-control';
            linkInput.name = 'link[]';
            linkInput.value = '{{ old('link') }}';

            var deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-danger';
            deleteButton.textContent = 'Delete';
            deleteButton.onclick = function() {
                additionalInputs.removeChild(inputGroup);
            };

            titleGroup.appendChild(titleLabel);
            titleGroup.appendChild(titleInput);
            linkGroup.appendChild(linkLabel);
            linkGroup.appendChild(linkInput);

            inputGroup.appendChild(titleGroup);
            inputGroup.appendChild(linkGroup);
            inputGroup.appendChild(deleteButton);

            additionalInputs.appendChild(inputGroup);
        }

        function deleteInput(button) {
            var additionalInputs = document.getElementById('additionalInputs');
            var inputGroup = button.parentElement;
            additionalInputs.removeChild(inputGroup);
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
