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
                                <label for="type_id" class="form-label">Course Class</label>
                                <select class="form-control" id="type_id" name="type_id">
                                    <option value="0">Choose One</option>
                                    @foreach ($types as $type)
                                        <option
                                            value="{{ $type->id }}"{{ $course->type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
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

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    </script>
@endsection
