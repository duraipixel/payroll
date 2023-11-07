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
                                DESIGNATION
                            </th>
                             <th>
                               PAN
                            </th>
                             <th>
                               Actual Dedn
                            </th>
                             <th>
                               So far deducted
                            </th>
                             <th>
                              Amount deducted (current month)
                            </th>
                             <th>
                              Balance to be deducted
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
                <td>{{$details->pan_no?? ''}}</td>

              <td>{{$details->standard_deduction ?? ''}}</td>
              <td>{{$details->deduction_80c_amount ?? ''}}</td>
              <td>{{$details->total_deduction_amount ?? ''}}</td>
              <td>{{$details->gross_income ?? ''}}</td>
              
                
          </tr>
          @endforeach
           @else 
                <tr>
                    <td> No Payroll records </td>
                </tr>
            @endif
    </tbody>
</table>
