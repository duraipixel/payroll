<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .btn-info-blue {
            color: #00d6f7;
            background-color: #f9ffff;
            border-color: #17a2b8 !important;
        }
    </style>

    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <h3> Document Locker </h3>
            <button type="button" class="btn btn-info-blue">Locker No: #{{ $user->locker_no ?? '' }}</button>
        </div>
        <section>
            <div class="nav nav-tabs d-flex" style=" flex-wrap: inherit !important;" id="myTab" role="tablist">
                <button class="nav-link active p-5" id="v-pills-overview-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-overview" type="button" role="tab" aria-controls="v-pills-personal"
                    aria-selected="true">Overview</button>
                @if (count($personal_doc))
                    <button class="nav-link  p-5" id="v-pills-personal-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-personal" type="button" role="tab" aria-controls="v-pills-personal"
                        aria-selected="true">Personal Documents</button>
                @endif
                @if (count($education_doc))
                    <button class="nav-link  p-5" id="v-pills-education-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-education" type="button" role="tab" aria-controls="v-pills-education"
                        aria-selected="false">Education Documents</button>
                @endif
                @if (count($experince_doc))
                    <button class="nav-link  p-5" id="v-pills-experience-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-experience" type="button" role="tab"
                        aria-controls="v-pills-experience" aria-selected="false">Experience Documents</button>
                @endif
                @if (count($leave_doc))
                    <button class="nav-link  p-5" id="v-pills-leave-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-leave" type="button" role="tab" aria-controls="v-pills-leave"
                        aria-selected="false">Leave Documents</button>
                @endif
                @if (count($appointment_doc))
                    <button class="nav-link  p-5" id="v-pills-appointment-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-appointment" type="button" role="tab"
                        aria-controls="v-pills-appointment" aria-selected="false">Appointment Order</button>
                @endif
                @if (count($salary_doc))
                    <button class="nav-link  p-5" id="v-pills-salary-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-salary" type="button" role="tab" aria-controls="v-pills-salary"
                        aria-selected="false">Salary Slip</button>
                @endif
            </div>
            <div class="tab-content p-4 bg-white border" id="v-pills-tabContent">
                {{-- show active --}}
                <div class="tab-pane fade " id="v-pills-overview" role="tabpanel" aria-labelledby="vv-pills-overview-tab">
                    <table class="table">
                        <tbody>
                            @if (isset($user->name))
                                <tr>
                                    <th class="fw-bold text-primary">  Name </th>
                                    <td> : </td>
                                    <th class="fw-bold"> {{ $user->name }}</th>
                                </tr>
                            @endif
                            @if (isset($user->personal->gender))
                                <tr>
                                    <th class="fw-bold text-primary">  Gender </th>
                                    <td> : </td>
                                    <th class="fw-bold"> {{ ucfirst($user->personal->gender ?? '') }}</th>
                                </tr>
                            @endif
                            @if (isset($user->position->designation->name))
                                <tr>
                                    <th class="fw-bold text-primary">Designation</th>
                                    <td>:</td>
                                    <th class="fw-bold">{{ $user->position->designation->name ?? '' }}</th>
                                </tr>
                            @endif
                            @if (isset($user->personal->contact_address))
                                <tr>
                                    <th class="fw-bold text-primary">Address </th>
                                    <td>:</td>
                                    <th class="fw-bold">{{ ucfirst($user->personal->contact_address ?? '') }}</th>
                                </tr>
                            @endif
                            @if (isset($user->personal->phone_no))
                                <tr>
                                    <th class="fw-bold text-primary"> Mobile</th>
                                    <td>:</td>
                                    <th class="fw-bold">{{ $user->personal->phone_no ?? '' }}</th>
                                </tr>
                            @endif
                            @if (isset($user->personal->dob))
                                <tr>
                                    <th class="fw-bold text-primary"> DOB </th>
                                    <td>:</td>
                                    <th class="fw-bold">{{ $user->personal->dob ? commonDateFormat($user->personal->dob) : '' }}</th>
                                </tr>
                            @endif
                            @if (isset($user->email))
                                <tr>
                                    <th class="fw-bold text-primary">  Email </th>
                                    <td>:</td>
                                    <th class="fw-bold">{{ $user->email ?? '' }}</th>
                                </tr>
                            @endif
                            <tr>
                                <th class="fw-bold text-primary">Reporting Person </th>
                                <td>:</td>
                                <th class="fw-bold">admin</th>
                            </tr>
                            @if (isset($user->emp_code))
                                <tr>
                                    <th class="fw-bold text-primary"> Employee id </th>
                                    <td>:</td>
                                    <th class="fw-bold">
                                        {{ $user->society_emp_code }}
                                    </th>
                                </tr>
                            @endif

                            <tr>
                                <th class="fw-bold text-primary">    Reporting Person  </th>
                                <td>:</td>
                                <th class="fw-bold">
                                    Admin
                                </th>
                            </tr>
                            @if (isset($user->personal->marital_status))
                                <tr>
                                    <th class="fw-bold text-primary">Marital Status</th>
                                    <td>:</td>
                                    <th class="fw-bold">
                                        {{ ucfirst($user->personal->marital_status ?? '') }}
                                    </th>
                                </tr>
                            @endif
                            @if (isset($user->position->department->name))
                                <tr>
                                    <th class="fw-bold text-primary">Employee Department</th>
                                    <td>:</td>
                                    <th class="fw-bold">
                                        {{ $user->position->department->name ?? '' }}
                                    </th>
                                </tr>
                            @endif
                            @if (isset($user->appointment->joining_date))
                                <tr>
                                    <th class="fw-bold text-primary"> Employee Since </th>
                                    <td>:</td>
                                    <th class="fw-bold">
                                        @if (@isset($user->appointment->joining_date))
                                            {{ date('Y', strtotime($user->appointment->joining_date)) ?? '' }}
                                        @endif
                                    </th>
                                </tr>
                            @endif
                            <tr>
                                <th class="fw-bold text-primary">Total Experience</th>
                                <td>:</td>
                                <th class="fw-bold">
                                    {{-- 10 Years --}}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if (count($personal_doc))
                    <div class="tab-pane fade " id="v-pills-personal" role="tabpanel"
                        aria-labelledby="v-pills-personal-tab">
                        <table
                            class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                            <thead class="bg-primary p-10">
                                <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-center text-white ps-3">Document Name</th>
                                    <th class="text-center text-white"> Approval Status</th>
                                    <th class="text-center text-white"> Approved By</th>
                                    <th class="text-center text-white">Uploaded Date</th>
                                    <th class="text-center text-white">Action</th>
                                    <th class="text-center text-white pe-3">Download</th>
                                </tr>
                            </thead>
                            @forelse ($personal_doc as $personal_docs)
                                <tr>
                                    <td> {{ $personal_docs->documentType->name ?? '' }}</td>
                                    <td>
                                        @if ($personal_docs->verification_status == 'pending')
                                            <span class="badge badge-secondary"> Pending</span>
                                        @elseif ($personal_docs->verification_status == 'approved')
                                            <span class="badge badge-success">
                                                {{ ucfirst($personal_docs->verification_status) }}</span><br>
                                            {{ $personal_docs->approved_date ?? '' }}
                                        @elseif($personal_docs->verification_status == 'rejected')
                                            <span class="badge badge-danger">
                                                {{ ucfirst($personal_docs->verification_status) }}
                                            </span><br>
                                            {{ $personal_docs->rejected_date ?? '' }}
                                        @endif

                                    </td>
                                    <td> {{ $personal_docs->doc_approved_by->name ?? '' }}</td>
                                    <td> {{ $personal_docs->documentType->created_at ?? '' }}</td>

                                    <td>
                                        @if ($personal_docs->verification_status == 'pending' || $personal_docs->verification_status == 'rejected')
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $personal_docs->id }},'personal','approved')"
                                                class="btn btn-sm btn-success">
                                                <strong> Click to Approve</strong></a>
                                        @else
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $personal_docs->id }},'personal','rejected')"
                                                class="btn btn-sm btn-danger">
                                                <strong> Click to Reject</strong></a>
                                        @endif

                                    </td>
                                    <td>
                                        <a href="{{ url('storage/app/public' . '/' . $personal_docs->multi_file) }}"
                                            class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px"
                                            target="_blank" download>
                                            <i class="fa fa-download"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"> <strong>Personal Documents not Uploaded</strong> </td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                @endif
                @if (count($education_doc))
                    <div class="tab-pane fade" id="v-pills-education" role="tabpanel"
                        aria-labelledby="v-pills-education-tab">
                        <table
                            class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                            <thead class="bg-primary p-10">

                                <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-center text-white ps-3">Document Name</th>
                                    <th class="text-center text-white"> Approval Status</th>
                                    <th class="text-center text-white"> Approved By</th>
                                    <th class="text-center text-white">Uploaded Date</th>
                                    <th class="text-center text-white">Action</th>
                                    <th class="text-center text-white pe-3">Download</th>
                                </tr>
                            </thead>
                            @forelse ($education_doc as $education_docs)
                                <tr>
                                    <td> {{ $education_docs->course_name ?? '' }}</td>
                                    <td>
                                        @if ($education_docs->verification_status == 'pending')
                                            <span class="badge badge-secondary"> Pending</span>
                                        @elseif ($education_docs->verification_status == 'approved')
                                            <span class="badge badge-success">
                                                {{ ucfirst($education_docs->verification_status) }}</span><br>
                                            {{ $education_docs->approved_date ?? '' }}
                                        @elseif($education_docs->verification_status == 'rejected')
                                            <span class="badge badge-danger">
                                                {{ ucfirst($education_docs->verification_status) }}
                                            </span><br>
                                            {{ $education_docs->rejected_date ?? '' }}
                                        @endif

                                    </td>
                                    <td> {{ $education_docs->doc_approved_by->name ?? '' }}</td>
                                    <td> {{ $education_docs->submitted_date ?? '' }}</td>
                                    <td>
                                        @if ($education_docs->verification_status == 'pending' || $education_docs->verification_status == 'rejected')
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $education_docs->id }},'education','approved')"
                                                class="btn btn-sm btn-success">
                                                <strong> Click to Approve</strong></a>
                                        @else
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $education_docs->id }},'education','rejected')"
                                                class="btn btn-sm btn-danger">
                                                Click to Reject</a>
                                        @endif
                                    </td>
                                    <td> <a href="{{ url('storage/app/public' . '/' . $education_docs->doc_file) }}"
                                            class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px"
                                            target="_blank" download>
                                            <i class="fa fa-download"></i>
                                        </a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"> <strong>Education Documents not Uploaded</strong> </td>
                                </tr>
                            @endforelse

                        </table>
                    </div>
                @endif
                @if (count($experince_doc))
                    <div class="tab-pane fade" id="v-pills-experience" role="tabpanel"
                        aria-labelledby="v-pills-experience-tab">
                        <table
                            class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                            <thead class="bg-primary p-10">

                                <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-center text-white ps-3">Designation</th>
                                    <th class="text-center text-white"> Approval Status</th>
                                    <th class="text-center text-white"> Approved By</th>
                                    <th class="text-center text-white">Uploaded Date</th>
                                    <th class="text-center text-white">Action</th>
                                    <th class="text-center text-white pe-3">Download</th>
                                </tr>

                            </thead>
                            @forelse ($experince_doc as $experince_docs)
                                <tr>
                                    <td> {{ $experince_docs->designation->name ?? '' }}</td>

                                    <td>
                                        @if ($experince_docs->verification_status == 'pending')
                                            <span class="badge badge-secondary"> Pending</span>
                                        @elseif ($experince_docs->verification_status == 'approved')
                                            <span class="badge badge-success">
                                                {{ ucfirst($experince_docs->verification_status) }}</span><br>
                                            {{ $experince_docs->approved_date ?? '' }}
                                        @elseif($experince_docs->verification_status == 'rejected')
                                            <span class="badge badge-danger">
                                                {{ ucfirst($experince_docs->verification_status) }}
                                            </span><br>
                                            {{ $experince_docs->rejected_date ?? '' }}
                                        @endif

                                    </td>
                                    <td> {{ $experince_docs->doc_approved_by->name ?? '' }}</td>
                                    <td> {{ $experince_docs->created_at ?? '' }}</td>
                                    <td>
                                        @if ($experince_docs->verification_status == 'pending' || $experince_docs->verification_status == 'rejected')
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $experince_docs->id }},'experience','approved')"
                                                class="btn btn-sm btn-success">
                                                Click to Approve</a>
                                        @else
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $experince_docs->id }},'experience','rejected')"
                                                class="btn btn-sm btn-danger">
                                                Click to Reject</a>
                                        @endif
                                    </td>
                                    <td> <a href=" {{ url('storage/app/public' . '/' . $experince_docs->doc_file) }}"
                                            class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px"
                                            target="_blank" download>
                                            <i class="fa fa-download"></i>
                                        </a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"> <strong>Experience Documents not Uploaded</strong> </td>
                                </tr>
                            @endforelse

                        </table>
                    </div>
                @endif
                @if (count($leave_doc))
                    <div class="tab-pane fade" id="v-pills-leave" role="tabpanel" aria-labelledby="v-pills-leave-tab">
                        <table
                            class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                            <thead class="bg-primary p-10">

                                <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">


                                    <th class="text-center text-white ps-3">Leave Dates</th>
                                    <th class="text-center text-white">No of Days</th>
                                    <th class="text-center text-white">Approval Status</th>
                                    <th class="text-center text-white">Leave Approved By</th>
                                    <th class="text-center text-white">Action</th>
                                    <th class="text-center text-white pe-3">Download</th>
                                </tr>

                            </thead>
                            @forelse ($leave_doc as $leave_docs)
                                <tr>
                                    <td>{{ $leave_docs->from_date ?? '' }} to {{ $leave_docs->to_date ?? '' }}
                                    </td>
                                    <td>{{ $leave_docs->no_of_days ?? '' }}</td>
                                    <td>
                                        @if ($leave_docs->status == 'pending')
                                            <span class="badge badge-secondary"> Pending</span>
                                        @elseif ($leave_docs->status == 'approved')
                                            <span class="badge badge-success">
                                                {{ ucfirst($leave_docs->status) }}</span><br>
                                            {{ $leave_docs->approved_date ?? '' }}
                                        @elseif($leave_docs->status == 'rejected')
                                            <span class="badge badge-danger">
                                                {{ ucfirst($leave_docs->status) }} </span><br>
                                            {{ $leave_docs->rejected_date ?? '' }}
                                        @endif
                                    </td>
                                    <td> {{ $leave_docs->granted_info->name ?? '' }}</td>
                                    <td>
                                        @if ($leave_docs->status == 'pending' || $leave_docs->status == 'rejected')
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $leave_docs->id }},'leave','approved')"
                                                class="btn btn-sm btn-success">
                                                Click to Approve</a>
                                        @else
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $leave_docs->id }},'leave','rejected')"
                                                class="btn btn-sm btn-danger">
                                                Click to Reject</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($leave_docs->status == 'pending')
                                            <a href="{{ url('storage/app' . '/' . $leave_docs->document) }}"
                                                class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px"
                                                target="_blank" download>
                                                <i class="fa fa-download"></i>
                                            </a>
                                        @else
                                            <a href="{{ url('storage/app' . '/' . $leave_docs->approved_document) }}"
                                                class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px"
                                                target="_blank" download>
                                                <i class="fa fa-download"></i>
                                            </a>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"> <strong>Leave Documents not Uploaded</strong> </td>
                                </tr>
                            @endforelse

                        </table>
                    </div>
                @endif
                @if (count($appointment_doc))
                    <div class="tab-pane fade" id="v-pills-appointment" role="tabpanel"
                        aria-labelledby="v-pills-appointment-tab">
                        <table
                            class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                            <thead class="bg-primary p-10">

                                <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="text-center text-white">Appointment Model Name</th>
                                    <th class="text-center text-white">Employee Nature</th>
                                    <th class="text-center text-white">Joining Date</th>
                                    <th class="text-center text-white">Download</th>

                                </tr>

                            </thead>
                            @forelse ($appointment_doc as $appointment_docs)
                                <tr>
                                    <td> {{ $appointment_docs->appointmentOrderModel->name ?? '' }}</td>
                                    <td>{{ ucfirst($appointment_docs->employment_nature->name ?? '') }}</td>
                                    <td> {{ $appointment_docs->joining_date ?? '' }}</td>

                                    <td>
                                        @if ($appointment_docs->appointment_doc)
                                            <a href="{{ url('storage/app/public' . '/' . $appointment_docs->appointment_doc) }}"
                                                class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px"
                                                target="_blank" download>
                                                <i class="fa fa-download"></i>
                                            </a>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"> <strong>Appointment Documents not Uploaded</strong> </td>
                                </tr>
                            @endforelse

                        </table>
                    </div>
                @endif
                @if (count($salary_doc))
                    <div class="tab-pane fade" id="v-pills-salary" role="tabpanel" aria-labelledby="v-pills-salary-tab">

                        <table
                            class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                            <thead class="bg-primary p-10">

                                <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">


                                    <th class="text-center text-white ps-3">Gross Salary</th>
                                    <th class="text-center text-white">Deductions</th>
                                    <th class="text-center text-white">Approval Status</th>
                                    <th class="text-center text-white">Approved By</th>
                                    <th class="text-center text-white">Action</th>
                                    <th class="text-center text-white pe-3">Download</th>
                                </tr>

                            </thead>
                            @forelse ($salary_doc as $salary_docs)
                                <tr>
                                    <td>{{ $salary_docs->total_earnings ?? '' }} </td>
                                    <td>{{ $salary_docs->total_deductions ?? '' }}</td>
                                    <td>
                                        @if ($salary_docs->is_salary_processed == 'no' && $salary_docs->approved_date == '')
                                            <span class="badge badge-secondary"> Pending</span>
                                        @elseif ($salary_docs->is_salary_processed == 'yes' && $salary_docs->approved_date != '')
                                            <span class="badge badge-success">
                                                Approved</span><br>
                                            {{ $salary_docs->approved_date ?? '' }}
                                        @elseif ($salary_docs->is_salary_processed == 'no' && $salary_docs->rejected_date != '')
                                            <span class="badge badge-danger">
                                                Rejected</span><br>
                                            {{ $salary_docs->rejected_date ?? '' }}
                                        @endif
                                    </td>
                                    <td>{{ $salary_docs->salaryApprovedBy->name ?? '' }}</td>
                                    <td>
                                        @if ($salary_docs->is_salary_processed == 'no')
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $salary_docs->id }},'salary','approved')"
                                                class="btn btn-sm btn-success">
                                                Click to Approve</a>
                                        @else
                                            <a href="#"
                                                onclick="return changeDocumentStatus({{ $salary_docs->id }},'salary','rejected')"
                                                class="btn btn-sm btn-danger">
                                                Click to Reject</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($salary_docs->is_salary_processed == 'yes')
                                            <!-- <a href="{{ url('storage/app' . '/' . $leave_docs->document) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download>
                                                                        
                                                                    </a>      -->
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"> <strong>Salary Documents not Uploaded</strong> </td>
                                </tr>
                            @endforelse

                        </table>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <!--end::Card body-->

    <!--end::Card-->
@endsection

@section('add_on_script')
    <script>
        function changeDocumentStatus(id, type, status) {

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
                            type: type,
                            status: status
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
        navTabs = $('.nav-tabs')
        navTabs[0].firstElementChild.classList.add('active')
        tabContent = $('.tab-content')
        tabContent[0].firstElementChild.classList.add('show')
        tabContent[0].firstElementChild.classList.add('active')
        console.log(tabContent[0].firstElementChild.classList)
    </script>
@endsection
