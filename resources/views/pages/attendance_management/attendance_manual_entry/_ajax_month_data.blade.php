<div class="card">
    <style>
        #attendance_manual_entry_table td {
            padding-left: 10px;
        }
.btn:not(.btn-outline):not(.btn-dashed):not(.border-hover):not(.border-active):not(.btn-flush):not(.btn-icon) {
  border: 0;
     padding: 1rem 1rem  !important;
}
    </style>
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                {!! searchSvg() !!}
                <input type="text" data-kt-user-table-filter="search" id="leave_mapping_dataTable_search"
                    class="form-control form-control-solid w-250px ps-14" placeholder="Search Attendance Manual Entry">
            </div>
            <div class="mx-2">
                <select name="attendance_status" id="attendance_status" class="form-control">
                    <option value="">Select Attendance Status</option>
                    <option value="Present">Present</option>
                    <option value="Absence">Absence</option>
                </select>
            </div>
            <div class="mx-2">
            <input type="date" class="form-control" name="a_date"
                value="" id="a_date" required>
             </div>
             <div class="mx-2">
             <button type="button" class="btn btn-primary" id="generate">
                       Generate
            </button>
            </div>
            <div class="mx-2">
                @php
                    $route_name = request()
                        ->route()
                        ->getName();
                @endphp
                @if (access()->buttonAccess('att-manual-entry', 'export'))
                    <a type="button" class="btn btn-light-primary me-3" href="{{ route('att-manual-entry.export') }}">
                        {!! exportSvg() !!}Export
                    </a>
                @endif
                </div>
                <div class="mx-2">
                @if (access()->buttonAccess('att-manual-entry', 'add_edit'))
                    <button type="button" class="btn btn-primary" id="add_modal" onclick="getLeaveMappingModal()">
                        {!! plusSvg() !!} Add Entry
                    </button>
                @endif

            </div>
        </div>
   
       </br>
       
       
        <div class="card-title">
            <label>From date</label>
             <input type="date" id="from_date"
            class="form-control form-control-solid w-250px ps-14">
            <label>To date</label>
            <input type="date" id="to_date"
            class="form-control form-control-solid w-250px ps-14" placeholder="To date">
       </div>
        <!--end::Card toolbar-->
    </div>

    <div class="card-body py-4">
        <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="table-responsive">
                <table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                    id="attendance_manual_entry_table">
                    <thead class="bg-primary">
                        <tr class="text-start  text-muted fw-bolder fs-7 text-uppercase gs-0">
                            
                            <th class=" text-white px-2">
                                Attendance Date
                            </th>
                            <th class=" text-white px-2">
                                Staff Name
                            </th>
                            <th class=" text-white px-2">
                                Staff Code
                            </th>
                            <th class=" text-white px-2">
                            Designation
                            </th>
                            <th class=" text-white px-2">
                            Profile
                            </th>
                            <th class=" text-white px-2">
                                From Time
                            </th>
                            <th class=" text-white px-2">
                                To Time
                            </th>
                          
                            <th class=" text-white px-2">
                                Attendance Status
                            </th>
                            <th class=" text-white px-2">
                                Reason
                            </th>
                             <th class=" text-white px-2 w-200px">
                                Leave Status
                            </th>
                            <th class=" text-white px-2 w-200px">
                                Leave Type
                            </th>
                            <th class=" text-white px-2">
                                Status
                            </th>
                            <th class="text-center text-white px-2">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-600 fw-bold">
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!--end::Card body-->
</div>



<script>
// $(document).ready(function() {
//     $('#attendance_status').select2({
//         width: '100%' ,
//         placeholder: 'Select an Attendance Status',
//         theme: 'bootstrap-5',
//     });
// });
    var dtTable = $('#attendance_manual_entry_table').DataTable({

        processing: true,
        serverSide: true,
        order: [
            [0, "DESC"]
        ],
        type: 'POST',
        ajax: {
            "url": "{{ route('attendance.ajax.datatable') }}",
            "data": function(d) {
                d.datatable_search = $('#leave_mapping_dataTable_search').val();
                d.dates = '{{ $dates }}';
                d.attendance_status = $('#attendance_status').val();
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },

        columns: [
            {
                data: 'attendance_date',
                name: 'attendance_date',defaultContent:''
            },
            {
                data: 'staff_name',
                name: 'staff_name',defaultContent:''
            },
            {
                data: 'institute_emp_code',
                name: 'institute_emp_code',defaultContent:''
            },
            {
                data: 'Designation',
                name: 'Designation',defaultContent:''
            },
            {
                data: 'Profile',
                name: 'Profile',defaultContent:''
            },
            {
                data: 'from_time',
                name: 'from_time',defaultContent:''
            },
            {
                data: 'to_time',
                name: 'to_time',defaultContent:''
            },
           
            {
                data: 'attendance_status',
                name: 'attendance_status',defaultContent:''
            },
            {
                data: 'reason',
                name: 'reason',defaultContent:''
            },
            {
                data: 'leave_status',
                name: 'leave_status',defaultContent:''
            },{
                data: 'leave_type',
                name: 'leave_type',defaultContent:''
            },
            {
                data: 'status',
                name: 'status',defaultContent:''
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        language: {
            paginate: {
                next: '<i class="fa fa-angle-right"></i>', // or '→'
                previous: '<i class="fa fa-angle-left"></i>' // or '←' 
            }
        },
        "aaSorting": [],
        "pageLength": 25,
        "aLengthMenu": [
                [25, 50, 100, 200, 500, -1],
                [25, 50, 100, 200, 500, "All"]
            ]
    });

    $('.dataTables_wrapper').addClass('position-relative');
    $('.dataTables_info').addClass('position-absolute');
    $('.dataTables_filter label input').addClass('form-control form-control-solid w-250px ps-14');
    $('.dataTables_filter').addClass('position-absolute end-0 top-0');
    $('.dataTables_length label select').addClass('form-control form-control-solid');

    document.querySelector('#leave_mapping_dataTable_search').addEventListener("keyup", function(e) {
            dtTable.draw();
        }),

        $('#search-form').on('submit', function(e) {
            dtTable.draw();
            e.preventDefault();
        });

    document.querySelector('#attendance_status').addEventListener("change", function(e){
        dtTable.draw();
    })
    $('#search-form').on('reset', function(e) {
        $('select[name=filter_status]').val(0).change();

        dtTable.draw();
        e.preventDefault();
    });
    $('#from_date, #to_date').on('change', function(e) {
        dtTable.draw();
        e.preventDefault();
    });

    function getLeaveMappingModal(id = '') {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formMethod = "addEdit";
        $.ajax({
            url: "{{ route('att-manual-entry.add_edit') }}",
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

    function leaveMappingStatusChangeStatus(id, status) {

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
                    url: "{{ route('att-manual-entry.change.status') }}",
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

    function deleteLeaveMappingStatus(id) {
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
                    url: "{{ route('att-manual-entry.delete') }}",
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
          $('#generate').on('click',function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('attendance.manual.trigger') }}",
                    type: 'POST',
                    data: {
                    date:$('#a_date').val(),
                    },beforeSend:function() {
                    loading();
                    },
                    success: function(res) {
                    unloading();
                        dtTable.ajax.reload();
                    },
                    error: function(xhr, err) {
                        unloading();
                      
                    }
                });
            

    })
</script>
