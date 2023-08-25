<table border="1">
    <thead>
        <tr>
            <th> S. No. </th>
            <th> Emp ID </th>
            <th> PLACE </th>
            <th> DOJ </th>
            <th> CS </th>
            <th> NAME </th>
            <th> DESIGNATION </th>
            <th> NAME / DESIGNATION </th>
            <th> BASIC </th>
            <th> BASICDA </th>
            <th> HRA </th>
            <th> TA </th>
            <th> PBA </th>
            <th> PBADA </th>
            <th> DSA </th>
            <th> MNA </th>
            <th> ARR </th>
            <th> OTHER </th>
            <th> BONUS </th>
            <th> GROSS </th>
            <th> EPF </th>
            <th> ESI </th>
            <th> LIC </th>
            <th> URBAN BANK LOAN </th>
            <th> CO-OP LOAN </th>
            <th> PERSONAL LOAN </th>
            <th> TAX (it) </th>
            <th> PROF. TAX </th>
            <th> CONTRIBUTION </th>
            <th> OTHER1 </th>
            <th> DED </th>
            <th> NET </th>
            <th> BANK (Yes / No) </th>
            <th> Bank Name </th>
            <th> ACCOUNT NO. </th>
            <th> Branch Code </th>
            <th> Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $index => $user)
            <tr>
                <td> {{ $index + 1 }} </td>
                <td> {{ $user->society_emp_code }} </td>
                <td> PLACE </td>
                <td>{{ $user?->appointment?->joining_date ?? '-' }} </td>
                <td> CS </td>
                <td> {{ $user->name }} </td>
                <td> {{ $user?->position?->designation?->name ?? '-' }} </td>
                <td> {{ $user->name }} / {{ $user?->position?->designation?->name ?? '-' }} </td>
                <td> BASIC </td>
                <td> BASICDA </td>
                <td> HRA </td>
                <td> TA </td>
                <td> PBA </td>
                <td> PBADA </td>
                <td> DSA </td>
                <td> MNA </td>
                <td> ARR </td>
                <td> OTHER </td>
                <td> BONUS </td>
                <td> GROSS </td>
                <td> EPF </td>
                <td> ESI </td>
                <td> LIC </td>
                <td> URBAN BANK LOAN </td>
                <td> CO-OP LOAN </td>
                <td> PERSONAL LOAN </td>
                <td> TAX (it) </td>
                <td> PROF. TAX </td>
                <td> CONTRIBUTION </td>
                <td> OTHER1 </td>
                <td> DED </td>
                <td>@if(count($user->salary)){{ $user?->salary[0]->net_salary }} @endif </td>
                <td> {{ $user->bank?->status == 'active' ? 'Yes' : 'No' }}</td>
                <td> {{ $user->bank?->bankDetails?->name }} </td>
                <td> {{ $user->bank?->account_number }} </td>
                <td> {{ $user->bank?->bankBranch?->name }} </td>
                <td> Remarks</td>
            </tr>
        @endforeach
    </tbody>
</table>
