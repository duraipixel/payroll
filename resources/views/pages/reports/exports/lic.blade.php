<table border="1">
    <thead>
        <tr>
                             
                            <th>
                                Place
                            </th>
                             <th>
                                DOJ
                            </th>
                             <th>
                                Emp ID
                            </th>
                             <th>
                                name
                            </th>
                              <th>
                               Policy No
                            </th>
                             <th>
                               Amount
                            </th>
                            <th>
                              Start Date
                            </th>
                            <th>
                               End Date
                            </th>
                            <th>
                              Sal Dedn Amount
                            </th>     
        </tr>
    </thead>
    <tbody>
        @if (isset($data) && count($data)>0)
        @foreach($data as $details)
          <tr>
              <td>{{$details['staff']->appointment->work_place->name ?? ''}}</td>
              <td>{{$details['staff']->appointment->joining_date ?? ''}}</td>
              <td>{{$details['staff']->institute_emp_code ?? ''}}</td>
              <td>{{$details['staff']->name ?? ''}}</td>
              <td>{{$details->StaffInsurance->policy_no ?? ''}}</td>
               <td>{{$details->StaffInsurance->amount ?? ''}}</td>
              <td>{{$details->StaffInsurance->start_date ?? ''}}</td>
              <td>{{$details->StaffInsurance->end_date ?? ''}}</td>
            <td>{{$details->amount ?? ''}}</td>
          </tr>
          @endforeach
           @else 
                <tr>
                    <td> No  records </td>
                </tr>
            @endif
    </tbody>
</table>
