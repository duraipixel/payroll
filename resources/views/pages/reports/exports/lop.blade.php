<table border="1">
    <thead>
           <tr>
    <th colspan="9" style="text-align: center;"> {{getInstituteName($institute_id)}}, PUDUCHERRY</th>
    </tr>
    <tr>
     <th colspan="9" style="text-align: center; text-transform: capitalize">Professional Tax REPORT FOR THE MONTH OF {{getMonthName($from_date)}}</th>
    </tr>
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
                                DESIGNATION
                            </th>
                            <th>
                           No. of days
                            </th> 
                             <th>
                             Gross Salary
                            </th> 
                             <th>
                             LOP Deduction Amount
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
              <td>{{$details['staff']->appointment->work_place->name ?? ''}}</td>
              <td>{{$details['staff']->appointment->joining_date ?? ''}}</td>
              <td>{{$details['staff']->institute_emp_code ?? ''}}</td>
              <td>{{$details['staff']->name ?? ''}}</td>
              <td>{{$details['staff']->appointment->designation->name?? ''}}</td>
               

              <td>{{$details->working_days ?? ''}}</td>
              <td>{{$details->gross_salary ?? ''}}</td>
              <td>{{($details->gross_salary/$details->working_days) ?? '00.00'}}</td>
              <td>{{$details->employee_description ?? ''}}</td>
             
              
                
          </tr>
          @endforeach
           @else 
                <tr>
                    <td> No  records </td>
                </tr>
            @endif
    </tbody>
</table>
