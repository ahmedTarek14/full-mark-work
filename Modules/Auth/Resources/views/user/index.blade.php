@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex">
                        <h5 class="card-title fw-semibold mb-4 p-2 w-100">All Users</h5>
                        <div class="form-group p-2 flex-shrink-1">
                            <label for="serach" class="form-label">Search</label>
                            <input type="text" name="serach" id="serach" class="form-control bg-white" />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="sorting border-bottom-0" data-sorting_type="asc" data-column_name="id"
                                        style="cursor: pointer">
                                        <h6 class="fw-semibold mb-0">#</h6>
                                        <span id="id_icon"><i class="fas fa-sort"></i></span>
                                    </th>

                                    <th class="sorting border-bottom-0" data-sorting_type="asc" data-column_name="name"
                                        style="cursor: pointer">
                                        <h6 class="fw-semibold mb-0">Name</h6><span id="name_icon"><i
                                                class="fas fa-sort"></i></span>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Email</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
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
                                @include('auth::user.data_table')
                            </tbody>
                        </table>
                        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            function clear_icon() {
                $('#id_icon').html('');
                $('#name_icon').html('');
            }

            function fetch_data(page, sort_type, sort_by, query) {
                $.ajax({
                    url: "{{ url()->current() }}" + "/?page=" + page + "&sortby=" + sort_by +
                        "&sorttype=" + sort_type + "&query=" +
                        query,
                    success: function(data) {
                        $('tbody').html('');
                        $('tbody').html(data);
                    }
                })
            }
            $('body').on('keyup', '#serach', function() {
                var query = $('#serach').val();
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var page = $('#hidden_page').val();
                fetch_data(page, sort_type, column_name, query);
            });
            $('body').on('click', '.sorting', function() {
                var column_name = $(this).data('column_name');
                var order_type = $(this).data('sorting_type');
                var reverse_order = '';
                if (order_type == 'asc') {
                    $(this).data('sorting_type', 'desc');
                    reverse_order = 'desc';
                    clear_icon();
                    $('#' + column_name + '_icon').html(
                        '<i class="fas fa-sort"></i>');
                }
                if (order_type == 'desc') {
                    $(this).data('sorting_type', 'asc');
                    reverse_order = 'asc';
                    clear_icon
                    $('#' + column_name + '_icon').html(
                        '<i class="fas fa-sort"></i>');
                }
                $('#hidden_column_name').val(column_name);
                $('#hidden_sort_type').val(reverse_order);
                var page = $('#hidden_page').val();
                var query = $('#serach').val();
                fetch_data(page, reverse_order, column_name, query);
            });
            $('body').on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('#hidden_page').val(page);
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var query = $('#serach').val();
                $('li').removeClass('active');
                $(this).parent().addClass('active');
                fetch_data(page, sort_type, column_name, query);
            });
        });
    </script>
@endpush
