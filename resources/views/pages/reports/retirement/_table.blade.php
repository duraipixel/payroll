<table class="table m-0 table-striped table-bordered table-hover table-centered border rounded">
    <thead class="text-light border bg-primary">
        <tr>
            <th>S.No</th>
            <th>Place</th>
            <th>DOB</th>
            <th>Emp ID</th>
            <th>NAME</th>
            <th>Designation</th>
            <th>Dt of Join</th>
            <th>Dt of RETIREMENT</th>
            <th>Reason</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->appointment->work_place->name ?? '' }}</td>
                 <td>{{ $user?->personal?->dob ?? 'NA' }}</td>
                <td>{{ $user->society_emp_code }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->position?->designation?->name ?? 'NA' }}</td>
               
                <td>{{ $user?->appointment?->joining_date ?? 'NA' }}</td>
                <td>{{ $user?->retirement?->last_working_date ?? 'NA' }}</td>
                <td>{{ $user?->retirement->reason?? '' }}</td>
                 <td>{{ $user?->retirement->reason??'' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>