<table class="table m-0 table-striped table-bordered table-hover table-centered border rounded">
    <thead class="text-light border bg-primary">
        <tr>
            <th width="30">S.No</th>
            <th>Staff Name</th>
            <th>Departemnt</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->position?->department?->name ?? 'NA' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>