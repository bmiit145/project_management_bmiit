@extends('../template/layout')

@section('title', 'Admin Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('body')

    <div class="row">
        <div class="col-md-6">

            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add new Program</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('program.add') }}" id="addProgramForm">
                            @csrf
                            <span id="error_info">

                            </span>
                            <div class="mb-3">
                                <label class="form-label" for="code">code</label>
                                <div class="input-group input-group-merge">
                                    {{-- <span id="code2" class="input-group-text">
                                        <i class="bx bx-buildings"></i></span> --}}
                                    <input type="text" id="code" class="form-control" name="code"
                                        placeholder="IT4003" aria-label="IT4003" aria-describedby="code2" />
                                </div>
                                <label id="code-error" class="error" for="code"></label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">name</label>
                                <div class="input-group input-group-merge">
                                    {{-- <span id="name2" class="input-group-text">
                                        <i class="bx bx-buildings"></i></span> --}}
                                    <input type="text" id="name" class="form-control" name="name"
                                        placeholder="B.Sc(IT)" aria-label="B.Sc(IT)" aria-describedby="name2" />
                                </div>
                                <label id="name-error" class="error" for="name"></label>
                            </div>


                            <button type="submit" class="btn btn-primary">Add Program</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- </div>  -->
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header "> <strong> Program List</strong></h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-responsive text-nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                {{-- <th>Name</th> --}}
                                {{-- <th>Status</th>
                                <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            {{-- @if (count($years) != 0) --}}
                                @foreach ($years as $key => $year)
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{ ++$key }}</strong>
                                        </td>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{ $year->name }}</strong>
                                        </td>
                                        {{-- <td>
                                    @if ($program->status == 1)
                                        <td id="status"><span class="badge bg-label-primary me-1">Active</span></td>
                                    @else
                                        <td id="status"><span class="badge bg-label-danger me-1">InActive</span></td>
                                    @endif
                                    </td> --}}
                                        {{-- <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-edit-alt me-1"></i>
                                                    Edit</a>
                                                @if ($program->status == 1)
                                                    <a class="dropdown-item" href="javascript:void(0);" id="changeStatus"
                                                        data-username="{{ $program->code }}"
                                                        data-status="{{ $program->status }}"><i class="bx bx-refresh"></i>
                                                        <span>Inactive</span></a>
                                                @else
                                                    <a class="dropdown-item" href="javascript:void(0);" id="changeStatus"
                                                        data-username="{{ $program->code }}"
                                                        data-status="{{ $program->status }}"><i
                                                            class="bx bx-refresh"></i>
                                                        <span>Active</span></a>
                                                @endif

                                            </div>
                                        </div>
                                    </td> --}}
                                    </tr>
                                @endforeach
                            {{-- @else
                                <tr>
                                    <td colspan="3" style="text-align: center">No record Found !</td>
                                </tr>
                            @endif --}}
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize the DataTable
            $('#dataTable').DataTable({
                paging: true, // Enable pagination
                pageLength: 10, // Number of rows per page
                responsive: true, // Enable responsive design
                // Add any additional configuration options as needed
                language: {
                emptyTable: "No records available", // Customize the "No record Found" message
            },
            });
        });


        $('#addProgramForm').validate({
            rules: {
                "name": {
                    required: true,
                },
                "code": {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter Program name",
                },
                code: {
                    required: "Please enter Program Code",
                },
            },
            // errorPlacement: function(error, element) {
            // // Use Toastr to show error messages
            // // toastr.error(error.text());
            // },
            // invalidHandler: function(event, validator) {
            // // Use Toastr to show a summary error message
            // toastr.error('Please fix the highlighted fields');
            // },
            submitHandler: function(form, event) {
                // form.submit();
                event.preventDefault();


                // name = $(document).find('#name').val();

                // //send ajax for similar name check
                // if (similarName) {

                // }

                var formData = $('#addProgramForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('program.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function(res) {
                        // console.log(res.success);
                        toastr.success(res.success)
                        $('#addProgramForm')[0].reset();


                        // get and replace table bodyy
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageProgram') }}",
                            // data: ,
                            // dataType: "dataType",
                            success: function(r) {
                                var response = $(r);
                                var tbody = response.find('tbody').html();
                                // console.log(tbody);
                                $(document).find('tbody').html(tbody)
                            },

                            error: function(xhr, response) {
                                if (xhr.status == 422) {
                                    var errors = xhr.responseJSON.errors;

                                    $.each(errors, function(field, messages) {
                                        $.each(messages, function(index,
                                            message) {
                                            toastr.error(messages)
                                        });
                                    });
                                }
                            }

                        })

                    },

                    error: function(xhr, response) {
                        if (xhr.status == 422) {
                            var errors = xhr.responseJSON.errors;

                            $.each(errors, function(field, messages) {
                                $.each(messages, function(index, message) {
                                    toastr.error(messages)
                                });
                            });
                        }
                    }

                });
            }
        })
    </script>
@endpush
