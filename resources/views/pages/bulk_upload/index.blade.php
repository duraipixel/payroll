 <!--begin::Navbar-->
 @extends('layouts.template')
 @section('content')
    
     <link rel="stylesheet" href="{{ asset('assets/css/registration.css') }}">

     <link rel="stylesheet" href="{{ asset('assets/css/bd-wizard.css') }}">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


     <!--begin::Card-->
     <div class="card">
         <!--begin::Card body-->
         <div class="card-body">
          
            <form action="{{ route('staff.save') }}" method="post" enctype="multipart/form-data" >
                @csrf
             <div class="row">
                <!--begin::Input group-->
                <div class="col-lg-6 mb-5">
                
                    <label class="form-label">Bulk Upload</label>               
                    <input class="form-control"  type="file" name="file" id="file" >
                
                </div>
                <div class="col-lg-6 mb-5">
                
                    <label class="form-label">Download Sample Excel</label>  <br>             
                  <a href="#"><button type="button" class="btn btn-primary">Download</button></a>
                
                </div>
                <div class="col-lg-6 mb-12">              
                        
               <button type="submit" class="btn btn-primary">Submit</button>
                
                </div>
          
         </div>
        </form>
        @if($errors->any())
        <?php $i=1;?>
         @foreach($errors->all() as $error)
         <li style="list-style:none;color:red ">{{$i}}. {{$error}}</li>
        <?php $i++;?>
         @endforeach
         @endif

         @if ($errors->isEmpty())
        
         @endif
         <!--end::Card body-->
     </div>
    
     <script src="{{ asset('assets/js/jquery.steps.min.js') }}"></script>
     <script src="{{ asset('assets/js/bd-wizard.js') }}"></script>
     <!--end::Card-->
 @endsection

 @section('add_on_script')


    {{-- <script src="{{ asset('assets/js/custom/utilities/modals/create-account.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/apps/save-product.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

    <script>
    
    </script>
 @endsection
