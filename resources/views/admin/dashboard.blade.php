@extends('../template/layout')

@section('title' , "Admin Dashboard | PMS")

<!-- @section('content')
@endsection -->

@section('body')

Good Morning

@endsection


@push('scripts')

<script>
    $('#add_faculty').click(function () {
        $.ajax({
            method:'get',
            url:'{{route("faculty.addForm")}}',
            success:function(res)
            {
                // console.log(res);
                $(document).find('.content-body').html(res)
            }       
        })
    })
</script>
@endpush