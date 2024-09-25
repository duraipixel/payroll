 <!--begin::Navbar-->
 @extends('layouts.template')
 @section('content')

     <link rel="stylesheet" href="{{ asset('assets/css/registration.css') }}">

     <link rel="stylesheet" href="{{ asset('assets/css/bd-wizard.css') }}">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


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
         <!--begin::Card body-->
         <div class="card-body">
        <h5> Payroll  Bulk Upload </h5>
        <form method="POST" action="{{ route('payroll.bulk.upload.save') }}" enctype="multipart/form-data">
                 @csrf
                 <div class="row">
                     <!--begin::Input group-->
                     <div class="col-lg-6 mb-5">


                         <input class="form-control" type="file" name="file" id="file">

                     </div>
                     <div class="col-lg-6 mb-5">

                        
                        <a  class="btn btn-primary" href="{{ route('bulk.sample.download') }}">Download</a> <br><label class="form-label">Download Sample Excel</label>
                        
                        </div>

                     <div class="col-lg-6 mb-12">

                         <button type="submit" class="btn btn-success">Submit</button>

                     </div>

                 </div>
             </form>
             @if ($errors->any())
                 <?php $i = 1; ?>
                 @foreach ($errors->all() as $error)
                     <li style="list-style:none;color:red ">{{ $i }}. {{ $error }}</li>
                     <?php $i++; ?>
                 @endforeach
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

         <script></script>
     @endsection
