<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <!--begin::Card title-->
<style>
    .btn-info-blue {
    color: #00d6f7;
    background-color: #f9ffff;
    border-color: #17a2b8 !important;
    }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="text-center mt-6">
                        <img width="100"
                            src="data:image/png;base64,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"
                            class="rounded" alt="...">
                    </div>
                    <div class="form-group mt-3 py-3 px-5">
                        <h3> {{$user->name}}</h3>
                        <div class="p-3">
                            {!! genderMaleSvg() !!} 
                            {{ucfirst($user->personal->gender ?? '')}}
                        </div>
                        <div class="p-3">
                            {!! userSvg() !!}{{$user->position->designation->name ??''}}
                        </div>
                        <div class="p-3">
                            {!! locationSvg() !!}   {{ucfirst($user->personal->contact_address ?? '')}}
                        </div class="p-3">
                        <div class="p-3">
                            {!! mobileSvg() !!}{{$user->personal->phone_no ?? ''}}
                        </div>
                        <div class="p-3">
                            {!! calenderSvg() !!} {{$user->personal->dob ?? ''}}
                        </div>
                        <div class="p-3">
                            {!! emailSvg() !!} {{$user->personal->email ?? ''}}
                        </div>
                        <div>
                            <div class="d-flex p-3">
                                <div class="w-50">
                                    Employee id
                                </div>
                                <div class="fw-bold">
                                    {{$user->emp_code}}
                                </div>
                            </div>
                            <div class="d-flex p-3">
                                <div class="w-50">
                                    Reporting Person
                                </div>
                                <div class="fw-bold">
                                    
                                </div>
                            </div>
                            <div class="d-flex p-3">
                                <div class="w-50">
                                    Marital Status
                                </div>
                                <div class="fw-bold">
                                    {{ucfirst($user->personal->marital_status ?? '')}}   
                                </div>
                            </div>
                            <div class="d-flex p-3">
                                <div class="w-50">
                                    Employee Department
                                </div>
                                <div class="fw-bold">
                                    {{$user->position->department->name ??''}}
                                </div>
                            </div>
                            <div class="d-flex p-3">
                                <div class="w-50">
                                    Employee Since
                                </div>
                                <div class="fw-bold">
                                    @if (@isset($user->appointment->joining_date))
                                    {{date('Y', strtotime($user->appointment->joining_date )) ?? ''}}        
                                    @endif
                                                             
                                   
                                </div>
                            </div>
                            <div class="d-flex p-3">
                                <div class="w-50">
                                    Total Experience
                                </div>
                                <div class="fw-bold">
                                    10 Years
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 p-10">
              
                <div class="d-flex pb-5">
                    
                    <h3> Document Locker </h3>
                   
                   
                    <span class="text-right" style="margin-left:50%" ><button type="button" class="btn btn-info-blue" >Locker No: #{{$user->locker_no ??''}}</button></span>
                </div>
                <div class="card">
                    <div class=" d-flex align-items-start p-10">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <button class="nav-link active p-5" id="v-pills-personal-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-personal" type="button" role="tab" aria-controls="v-pills-personal"
                                aria-selected="true">Personal Documents</button>
                            <button class="nav-link  p-5" id="v-pills-education-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-education" type="button" role="tab"
                                aria-controls="v-pills-education" aria-selected="false">Education Documents</button>
                            <button class="nav-link  p-5" id="v-pills-experience-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-experience" type="button" role="tab"
                            aria-controls="v-pills-experience" aria-selected="false">Experience Documents</button>
                            <button class="nav-link  p-5" id="v-pills-leave-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-leave" type="button" role="tab"
                            aria-controls="v-pills-leave" aria-selected="false">Leave Documents</button>
                            <button class="nav-link  p-5" id="v-pills-salary-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-salary" type="button" role="tab"
                                aria-controls="v-pills-salary" aria-selected="false">Salary Slip</button>
                            <button class="nav-link  p-5" id="v-pills-appointment-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-appointment" type="button" role="tab"
                            aria-controls="v-pills-appointment" aria-selected="false">Appointment Order</button>
                        </div>
                        <div class="tab-content w-100" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-personal" role="tabpanel"
                                aria-labelledby="v-pills-personal-tab">
                                <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                    <thead class="bg-primary p-10">
                                        
                                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="text-center text-white" >Document Name</th>
                                                <th class="text-center text-white">Status</th>
                                                <th class="text-center text-white">Uploaded Date</th>
                                                <th class="text-center text-white">Action</th>
                                              
                                            </tr>
                                           
                                        </thead>                                                                                 
                                     
                                    @forelse ($personal_doc as $personal_docs )
                                    <tr>
                                        <td> {{$personal_docs->documentType->name ??''}}</td>
                                        <td> @if ($personal_docs->verification_status=='pending')                                           
                                            <a href="#" onclick="return changeDocumentStatus({{$personal_docs->id}},'personal')" class="btn btn-icon btn-active-info  btn-danger  mx-1 w-50px h-50px"> 
                                                <i class="fa fa-times"></i></a>                        
                                        @else                                            
                                        <button class="btn  btn-success mx-1 w-50px h-50px"> 
                                            <i class="fa fa-check"></i></button>
                                        @endif</td>
                                        <td> {{$personal_docs->documentType->created_at ??''}}</td>
                                         <td>  
                                            @if ($personal_docs->verification_status=='approved')
                                                <a href="{{ url('storage/app/public'.'/'.$personal_docs->multi_file) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                                <i class="fa fa-download">
                                            @else                                            
                                                <button class="btn  btn-secondary mx-1 w-50px h-50px"> 
                                                    <i class="fa  fa-times-circle"></i></button>
                                            @endif

                                            </i>
                                        </a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4"> <strong>Personal Documents not Uploaded</strong> </td>
                                    </tr>
                                    @endforelse

                                </table>
                                    
                              </div>
                            <div class="tab-pane fade" id="v-pills-education" role="tabpanel"
                                aria-labelledby="v-pills-education-tab">
                                <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                    <thead class="bg-primary p-10">
                                        
                                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="text-center text-white" >Document Name</th>
                                                <th class="text-center text-white">Status</th>
                                                <th class="text-center text-white">Uploaded Date</th>
                                                <th class="text-center text-white">Action</th>
                                              
                                            </tr>
                                           
                                        </thead>                                                                                 
                                    @forelse ($education_doc as $education_docs )
                                    <tr>
                                        <td> {{$education_docs->course_name ??''}}</td>
                                        <td> @if ($education_docs->verification_status=='pending')
                                            <a href="#" onclick="return changeDocumentStatus({{$education_docs->id}},'education')" class="btn btn-icon btn-active-info  btn-danger  mx-1 w-50px h-50px"> 
                                                <i class="fa fa-times"></i></a>                        
                                        @else                                            
                                        <button class="btn  btn-success mx-1 w-50px h-50px"> 
                                            <i class="fa fa-check"></i></button>
                                        @endif</td>
                                        <td> {{$education_docs->submitted_date ??''}}</td>
                                         <td> <a href="{{ url('storage/app/public'.'/'.$education_docs->doc_file) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                            <i class="fa fa-download"></i>
                                        </a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4"> <strong>Education Documents not Uploaded</strong> </td>
                                    </tr>
                                    @endforelse

                                </table>
                            </div>
                            <div class="tab-pane fade" id="v-pills-experience" role="tabpanel"
                            aria-labelledby="v-pills-experience-tab">
                            <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                <thead class="bg-primary p-10">
                                    
                                    <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="text-center text-white">Designation</th>
                                            <th class="text-center text-white">Status</th>
                                            <th class="text-center text-white">Uploaded Date</th>
                                            <th class="text-center text-white">Action</th>
                                          
                                        </tr>
                                       
                                    </thead>                                                                                 
                                @forelse ($experince_doc as $experince_docs )
                                <tr>
                                    <td> {{$experince_docs->designation->name ??''}}</td>
                                    <td> @if ($experince_docs->verification_status=='pending')
                                        <a href="#" onclick="return changeDocumentStatus({{$experince_docs->id}},'experience')" class="btn btn-icon btn-active-info  btn-danger  mx-1 w-50px h-50px"> 
                                            <i class="fa fa-times"></i></a>                        
                                    @else                                            
                                    <button class="btn  btn-success mx-1 w-50px h-50px"> 
                                        <i class="fa fa-check"></i></button>
                                    @endif</td>
                                    <td> {{$experince_docs->created_at ??''}}</td>
                                     <td> <a href=" {{ url('storage/app/public'.'/'.$experince_docs->doc_file) }}" class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                        <i class="fa fa-download"></i>
                                    </a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4"> <strong>Experience Documents not Uploaded</strong> </td>
                                </tr>
                                @endforelse

                            </table>
                        </div>
                            <div class="tab-pane fade" id="v-pills-leave" role="tabpanel"
                                aria-labelledby="v-pills-leave-tab">
                                <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                    <thead class="bg-primary p-10">
                                        
                                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="text-center text-white">Staff Name</th>
                                                <th class="text-center text-white">Leave Status</th>
                                                <th class="text-center text-white">Uploaded Date</th>
                                                <th class="text-center text-white">Action</th>
                                              
                                            </tr>
                                           
                                        </thead>                                                                                 
                                    @forelse ($leave_doc as $leave_docs )
                                    <tr>
                                        <td> {{$leave_docs->staff_info->name ??''}}</td>
                                        <td>{{ucfirst($leave_docs->status) ??''}}</td>
                                        <td> {{$leave_docs->created_at ??''}}</td>

                                         <td>
                                           @if ($leave_docs->status=='pending')
                                           <a href="{{ url('storage/app/public'.'/'.$leave_docs->document) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                            <i class="fa fa-download"></i>
                                        </a>                       
                                            @else                                            
                                            <a href="{{ url('storage/app/public'.'/'.$leave_docs->approved_document) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                                <i class="fa fa-download"></i>
                                            </a>
                                            @endif
                                        </td>
                                          
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4"> <strong>Leave Documents not Uploaded</strong> </td>
                                    </tr>
                                    @endforelse
    
                                </table>
                            </div>
                            <div class="tab-pane fade" id="v-pills-salary" role="tabpanel"
                                aria-labelledby="v-pills-salary-tab">eeeeeeeeeeeee</div>
                            <div class="tab-pane fade" id="v-pills-appointment" role="tabpanel"
                            aria-labelledby="v-pills-appointment-tab">
                            <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                <thead class="bg-primary p-10">
                                    
                                    <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="text-center text-white">Staff Name</th>
                                            <th class="text-center text-white">Employee Nature</th>
                                            <th class="text-center text-white">Joining Date</th>
                                            <th class="text-center text-white">Action</th>
                                          
                                        </tr>
                                       
                                    </thead>                                                                                 
                                @forelse ($appointment_doc as $appointment_docs )
                                <tr>
                                    <td> {{$appointment_docs->staff_det->name ??''}}</td>
                                    <td>{{ucfirst($appointment_docs->employment_nature->name ?? '')}}</td>
                                    <td> {{$appointment_docs->joining_date ??''}}</td>

                                    <td> <a href="{{ url('storage/app/public'.'/'.$appointment_docs->appointment_doc) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                        <i class="fa fa-download"></i>
                                    </a></td>
                                      
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4"> <strong>Appointment Documents not Uploaded</strong> </td>
                                </tr>
                                @endforelse

                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!--end::Card body-->

    <!--end::Card-->
@endsection

@section('add_on_script')
<script>
      function changeDocumentStatus(id,type) {

Swal.fire({
    text: "Are you sure you would like to change status?",
    icon: "warning",
    showCancelButton: true,
    buttonsStyling: false,
    confirmButtonText: "Yes, Change it!",
    cancelButtonText: "No, return",
    customClass: {
        confirmButton: "btn btn-danger",
        cancelButton: "btn btn-active-light"
    }
}).then(function(result) {
if (result.value) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ route('document_status') }}",
        type: 'POST',
        data: {
            id: id,
            type: type
        },
        success: function(res) {
            window.location.reload();
            Swal.fire({
                title: "Updated!",
                text: res.message,
                icon: "success",
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-success"
                },
                timer: 3000
            });

        },
        error: function(xhr, err) {
            if (xhr.status == 403) {
                toastr.error(xhr.statusText, 'UnAuthorized Access');
            }
        }
    });
}
});
}
</script>
@endsection
