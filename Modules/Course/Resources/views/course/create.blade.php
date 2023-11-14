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
                                <label for="type_id" class="form-label">Course Class</label>
                                <select class="form-control" id="type_id" name="type_id">
                                    <option value="0">Choose One</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
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
    </script>
@endsection
