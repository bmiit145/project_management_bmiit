<script>
    toastr.options = {
        positionClass: 'toast-top-right', // Adjust as needed
        closeButton: true,
        progressBar: true,
        timeOut: 6000,
    };

    // You can also configure other options as needed
    // For example: toastr.options.timeOut = 5000; // 5 seconds

</script>

@if (session('error'))
    <script>
        console.log("{{session('error')}}")
        toastr.error("{{ session('error') }}");
    </script>
@endif

@if (session('success'))
    <script>
        console.log("{{session('success')}}")
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if ($errors->any())

    @foreach ($errors->all() as $error)
        <!-- <li>{{ $error }}</li> -->
        <script>
            console.log("{{$error}}")
            toastr.error("{{ $error}}");
        </script>
    @endforeach
@endif
