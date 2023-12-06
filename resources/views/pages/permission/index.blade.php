<!--begin::Navbar-->
@extends('layouts.template')
@section('content')
    <!--begin::Card-->
    <div class="card">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>{{ $message }}</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif 
            
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>{{ $message }}</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
             
        @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>{{ $message }}</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
             
        @if ($message = Session::get('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong>{{ $message }}</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
            
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Please check the form below for errors</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card-body py-4">
            <form action="{{route('permission.save')}}" method="post" class="was-validated" id="dynamic_form">
                @csrf
               
                <input type="hidden" name="form_type" id="form_type" value="{{ $from ?? '' }}">
                <div class="row">
                    <div class="col-sm-4  ">
                        <div class="fv-row form-group mb-10 ">
                            <label class="form-label required" for="">
                             Select Role
                            </label>
                            <div > 
                                <select name="role_id"  required  class="form-control" onchange="return permission_table_show();" id="role_id">
                                    <option value="">--Select Role--</option>
                                    @foreach ($role as $key=>$val)
                                    <option value="{{ $val->id }}" @if(isset($info->staff_id) && $info->staff_id == $val->id) selected @endif>{{ $val['name']  }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Must Select Role</div>
                        </div>
                    </div>
                    </div>            
                </div>   
          
            <!--begin::Table-->
            <div class="role_permi"></div>          
    </div>
   
    <!--end::Card-->
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
@section('add_on_script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
     $('#role_id').select2({
            selectOnClose: true,
            theme: 'bootstrap-5'
    });
    function permission_table_show()
    {
        var role_id=$("#role_id").val();
        if(role_id!='')
        {               
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },                
                url: "{{ route('permission.menu-list') }}",
                type: 'POST',
                datatype: "html",
                data: {
                    role_id: role_id,                    
                },
                success: function(res) {
                    $(".role_permi").html(res);
                }
            })
          
        }              
    }

</script>
@endsection