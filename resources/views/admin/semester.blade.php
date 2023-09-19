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
                        <h5 class="mb-0">Add new Semester</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('semester.add') }}" id="addSemesterForm">
                            @csrf
                            <span id="error_info">

                            </span>
                            <div class="mb-3">
                                <label class="form-label" for="name">Semester name</label>
                                <div class="input-group input-group-merge">
                                    {{-- <span id="name2" class="input-group-text">
                                        <i class="bx bx-buildings"></i></span> --}}
                                    <input type="text" id="name" class="form-control" name="name"
                                        placeholder="5" aria-label="5" aria-describedby="name2" />
                                </div>
                                <label id="name-error" class="error" for="name"></label>
                            </div>


                            <button type="submit" class="btn btn-primary">Add new Semester</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- </div>  -->
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header "> <strong> Semester List</strong></h5>
                <div class="table-responsive text-nowrap m-2">
                    <table class="table table-hover table-responsive text-nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                {{-- <th>Status</th>
                                <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                                @foreach ($semester as $key => $sem)
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{ ++$key }}</strong>
                                        </td>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <span>{{ $sem->name }}</span>
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
    <script src="{{ asset('assets/js/CustomDataTable.js') }}"></script>


    <script>
        $(document).ready(function() {
            // Initialize the DataTable
            CreateDataTable();
        });
    </script>
    <script>
        $('#addSemesterForm').validate({
            rules: {
                "name": {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter Program name",
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

                var formData = $('#addSemesterForm').serialize()
                $.ajax({
                    type: "post",
                    url: "{{ route('semester.add') }}",
                    data: formData,
                    // dataType: "dataType",
                    success: function(res) {
                        // console.log(res.success);
                        toastr.success(res.success)
                        $('#addSemesterForm')[0].reset();


                        // get and replace table bodyy
                        $.ajax({
                            type: "get",
                            url: "{{ route('ManageSemester') }}",
                            // data: ,
                            // dataType: "dataType",
                            success: function(r) {
                                DestroyDataTable();
                                var response = $(r);
                                var tbody = response.find('tbody').html();
                                // console.log(tbody);
                                $(document).find('tbody').html(tbody)
                                CreateDataTable();
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
