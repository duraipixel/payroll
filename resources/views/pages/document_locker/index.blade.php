<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
<style>
    .typeahead-pane {
        position: absolute;
        width: 100%;
        background: #ffffff;
        margin: 0;
        padding: 0;
        border-radius: 6px;
        box-shadow: 1px 2px 3px 2px #ddd;
        z-index: 1;
    }

    .typeahead-pane-ul {
        width: 100%;
        padding: 0;
    }

    .typeahead-pane-li {
        padding: 8px 15px;
        width: 100%;
        margin: 0;
        border-bottom: 1px solid #2e3d4638;

    }

    .typeahead-pane-li:hover {
        background: #3a81bf;
        color: white;
        cursor: pointer;
    }

    #input-close {
        position: absolute;
        top: 11px;
        right: 15px;
    }

    .daterangepicker.show-calendar .ranges {
        height: 0;
    }
</style>
    <!--begin::Card-->
    <div class="card" >
        <div class="card-title">
            <h4 class="ms-10 mt-10"><strong>Search Staff</strong></h4>
        </div>

        <div class="row  pt-6 px-10">
            <div class="col-3 position-relative"  id="typeahed-click">
                <!--end::Svg Icon-->

                <input type="text" name="staff_name" value=""
                id="staff_name" class="form-control" placeholder="Search Name or Staff ID">
            <span id="input-close" class="d-none">
                {!! cancelSvg() !!}
            </span>
           
            <div class="typeahead-pane d-none" id="typeadd-panel">
                <ul type="none" class="typeahead-pane-ul" id="typeahead-list">

                </ul>
            </div>
                          
            </div>
            <div class="col-2">
                <select class="form-select ms-4" id="search_institutions"  >
                    <option value="">Institutions</option>
                    @foreach ($institution as $ins_value)
                        <option value="{{$ins_value->id}}">{{$ins_value->name}}</option>                        
                    @endforeach
                   
                </select>
              
            </div>
         
            <div class="col-2">
                <select class="form-select ms-4" id="search_institutions " >
                    <option value="">Department </option>
                    @foreach ($department as $department_value)
                        <option value="{{$department_value->id}}">{{$department_value->name}}</option>                        
                    @endforeach
                </select>
          </div>
            <div class="col-2">
                <select class="form-select ms-4" id="search_institutions "  >
                    <option value="">Designation</option>
                    @foreach ($designation as $desig_value)
                        <option value="{{$desig_value->id}}">{{$desig_value->name}}</option>                        
                    @endforeach
                </select>
          </div>
        
      <div class="col-2">
        <button type="button" class="btn btn-primary ms-7">Search</button>
  </div>
        </div>

        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
             
            <!--begin::Card title-->
           
            <div class="card-title">
                <h4 class="mt-5"><strong>Document Locker</strong></h4>
            </div>
            <div class="count_deatils mt-5">
                <div class="row m-0">
                    <div class="col-md-3 staff_count_dl">
                        <p class="ss_count_text">Total Number of Staff</p>
                        <p class="ss_count">{{$user_count}} </p>
                        <img alt="Logo" src="{{ asset('assets/media/document/no_of_staff.png') }}"
                        class="logo document_images" />
                    </div>                    
                    <div class="col-md-3 staff_count_dl">
                        <p class="ss_count_text">Total Number of Documents Uploaded</p>
                        <p class="ss_count1">{{$total_documents}} </p>
                        <img alt="Logo" src="{{ asset('assets/media/document/document_upload.png') }}"
                        class="logo document_images1" />
                    </div>
                    <div class="col-md-3 staff_count_dl ">
                        <p class="ss_count_text">Documents Review Pending </p>
                        <p class="ss_count1">{{$review_pending_documents}} </p>
                        <img alt="Logo" src="{{ asset('assets/media/document/document_pending.png') }}"
                        class="logo document_images1" />
                    </div>
                </div>
            </div>
        </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            

        <div class="card-body p-10">
            <div class="col-12">
                <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                      <table id="document_locker" class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
                      style="width:100%">
                      <thead class="bg-primary">
                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="text-center text-white" style="width:85px;">Staff  ID</th>
                                <th class="text-center text-white">Staff Name</th>
                                <th class="text-center text-white">Department</th>
                                <th class="text-center text-white">Designation</th>
                                <th class="text-center text-white">Total Documents</th>                                
                                <th class="text-center text-white">Aprroved Documents</th>
                                <th  class="text-center text-white">Pending Documents</th>
                                <th  class="text-center text-white">Action</th>
                            </tr>
                           
                        </thead>
                        <tbody>
                           
                                @foreach ($user as $users )
                                <tr>
                                <td>{{$users->emp_code}}</td>
                                <td>{{$users->name}}</td>
                                <td>{{$users->position->department->name ??''}}</td>
                                <td>{{$users->position->designation->name ??''}}</td>                                             
                                @php                                  
                                    $total_doc='';
                                    $total_doc=$users->staffDocuments->count()+$users->education->count()+
                                    $users->careers->count()+$users->leaves->count()+$users->appointmentCount->count(); 
                                    
                                    $pending_doc='';
                                    $pending_doc=$users->staffDocumentsPending->count()+$users->staffEducationDocPending->count()+
                                    $users->staffExperienceDocPending->count()+$users->leavesPending->count();

                                    $approved_doc='';
                                    $approved_doc=$users->staffDocumentsApproved->count()+$users->staffEducationDocApproved->count()+
                                    $users->staffExperienceDocApproved->count()+$users->leavesApproved->count()+$users->appointmentCount->count();
                                    
                                @endphp

                                <td>{{ $total_doc ?? '0'}}</td>
                                <td>{{$approved_doc ?? '0'}}</td>
                                <td>{{$pending_doc?? '0'}}</td>
                               
                                <td><a href=" {{route('user.dl_view', ['id' => $users->id])}}" class="btn btn-icon btn-active-info btn-light-info mx-1 w-30px h-30px"> 
                                    <i class="fa fa-eye"></i>
                                </a></td>
                                
                            </tr>
                                @endforeach
                                
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endsection

@section('add_on_script')

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script>   


$(document).ready(function () {
    $('#document_locker').DataTable({   
        "scrollX": true
    });
});
  /*var route = "{{ url('autocomplete-search') }}";
        $('#staff_name_id').typeahead({
            source: function (query, process) {
                return $.get(route, {
                    query: query
                }, function (data) {
                    console.log(data);
                    //var details=data[name]+'-'+data[emp_code]; console.log(details);
                    return process(data);
                });
            }
        });
*/

        window.addEventListener('click', function(e) {
        if (document.getElementById('typeahed-click').contains(e.target)) {
            // Clicked in box
        } else {
            // Clicked outside the box
            $('#typeadd-panel').addClass('d-none');
            // $('#staff_name').val('');
            // $('#staff_id').val('');
            // $('#staff_code').val('');
            // $('#designation').val('');
        }
    });

    var staff_name = document.getElementById('staff_name');

    staff_name.addEventListener('keyup', function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('get.staff') }}",
            type: 'POST',
            data: {
                query: this.value,
            },
            success: function(res) {
                console.log(res);
                if (res && res.length > 0) {
                    $('#typeadd-panel').removeClass('d-none');
                    let panel = '';
                    res.map((item) => {
                        panel +=
                            `<li class="typeahead-pane-li">${item.name} - ${item.emp_code}</li>`;
                    })
                    $('#typeahead-list').html(panel);

                } else {
                    $('#typeadd-panel').addClass('d-none');

                }
            }
        })
    })



 
 var dtTable = $('#staff_table_data').DataTable({

processing: true,
serverSide: true,
type: 'POST',
ajax: {
    "url": "{{ route('user.document_locker') }}",
    "data": function(d) {
      //  console.log(d);
       // d.datatable_search = $('#staff_datable_search').val();
    }
},

columns: [{
        data: 'name',
        name: 'name'
    },
    {
        data: 'email',
        name: 'email'
    },
    {
        data: 'verification_status',
        name: 'verification_status'
    },
    {
        data: 'status',
        name: 'status'
    }
  
    // {
    //     data: 'action',
    //     name: 'action',
    //     orderable: false,
    //     searchable: false
    // },
],
language: {
    paginate: {
        next: '<i class="fa fa-angle-right"></i>', // or '→'
        previous: '<i class="fa fa-angle-left"></i>' // or '←' 
    }
},
"aaSorting": [],
"pageLength": 25
});

$('.dataTables_wrapper').addClass('position-relative');
$('.dataTables_info').addClass('position-absolute');
$('.dataTables_filter label input').addClass('form-control form-control-solid w-250px ps-14');
$('.dataTables_filter').addClass('position-absolute end-0 top-0');
$('.dataTables_length label select').addClass('form-control form-control-solid');

/*document.querySelector('#staff_datable_search').addEventListener("keyup", function(e) {
    dtTable.draw();
}),*/

$('#search-form').on('submit', function(e) {
    dtTable.draw();
    e.preventDefault();
});
$('#search-form').on('reset', function(e) {
$('select[name=filter_status]').val(0).change();

dtTable.draw();
e.preventDefault();
});

        function institutionChangeStatus(id, status) {

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
                        url: "{{ route('institutions.change.status') }}",
                        type: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function(res) {
                            dtTable.ajax.reload();
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

        $('#kt_common_add_form').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        function getInstituteModal( id = '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('institutions.add_edit') }}",
                type: 'POST',
                data: {
                    id: id,
                },
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })

        }

        function deleteInstitution(id) {
            Swal.fire({
                text: "Are you sure you would like to delete record?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, Delete it!",
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
                        url: "{{ route('institutions.delete') }}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(res) {
                            dtTable.ajax.reload();
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
