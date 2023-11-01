<!DOCTYPE html>

<html lang="en" class="light-style" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>@yield('title')</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"/>

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('../assets/vendor/fonts/boxicons.css') }}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('../assets/vendor/css/core.css') }}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{ asset('../assets/vendor/css/theme-default.css') }}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{ asset('../assets/css/demo.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('../assets/vendor/css/pages/page-auth.css') }}"/>
    <!-- Helpers -->
    <script src="{{ asset('../assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('../assets/js/config.js') }}"></script>


    <!-- toastr -->

    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>

    {{-- data Tables --}}

    <!--datatable css-->
{{--    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />--}}
{{--    <!--datatable responsive css-->--}}
{{--    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />--}}
{{--    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />--}}


    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/buttons.dataTables.min.css') }}"/>


    {{--  Select 2 link  --}}
    <link rel="stylesheet" href="{{ mix('css/select2.min.css') }}"/>
    <script src="{{ mix('js/select2.min.js') }}"></script>

    @yield('css')

</head>

<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @yield('content')
        @include('../template/menu')

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('../template/nav')
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Layout Demo -->
                        @yield('body')
                        <!--/ Layout Demo -->
                    </div>
                </div>
                <!-- / Content -->

                <!-- Footer -->
                @include('../template/footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

</div>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('../assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('../assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('../assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('../assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{ asset('../assets/js/main.js') }}"></script>

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- Content -->
@include('../template/error_toastr')

{{-- data table --}}

{{--<script src="{{ asset('assets/js/dataTables.min.js') }}"></script>--}}
<script src="{{ asset('assets/js/CustomDataTable.js') }}"></script>

{{--<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>--}}

<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
{{--<script src="{{ asset('assets/js/dataTable-main.js') }}"></script>--}}
{{--<script src="{{ asset('assets/js/dt-search.js') }}"></script>--}}


<script src="{{ mix('js/select2.min.js') }}"></script>
<!-- Choices.js script -->

{{--custom--}}
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/js/CustomJqueryValidation.js') }}"></script>


@stack('scripts')
<script>
    $('#add_faculty').click(function () {
        $.ajax({
            method: 'get',
            url: '{{ route('faculty.addForm') }}',
            success: function (res) {
                // console.log(res);
                $(document).find('.content-body').html(res)
            }
        })
    })

    $('#view_faculty').click(function () {
        $.ajax({
            method: 'get',
            url: '{{ route('allFaculty.view') }}',
            success: function (res) {
                // console.log(res);
                $(document).find('.content-body').html(res)
            }
        });
    });
</script>
{{-- for search dropBox--}}
<script>
    // $(document).ready(function () {
        $('.selectSearch').select2();

        $('label.error').css('display', 'none');
    // });
</script>

</body>

</html>
