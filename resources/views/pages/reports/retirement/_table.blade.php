<table class="table m-0 table-striped table-bordered table-hover table-centered border rounded">
    <thead class="text-light border bg-primary">
        <tr>
            <th>S.No</th>
            <th>Staff Name</th>
            <th>Emp Code</th>
            <th>Designation</th>
            <th>DOB</th>
            <th>DOJ</th>
            <th>DOR</th>
            <th>Place of work</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->society_emp_code }}</td>
                <td>{{ $user->position?->designation?->name ?? 'NA' }}</td>
                <td>{{ $user?->personal?->dob ?? 'NA' }}</td>
                <td>{{ $user?->appointment?->joining_date ?? 'NA' }}</td>
                <td>{{ $user?->retirement?->last_working_date ?? 'NA' }}</td>
                <td>{{ $user?->appointment?->work_place?->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>