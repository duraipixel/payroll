<table border="1">
    <thead>
         <tr>
    <th colspan="13" style="text-align: center;"> {{getInstituteName($institute_id)}}, PUDUCHERRY</th>
    </tr>
    <tr>
     <th colspan="13" style="text-align: center; text-transform: capitalize">EPF  REPORT FOR THE MONTH OF {{getMonthName($from_date)}}</th>
    </tr>
        <tr>
                       
                        <th>
                        UAN
                        </th>
                        <th >
                        MEMBER NAME
                        </th>
                        <th>
                        GROSS WAGES
                        </th>
                        <th>
                        EPF WAGES
                        </th>
                        <th>
                        EPS WAGES
                        </th>
                        <th>
                        EDLI WAGES
                        </th>
                        <th>
                        EPF CONTRI REMITTED
                        </th>
                        <th>
                        Total EPS Remitted
                        </th>
                        <th>
                        EPS CONTRI REMITTED
                        </th>
                        <th>
                        EPF EPS DIFF REMITTED
                        </th>
                        <th>
                        NCP DAYS
                        </th>
                        <th>
                        REFUND OF ADVANCES
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
              <td>{{$details['staff']->pf->ac_number ?? '-'}}</td>
               <td>{{$details['staff']->name ?? ' '}}</td>
                <td>{{amountFormat(getStaffSalaryFieldAmount($details['staff']->id,$details->id,'',"Employee Provident Fund",'DEDUCTIONS'))}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
