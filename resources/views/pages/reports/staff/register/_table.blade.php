<table class="table m-0 table-striped table-bordered table-hover table-centered border rounded">
    <thead class="text-light border bg-primary">
        <tr>
            <th width="30">S.No</th>
            <th>Staff Name</th>
            <th>Department</th>
            <th>Staff Name (Tamil)</th>
            <th>Institute emp code</th>
            <th>Society emp code</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $index => $user)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->position?->department?->name ?? 'NA' }}</td>
                <td>{{ $user->first_name_tamil ?? "-" }}</td>
                <td>{{ $user->institute_emp_code }}</td>
                <td>{{ $user->society_emp_code }}</td>
            </tr>
        @endforeach
    </tbody>
</table>