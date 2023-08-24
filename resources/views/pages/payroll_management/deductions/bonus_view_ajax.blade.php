<div class="card-header border-0 pt-6">
    <style>
        #earings_table td {
            padding: 5px;
        }
    </style>

    <div class="card-title">
        <div class="d-flex align-items-center position-relative my-1">
            {!! searchSvg() !!}
            <input type="text" data-kt-user-table-filter="search" id="salary_head_dataTable_search"
                class="form-control form-control-solid w-250px ps-14" placeholder="Search here...">
        </div>
    </div>
    <div class="card-toolbar">
        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
            @php
                $route_name = request()
                    ->route()
                    ->getName();
            @endphp

            @if (access()->buttonAccess($route_name, 'add_edit'))
                <a href="{{ route('deductions.add', ['type' => $page_type, 'date' => $search_date ])}}"  class="btn btn-primary btn-sm">
                    {!! plusSvg() !!} {{ isset($has_data) && $has_data > 0 ? 'Update ' : '' }} {{ $title }}
                </a>
            @endif

        </div>

    </div>
</div>

<div class="card-body py-4">
    <input type="hidden" name="page_type" id="page_type" value="{{ $page_type }}">
    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="table-responsive">
            <table class="table align-middle table-hover table-bordered table-striped fs-7 no-footer"
                id="earings_table">
                <thead class="bg-primary">
                    <tr class="text-start text-left text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th class="text-left text-white px-3">
                            Employee Code
                        </th>
                        <th class="text-left text-white  px-3">
                            Employee Name
                        </th>
                        <th class="text-left text-white  px-3">
                            Salary Month
                        </th>
                        <th class="text-left text-white  px-3">
                            Bonus Amount
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
    var dtTable = $('#earings_table').DataTable({

        processing: true,
        serverSide: true,
        order: [
            [0, "DESC"]
        ],
        type: 'POST',
        ajax: {
            "url": "{{ route('deductions.table.view') }}",
            "data": function(d) {
                d.datatable_search = $('#salary_head_dataTable_search').val();
                d.hold_date = '{{ $search_date }}';
                d.page_type = $('#page_type').val();
            }
        },
        columns: [
            {
                data: 'staff.society_emp_code',
                name: 'staff.society_emp_code',
            },
            {
                data: 'staff.name',
                name: 'staff.name'
            },
            {
                data: 'salary_month',
                name: 'salary_month'
            },
            {
                data: 'amount',
                name: 'amount'
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
        "pageLength": 25
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
