@extends('../template/layout')

@section('title' , "Faculty Dashboard | PMS")

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
                                <span>Total Groups</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{number_format($studentGroups->count())}}</h4>
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
