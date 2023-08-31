<table class="small table m-0 table-striped text-center table-bordered table-hover table-centered border rounded">
    <thead class="text-light border bg-primary">
        <tr>
            <th>S.No</th>
            <th>Staff Name</th>
            <th>Emp Code</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Leave Type</th>
            <th>Requested Date</th>
            <th>Leave From</th>
            <th>Leave To</th>
            <th>No Of Days</th>
            <th>Reason</th>
            <th>Status </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaves as $index => $leave)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $leave?->user->name }}</td>
                <td>{{ $leave?->user->society_emp_code }}</td>
                <td>{{ $leave?->user->position?->designation?->name ?? 'NA' }}</td>
                <td>{{ $leave?->user->position?->department?->name ?? 'NA' }}</td>
                <td>{{ $leave?->leave_category }}</td>
                <td>{{ $leave->created_at->format('Y-m-d') }}</td>
                <td>{{ $leave?->from_date }}</td>
                <td>{{ $leave?->to_date }}</td>
                <td>{{ $leave?->no_of_days }}</td>
                <td>{{ $leave?->reason }}</td>
                <td>{{ $leave?->status }} </td>
            </tr>
        @endforeach
    </tbody>
</table>