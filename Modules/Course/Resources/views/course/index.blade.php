@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="text-center" style="display:flex; justify-content:space-between;">
                        <h5 class="card-title fw-semibold mb-4">All Courses</h5>

                        <a class="btn btn-primary shadow-md me-2" href="{{ route('admin.course.create') }}"
                            style="height: 50%;margin-top: 40px;">
                            <i class="ti ti-plus"></i>
                            Add New Course
                        </a>
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
                                        <h6 class="fw-semibold mb-0">Name</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">University</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Level</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Count of users</h6>
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
                                @foreach ($courses as $index => $course)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $index + 1 }}</h6>
                                        </td>

                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $course['name'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $course['university'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $course['level'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $course['users'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{{ $course['created_at'] }}</p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">{!! $course['btn'] !!}</p>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $courses->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
