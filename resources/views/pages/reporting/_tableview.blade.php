<div class="card-body py-4">
    <style>
        #reporting_tableview_table td {
            padding: 5px;
        }
    </style>
    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="table-responsive">
            <table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                id="reporting_tableview_table">
                <thead class="bg-primary">
                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">

                        <th class="px-3 text-white">
                            Emp Name
                        </th>
                        <th class="px-3 text-white">
                            Society Code
                        </th>
                        <th class="px-3 text-white">
                            Institution Code
                        </th>
                        <th class="px-3 text-white">
                            Having Staffs
                        </th>
                        <th class="px-3 text-white">
                            Having Managers
                        </th>
                        <th class="px-3 text-white">
                            Reportee
                        </th>
                        <th class="px-3 text-white">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody class="text-gray-600 fw-bold">
                    @if (isset($all) && !empty($all))
                        @foreach ($all as $item)
                        <tr>
                            <td>
                                {{ $item->manager->name}}
                            </td>
                            <td>
                                {{ $item->manager->society_emp_code}}
                            </td>
                            <td>
                                {{ $item->manager->institute_emp_code}}
                            </td>
                            <td class="text-center">
                                {{ $item->havingStaffs->count() }}
                            </td>
                            <td class="text-center">
                                {{ $item->havingManagers->count() }}
                            </td>
                            <td>
                                {{ $item->reportee->name }}
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm small" onclick="deleteManager({{$item->id}})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>
