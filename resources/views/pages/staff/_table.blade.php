<table class="table m-0 table-striped table-bordered table-hover table-centered border rounded">
    <thead class="text-light border bg-primary">
        <tr>
            <th class="text-center"><small class="fw-bold">Staff Info</small></th>
            <th class="text-center"><small class="fw-bold">Society Code</small></th>
            <th class="text-center"><small class="fw-bold">Institution Code</small></th>
            <th class="text-center"><small class="fw-bold">Profile Completion</small></th>
            <th class="text-center"><small class="fw-bold">Status</small></th>
            <th class="text-center"><small class="fw-bold">Actions</small></th>
        </tr>
    </thead>
    <tbody class="border">
        @if (isset($post_data) && !empty($post_data))
            @foreach ($post_data as $item)
                @php
                    $edit_btn = $view_btn = $print_btn = $del_btn = '';
                    
                    $completed_percentage = getStaffProfileCompilationData($item, 'object');
                    $profile_status =
                        '
        <div class="d-flex align-items-center w-100px w-sm-200px flex-column mt-3">
            <div class="d-flex justify-content-between w-100 mt-auto">
                <span class="fw-semibold fs-6 text-gray-400">' .
                        ucwords($item->verification_status) .
                        '</span>
                <span class="fw-bold fs-6">' .
                        $completed_percentage .
                        '%</span>
            </div>
            <div class="h-5px mx-3 w-100 bg-light">
                <div class="bg-success rounded h-5px" role="progressbar" aria-valuenow="' .
                        $completed_percentage .
                        '" aria-valuemin="0" aria-valuemax="100" style="width: ' .
                        $completed_percentage .
                        '%;"></div>
            </div>
        </div>';
                    
                    $route_name = request()
                        ->route()
                        ->getName();
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn =
                            '<a href="' .
                            route('staff.register', ['id' => $item->id]) .
                            '"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
    <i class="fa fa-edit"></i>
    </a>';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn =
                            '<a href="javascript:void(0);" onclick="deleteStaff(' .
                            $item->id .
                            ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
    <i class="fa fa-trash"></i></a>';
                    }
                    
                    $view_btn =
                        '<a href="' .
                        route('staff.view', ['user' => $item->id]) .
                        '"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-30px h-30px" > 
                <i class="fa fa-eye"></i>
            </a>';
                    
                    $print_btn =
                        '<a target="_blank" href="' .
                        route('staff.print', ['user' => $item->id]) .
                        '"  class="btn btn-icon btn-active-info btn-light-dark mx-1 w-30px h-30px" > 
                <i class="fa fa-print"></i>
            </a>';
                    
                    $status_btn = '<a href="javascript:void(0);" class="badge badge-light-' . ($item->status == 'active' ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($item->status) . '" onclick="return staffChangeStatus(' . $item->id . ',\'' . ($item->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($item->status) . '</a>';
                    $actions = '<div class="w-100 text-end">' . $edit_btn . $view_btn . $print_btn . $del_btn . '</div>';
                @endphp
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->society_emp_code }}</td>
                    <td>{{ $item->institute_emp_code }}</td>
                    <td>{!! $profile_status !!}</td>
                    <td>
                        {!! $status_btn !!}
                    </td>
                    <td>{!! $actions !!}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
