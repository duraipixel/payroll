<div class="card-header border-0 pt-6">
    <div class="card-title">
        <div class="d-flex align-items-center position-relative my-1">
            {!! searchSvg() !!}
            <input type="text" data-kt-user-table-filter="search" id="salary_head_dataTable_search"
                class="form-control form-control-solid w-250px ps-14" placeholder="Search Staff Name">
        </div>
    </div>
    <div class="card-toolbar">
        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
            @php
                $route_name = request()
                    ->route()
                    ->getName();
            @endphp

            @if (access()->buttonAccess('holdsalary', 'add_edit'))
                <button type="button" class="btn btn-primary btn-sm" id="add_modal" onclick="addHoldSalary()">
                    {!! plusSvg() !!} Hold Salary
                </button>
            @endif

        </div>

    </div>
</div>

<div class="card-body py-4">
    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="table-responsive">
            <table class="table align-middle table-hover table-bordered table-striped fs-7 no-footer"
                id="hold_table">
                <thead class="bg-primary">
                    <tr class="text-start text-left text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th class="text-left text-white px-3">
                            Employee Code
                        </th>
                        <th class="text-left text-white  px-3">
                            Employee Name
                        </th>
                        <th class="text-left text-white  px-3">
                            Hold Salary Payout
                        </th>
                        <th class="text-left text-white  px-3">
                            Hold At
                        </th>
                        <th class="text-left text-white  px-3">
                            Hold Reason
                        </th>
                        <th class="text-left text-white px-3">
                            Remarks
                        </th>
                        <th class="text-left text-white  px-3">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody class="text-gray-600 fw-bold">
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    var dtTable = $('#hold_table').DataTable({

        processing: true,
        serverSide: true,
        order: [
            [0, "DESC"]
        ],
        type: 'POST',
        ajax: {
            "url": "{{ route('holdsalary.view') }}",
            "data": function(d) {
                d.datatable_search = $('#salary_head_dataTable_search').val();
                d.hold_date = '{{ $search_date }}';
            }
        },

        columns: [{
                data: 'staff.society_emp_code',
                name: 'staff.society_emp_code',
            },
            {
                data: 'staff.name',
                name: 'staff.name'
            },
            {
                data: 'current_salary_pattern',
                render: function(data) {
                    // console.log(data, 'data');
                    return data.net_salary || '';
                },
                name: 'current_salary_pattern'
            },
            {
                data: 'hold_month',
                name: 'hold_month'
            },
            {
                data: 'hold_reason',
                name: 'hold_reason'
            },
            {
                data: 'remarks',
                name: 'remarks'
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

    document.querySelector('#salary_head_dataTable_search').addEventListener("keyup", function(e) {
            dtTable.draw();
        }),

        $('#search-form').on('submit', function(e) {
            dtTable.draw();
            e.preventDefault();
        });
    $('#search-form').on('reset', function(e) {
        $('select[name=filter_status]').val(0).change();

        dtTable.draw();
        e.preventDefault();
    });
</script>
