@if (session('error'))
    <script>
        console.log("{{session('error')}}")
        toastr.options =
        {
  	        "closeButton" : true,
  	        "progressBar" : true
        }
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