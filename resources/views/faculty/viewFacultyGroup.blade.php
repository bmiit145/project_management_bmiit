@extends('../template/layout')

@section('title', 'Student Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('body')

    {{--    view all students group where guide is faculty --}}
    <div class="row">
        @foreach($groups as $group)
            <div class="col-md-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="col-12">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="w-100 d-flex justify-content-between align-items-center">
                                    <div class="ms-2 me-2 w-100 d-flex flex-column justify-content-between"
                                         style="text-align: center ;">
                                        <div class="font-weight-bold">
                                            <a href="">
                                                {{"Group No .\t" . $group->group->number }}
                                            </a>
                                        </div>
                                        <div class="text-gray-600">
                                            {{ $group->group->studentGroups->first()->courseYear->course->code  . " - " . $group->group->studentGroups->first()->courseYear->course->name  . " - " . $group->group->studentGroups->first()->courseYear->year->name }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="badge badge-primary text-dark">{{ $group->group->studentGroups->count() }} Members</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-1">
                            @if($group->group->project)
                                <h4 class="card-title mb-1 text-nowrap">{{ $group->group->project->title }}</h4>
                                @if($group->group->project->definition != null)
                                    <p class="d-block mb-3 text-wrap"
                                       style="font-size:small">{{ $group->group->project->definition}}</p>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Project Definition Not Given</strong>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-danger" role="alert">
                                    <strong>Project Not Assigned</strong>
                                </div>
                            @endif

                            {{--                            <h5 class="card-title  mb-2">Guide : <span--}}
                            {{--                                    class="text-primary">{{ $group->group->allocation ? $group->group->allocation->faculty->fname . " " . $group->group->allocation->faculty->lname :"No any Guide Assigned" }}</span>--}}
                            {{--                            </h5>--}}

                            @foreach( $group->group->studentGroups as $student)
                                <small class="d-block pb-1"
                                       style="font-size: math">{{$student->studentenro . "\t" . $student->student->fname . "\t" . $student->student->lname }}</small>
                            @endforeach

                            {{--                            <a href="javascript:;" class="btn btn-sm mt-3 btn-primary">View sales</a>--}}
                        </div>
                        {{--                        cart footer for edit button at wight corner --}}
                        <div class="card-footer pt-0">
                            <div class="w-100 d-flex flex-column justify-content-between"
                                 style="text-align: right ;">
                                <div class="font-weight-bold">
                                    {{--                                            <a href="{{ route('faculty.group.edit', $group->group->id) }}">--}}
                                    <button type="button" class="btn btn-sm btn-primary edit_btn" data-bs-toggle="modal"
                                            data-bs-target="#GroupModal"
                                            data-group_id="{{ $group->group->id }}"><i class='bx bxs-edit'></i>
                                    </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    {{--   Model for view a data of  group --}}
    <div class="modal fade" id="GroupModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScrollableTitle">Review a Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="ModalForm">
                        @csrf
                        <input type="hidden" name="groupid">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="w-100 d-flex justify-content-between align-items-center">
                                            <div class="text-gray-600 font-weight-bold">
                                                <span id="model_courseYear"></span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge badge-primary text-dark"
                                                  id="member_length">10 Members</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="members" class="form-label">Students</label>
                                    <ul id="member_list">

                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Project Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           placeholder="Enter Project Title" required>
                                    <label id="title-error" class="error" for="title"
                                           style="display: none"></label>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="definition" class="form-label">Project Definition</label>
                                    <textarea class="form-control" id="definition" name="definition"
                                              placeholder="Enter Project Definition" required></textarea>
                                    <label id="definition-error" class="error" for="definition"
                                           style="display: none"></label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_Modalform_btn">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(() => {
            $('.edit_btn').click(function () {
                let group_id = $(this).data('group_id');
                $.ajax({
                    url: "{{ route('faculty.group.show') }}",
                    type: "GET",
                    data: {
                        group_id: group_id
                    },
                    success: function (response) {
                        $('#ModalForm input[name="groupid"]').val(response.group.id);
                        if (response.group.project == null) {
                            $('#ModalForm input[name="title"]').val("");
                            $('#ModalForm textarea[name="definition"]').val("");
                        } else {
                            $('#ModalForm input[name="title"]').val(response.group.project.title ? response.group.project.title : "");
                            $('#ModalForm textarea[name="definition"]').val(response.group.project.definition ? response.group.project.definition : "");
                        }

                        $('#member_list').empty();
                        $('#member_length').text(response.group.members + " Members");
                        $('#model_courseYear').text(response.group.student_groups[0].course_year.course.code + " - " + response.group.student_groups[0].course_year.course.name + " - " + response.group.student_groups[0].course_year.year.name);
                        response.group.student_groups.forEach((student) => {
                            $('#member_list').append('<li>' + student.studentenro + "\t" + student.student.fname + "\t" + student.student.lname + '</li>');
                        });

                        // add onclick  to submit button as classname submit_Modalform_btn
                        $('.submit_Modalform_btn').attr('onclick', 'submit_ModalForm(' + response.group.id + ')');

                    }
                });
            });
        });

        function submit_ModalForm(group_id) {
            // for updation
            let titile = $('#ModalForm input[name="title"]').val();
            let definition = $('#ModalForm textarea[name="definition"]').val();

            // actual data send
            let form = $('#ModalForm');
            let formData = form.serialize();
            formData = formData + "&group_id=" + group_id;
            $.ajax({
                url: "{{ route('faculty.group.update') }}",
                type: "POST",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        $('#GroupModal').modal('hide');
                        toastr.success(response.success);


                    } else {
                        toastr.error(response.error);
                    }
                },
                error: function (xhr, response) {
                    if (xhr.status == 422) {
                        var errors = xhr.responseJSON.errors;

                        $.each(errors, function (field, messages) {
                            $.each(messages, function (index,
                                                       message) {
                                toastr.error(message)
                            });
                        });
                    } else if (xhr.status == 500) {
                        toastr.error("Internal Server Error")
                    } else {
                        toastr.error("Something went wrong")
                    }
                }
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            $(document).on('change', '#NavcourseYear', function () {
                let courseYearId = $(this).val();

                var currentUrl = window.location.href;
                var parts = currentUrl.split('/');
                var lastPart = parts.filter(part => part !== '').pop();

                if (lastPart == courseYearId) {
                    return;
                }
                if (courseYearId != -1) {
                    window.location.href = "{{ route('ManageFacultyGroup') }}/" + courseYearId;
                } else {
                    // if last part is not a number then reload the page
                    if (!isNaN(lastPart)) {
                        window.location.href = "{{ route('ManageFacultyGroup') }}";
                    }
                }
            })
        });
    </script>
@endpush
