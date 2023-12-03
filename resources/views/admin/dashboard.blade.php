@extends('../template/layout')

@section('title', 'Admin Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('body')

    <div class="content-body" id="body_content">
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Active Student</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{number_format($ActiveStudent)}}</h4>
                                    {{--                                <small class="text-success">(+29%)</small>--}}
                                </div>
                                <p class="mb-0">Total Student</p>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                  <i class="bx bx-user bx-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Inactive Student</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($InactiveStudent) }}</h4>
                                    {{--                                <small class="text-success">(+18%)</small>--}}
                                </div>
                                <p class="mb-0">Total Student</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-danger">
              <i class="bx bx-user-check bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Active Faculty</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($activeFaculties) }}</h4>
                                    {{--                                <small class="text-danger">(-14%)</small>--}}
                                </div>
                                <p class="mb-0">Total Faculties</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-success">
              <i class="bx bx-group bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Inactive Faculties</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($InactiveFaculties) }}</h4>
                                    {{--                                <small class="text-success">(+42%)</small>--}}
                                </div>
                                <p class="mb-0">Total Faculties</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-warning">
              <i class="bx bx-user-voice bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Group</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($totalGroups) }}</h4>
                                    {{--                                <small class="text-success">(+29%)</small>--}}
                                </div>
                                <p class="mb-0">Total Group</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-primary">
              <i class="bx bx-user bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Pandding Group</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($panddingGroups) }}</h4>
                                    {{--                                <small class="text-success">(+29%)</small>--}}
                                </div>
                                <p class="mb-0">Total Group</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-primary">
              <i class="bx bx-user bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Group With Guide</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($GroupWithGuide) }} </h4>
                                    {{--                                <small class="text-danger">(-14%)</small>--}}
                                </div>
                                <p class="mb-0">Total Group</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-success">
              <i class="bx bx-group bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Group Without Guide</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($GroupWithoutGuide) }} </h4>
                                    {{--                                <small class="text-danger">(-14%)</small>--}}
                                </div>
                                <p class="mb-0">Total Group</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-success">
              <i class="bx bx-group bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Projects</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{number_format($projectAllocated)}}</h4>
                                    {{--                                <small class="text-success">(+18%)</small>--}}
                                </div>
                                <p class="mb-0">Total Project</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-danger">
              <i class="bx bx-user-check bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>Group Without Project</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($GroupWithoutProject)  }}</h4>
                                    {{--                                <small class="text-success">(+42%)</small>--}}
                                </div>
                                <p class="mb-0">Total Group</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-warning">
              <i class="bx bx-user-voice bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span> With Guide and Without Project</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($GroupWithGuideWithoutProject)  }}</h4>
                                    {{--                                <small class="text-success">(+42%)</small>--}}
                                </div>
                                <p class="mb-0">Total Group</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-warning">
              <i class="bx bx-user-voice bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>With Guide and Project</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{ number_format($GroupWithGuideWithProject) }}</h4>
                                    {{--                                <small class="text-success">(+29%)</small>--}}
                                </div>
                                <p class="mb-0">Total Group</p>
                            </div>
                            <div class="avatar">
            <span class="avatar-initial rounded bg-label-primary">
              <i class="bx bx-user bx-sm"></i>
            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection


@push('scripts')

    <script>
        $(document).ready(function () {
            $(document).on('change', '#NavcourseYear', function () {
                let cur_url = window.location.href;
                let courseYear = $(this).val();

                // store it to laravel session
                $.ajax({
                    method: 'post',
                    url: '{{ route('setCourseYearSession') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        courseYearId: courseYear
                    },
                    success: function (res) {
                        $.ajax({
                            url: cur_url,
                            type: "GET",
                            success: function (data) {
                                var html = $(data).find('#body_content').html();

                                $(document).find('#body_content').html(html);
                            }
                        });
                    }
                })
            })
        });
    </script>

@endpush
