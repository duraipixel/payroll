<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <!--begin::Card-->
    <div class="card">
        <div class="card-title">
            <h4 class="ms-10 mt-10"><strong>Search Staff</strong></h4>
        </div>

        <div class="row  pt-6 px-10">
            <div class="col-3 position-relative custom_select">
                <select class="form-select ms-4" id="staff_id" onchange="return showOptions();">
                    <option value="">Select Staff</option>
                    @foreach ($user as $users)
                        <option value="{{ $users->id }}">{{ $users->name }} - {{ $users->emp_code }}</option>
                    @endforeach

                </select>
            </div>

            <div class="col-3 custom_select">
                <select class="form-select ms-4" id="emp_nature_id">
                    <option value="">Nature Of Employment </option>
                    @foreach ($employee_nature as $employment_value)
                        <option value="{{ $employment_value->id }}">{{ $employment_value->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3 custom_select">
                <select class="form-select ms-4" id="work_place_id">
                    <option value="">Place of Work</option>
                    @foreach ($place_of_work as $work_value)
                        <option value="{{ $work_value->id }}">{{ $work_value->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-3">
                <button type="button" class="btn btn-primary ms-7" onclick="return search_dl();">Search</button>
            </div>
            <div class="invalid-feedback">
                Please select above any one
            </div>
        </div>

        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">

            <!--begin::Card title-->

            <div class="card-title">
                <h4 class="mt-5"><strong>Document Locker</strong></h4>
            </div>
            <div class="p-3 w-100 bg-light rounded">
                <div class="row gap-2 justify-content-around">
                    <div class="col-md-3 staff_count_dl">
                        <p class="ss_count_text">Total Number of Staff</p>
                        <p class="ss_count">{{ $user_count }} </p>
                        <img alt="Logo" src="{{ asset('assets/media/document/no_of_staff.png') }}"
                            class="logo document_images" />
                    </div>
                    <div class="col-md-3 staff_count_dl">
                        <p class="ss_count_text">Total Number of Documents Uploaded</p>
                        <p class="ss_count1">{{ $total_documents }} </p>
                        <img alt="Logo" src="{{ asset('assets/media/document/document_upload.png') }}"
                            class="logo document_images1" />
                    </div>
                    <div class="col-md-3 staff_count_dl ">
                        <p class="ss_count_text">Documents Review Pending </p>
                        <p class="ss_count1">{{ $review_pending_documents }} </p>
                        <img alt="Logo" src="{{ asset('assets/media/document/document_pending.png') }}"
                            class="logo document_images1" />
                    </div>
                </div>
            </div>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->


        <div class="card-body p-10" id="defalut_div">
            <div class="col-12">
                <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <table id="document_locker"
                        class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
                        style="width:100%">
                        <thead class="bg-primary">
                            <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="text-center text-white" style="width:85px;">Staff ID</th>
                                <th class="text-center text-white">Staff Name</th>
                                <th class="text-center text-white">Department</th>
                                <th class="text-center text-white">Designation</th>
                                <th class="text-center text-white">Total Documents</th>
                                <th class="text-center text-white">Aprroved Documents</th>
                                <th class="text-center text-white">Pending Documents</th>
                                <th class="text-center text-white">Action</th>
                            </tr>

                        </thead>
                        <tbody>

                            @foreach ($user as $users)
                                <tr>
                                    <td>{{ $users->emp_code }}</td>
                                    <td>{{ $users->name }}</td>
                                    <td>{{ $users->position->department->name ?? '' }}</td>
                                    <td>{{ $users->position->designation->name ?? '' }}</td>
                                    @php
                                        $total_doc = '';
                                        $total_doc = $users->staffDocuments->count() + $users->education->count() + $users->careers->count() + $users->leaves->count() + $users->appointmentCount->count();
                                        
                                        $pending_doc = '';
                                        $pending_doc = $users->staffDocumentsPending->count() + $users->staffEducationDocPending->count() + $users->staffExperienceDocPending->count() + $users->leavesPending->count();
                                        
                                        $approved_doc = '';
                                        $approved_doc = $users->staffDocumentsApproved->count() + $users->staffEducationDocApproved->count() + $users->staffExperienceDocApproved->count() + $users->leavesApproved->count() + $users->appointmentCount->count();
                                        
                                    @endphp

                                    <td>{{ $total_doc ?? '0' }}</td>
                                    <td>{{ $approved_doc ?? '0' }}</td>
                                    <td>{{ $pending_doc ?? '0' }}</td>

                                    <td><a href=" {{ route('user.dl_view', ['id' => $users->id]) }}"
                                            class="btn btn-icon btn-active-info btn-light-info mx-1 w-30px h-30px">
                                            <i class="fa fa-eye"></i>
                                        </a></td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div id="kt_dynamic_app"></div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@section('add_on_script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#document_locker').DataTable({
                "scrollX": true
            });
        });

        $('#staff_id').select2({
            selectOnClose: true
        });

        $('#emp_nature_id').select2({
            selectOnClose: true
        });
        $('#work_place_id').select2({
            selectOnClose: true
        });

        //Option value based on Staff name  start
        function showOptions() {

            var staff_id = $("#staff_id").val();

            if (staff_id == '') {
                window.location.reload();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('user.show_options') }}",
                type: 'POST',
                data: {
                    staff_id: staff_id,

                },
                success: function(res) {
                    if (res.place_of_work != '' && res.emp_nature) {
                        $('#emp_nature_id').empty();
                        $("#emp_nature_id").append('<option>Nature Of Employment</option>');
                        var id = res.emp_nature['id'];
                        var name = res.emp_nature['name'];
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#emp_nature_id").append(option);

                        $('#work_place_id').empty();
                        $("#work_place_id").append('<option>Place of Work</option>');
                        var id = res.place_of_work['id'];
                        var name = res.place_of_work['name'];
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#work_place_id").append(option);
                    } else {
                        $('#emp_nature_id').empty();
                        $("#emp_nature_id").append('<option>Nature Of Employment</option>');

                        $('#work_place_id').empty();
                        $("#work_place_id").append('<option>Place of Work</option>');

                    }
                }
            })
        }

        //Option value based on Staff name  start

        // Search Staff details Start

        function search_dl() {
            var staff_id = $("#staff_id").val();
            var emp_nature_id = $("#emp_nature_id").val();
            var work_place_id = $("#work_place_id").val();
            if (staff_id == '' && emp_nature_id == '' && work_place_id == '') {
                $(".invalid-feedback").show();
                return false;
            } else {
                $(".invalid-feedback").hide();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('user.search_staff') }}",
                    type: 'POST',
                    data: {
                        staff_id: staff_id,
                        emp_nature_id: emp_nature_id,
                        work_place_id: work_place_id,
                    },
                    success: function(res) {
                        $("#defalut_div").hide();
                        $('#kt_dynamic_app').html(res);
                    }
                })
            }

        }
        //Search Staff details End 
    </script>
@endsection
