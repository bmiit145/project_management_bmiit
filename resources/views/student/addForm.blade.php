@extends('../template/layout')

@section('title', 'Admin Dashboard | PMS')

<!-- @section('content')
@endsection -->

@section('body')

    <!-- <div class="container-xxl flex-grow-1 container-p-y"> -->
    <div class="row">
        <div class="col-md-6">

            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add new Student</h5>
                        <!-- <small class="text-muted float-end">Merged input group</small> -->
                    </div>
                    <div class="card-body">
                        <form id="addStudentForm">
                            @csrf
                            <span id="error_info">

                        </span>

                            <div class="mb-3">
                                <label class="form-label" for="enro">Enrollment Number</label>
                                <div class="input-group input-group-merge">
                                <span id="enno2" class="input-group-text">
                                    <i class="bx bx-buildings"></i></span>
                                    <input type="text" id="enro" class="form-control"
                                           name="enro" placeholder="202106100110145"
                                           aria-label="202106100110145" aria-describedby="enro2"/>
                                </div>
                            </div>
                            <label id="enro-error" class="error" for="enro" style="display: none"></label>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                                <div class="input-group input-group-merge">
                                    <!-- <span id="basic-icon-default-fullname2" class="input-group-text"
                                  ><i class="bx bx-user"></i
                                ></span> -->
                                    <!-- <input
                                  type="text"
                                  class="form-control"
                                  id="basic-icon-default-fullname"
                                  placeholder="John Doe"
                                  aria-label="John Doe"
                                  aria-describedby="basic-icon-default-fullname2"
                                /> -->
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span>
                                    <!-- <span class="input-group-text">First and last name</span> -->
                                    <input type="text" name="fname" placeholder="John" aria-label="First name"
                                           class="form-control">
                                    <input type="text" name="lname" placeholder="Doe" aria-label="Last name"
                                           class="form-control">

                                </div>
                                <label id="fname-error" class="error" for="fname" style="display:none ;"></label><br>
                                <label id="lname-error" class="error" for="lname" style="display:none ;"></label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="text" id="email" class="form-control" name="email"
                                           placeholder="john.doe@gmail.com" aria-label="john.doe.gmail.com"
                                           aria-describedby="email2"/>
                                    {{--                                <span id="email2" class="input-group-text">@utu.ac.in</span>--}}
                                </div>
                                <!-- <div class="form-text">You can use letters, numbers & periods</div> -->
                                <div class="form-text">Username is same as email for login</div>
                                <label id="email-error" class="error" for="email"></label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="contactno">Phone No</label>
                                <div class="input-group input-group-merge">
                                <span id="contactno" class="input-group-text"><i
                                        class="bx bx-phone"></i></span>
                                    <input type="text" id="contactno" class="form-control phone-mask"
                                           name="contactno" placeholder="658 799 8941" aria-label="658 799 8941"
                                           aria-describedby="contactno"/>
                                </div>
                                <label id="contactno-error" class="error" for="contactno"></label>
                            </div>
                            <div class="mb-3">
                                <label for="program" class="form-label">Program</label>
                                <select class="form-select selectSearch" id="program" name="programId"
                                        aria-label="Default select example">
                                    <option value="-1" selected>select Program</option>
                                    @foreach ($programs as $program)
                                        <option
                                            value="{{ $program->id }}">{{ $program->code ." - " . $program->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label id="program-error" class="error" for="program"
                                       style="display: none"></label>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- </div>  -->
        </div>
    </div>

@endsection

@push('scripts')
{{--    <script src="{{ asset('js/jquery.validate.js') }}"></script>--}}

    <script>
        $.validator.addMethod("noAtSymbol", function (value, element) {
            return value.indexOf("@") === -1;
        }, "Email should not contain @ symbol");

        $('#addStudentForm').submit(function (e) {
            e.preventDefault();
        });

        $('#addStudentForm').validate({
            rules: {
                "enro": {
                    required: true,
                    digits: true
                },
                "fname": {
                    required: true,
                    minlength: 2
                },
                "lname": {
                    required: true,
                    minlength: 2
                },
                "email": {
                    required: true,
                    // noAtSymbol: true
                },
                "contactno": {
                    required: true,
                    minlength: 10, // Minimum length of 10 characters
                    maxlength: 10, // Maximum length of 10 characters
                    digits: true // Only allow numeric digits
                },
                "programId": {
                    required: true,
                    notEqualValue: '-1',
                }
            },
            messages: {
                contactno: {
                    required: "Please enter your contact number",
                    minlength: "Contact number must be exactly 10 digits long",
                    maxlength: "Contact number must be exactly 10 digits long",
                    digits: "Please enter only numeric digits"
                },
                fname: {
                    required: "Please enter your First name",
                },
                lname: {
                    required: "Please enter your Last name",
                },
                enro: {
                    required: "Please enter your Enrollment number",
                },
                email: {
                    required: "Please Enter Valid Info."
                },
                programId: {
                    required: "Please Select Program.",
                    notEqualValue: "Please Select Program."
                }
            },
            // errorPlacement: function(error, element) {
            //     // Use Toastr to show error messages
            //     // toastr.error(error.text());
            // },
            // invalidHandler: function(event, validator) {
            //     // Use Toastr to show a summary error message
            //     toastr.error('Please fix the highlighted fields');
            // },
            submitHandler: function (form, event) {
                // This function will be executed when the form is valid
                // You can perform any custom actions here, such as AJAX submission
                // form.submit();
                event.preventDefault();
                // oldemail = $('#email').val();
                // console.log(oldemail);
                // newemail = oldemail+'@utu.ac.in';
                var formData = $('#addStudentForm').serialize()
                // formData = formData.replace('email='+oldemail, 'email='+newemail)
                $.ajax({
                    type: "post",
                    url: "{{route('student.add')}}",
                    data: formData,
                    // dataType: "dataType",
                    success: function (res) {
                        // console.log(res.success);
                        toastr.success(res.success)
                        $('#addStudentForm')[0].reset()
                        $('#addStudentForm select').trigger('change');
                        courseYearFill();
                    },
                    error: function (xhr, response) {
                        if (xhr.status == 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function (field, messages) {
                                $.each(messages, function (index,
                                                           message) {
                                    toastr.error(messages)
                                });
                            });
                        } else if (xhr.status == 500) {
                            // toastr.error(xhr.responseJSON.message)
                            toastr.error('Something went wrong !')
                        }
                    }

                });
            }
        })
    </script>

@endpush
