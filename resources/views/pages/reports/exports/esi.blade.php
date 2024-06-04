<table border="1">
    <thead>
           <tr>
    <th colspan="6" style="text-align: center;"> {{getInstituteName($institute_id)}}, PUDUCHERRY</th>
    </tr>
    <tr>
     <th colspan="6" style="text-align: center; text-transform: capitalize">ESI  REPORT FOR THE MONTH OF {{getMonthName($from_date)}}</th>
    </tr>
        <tr>
                             
                             <th>
                               ESI No
                            </th>
                             <th>
                                NAME
                            </th>
                            <th>
                              No. of days
                            </th>
                             <th>
                             Total Gross (limit upto 21000)
                            </th>
                             <th>
                            Remarks
                            </th>
        </tr>
    </thead>
    <tbody>
        @if (isset($data) && count($data)>0)
        @foreach($data as $details)
          <tr>
              <td>{{$details['staff']->esi->ac_number ?? '-'}}</td>
               <td>{{$details['staff']->name ?? ' '}}</td>
                <td>{{$details->working_days}}</td>
                <td>{{ amountFormat(getStaffSalaryFieldAmount($details['staff']->id,$details->id, '',"Employees' State Insurance",'DEDUCTIONS'))}}</td>
                <td>{{$details->employee_description ?? ''}}</td>
          </tr>
          @endforeach
           @else 
                <tr>
                    <td> No Payroll records </td>
                </tr>
            @endif
    </tbody>
</table>
