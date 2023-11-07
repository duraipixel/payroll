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
                                Bank Name
                            </th>
                            <th>
                               Loan No
                            </th>
                            <th>
                               Loan start date
                            </th>
                            <th>
                               Loan availed
                            </th>
                            <th>
                                Amount
                            </th>
                             <th>
                                Instalment no
                            </th>
                             <th>
                                Balance due
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
               

              <td>{{$details->bank_name ?? ''}}</td>
              <td>{{$details->loan_ac_no ?? ''}}</td>
              <td>{{$details->loan_start_date ?? ''}}</td>
              <td>{{$details->loan_end_date ?? ''}}</td>
               <td>{{$details->loan_amount ?? ''}}</td>
              <td>{{$details->emione->staff_loan_id?? ''}}</td>
              <td>{{$details->emione->amount?? ''}}</td>
             
              
                
          </tr>
          @endforeach
           @else 
                <tr>
                    <td> No  records </td>
                </tr>
            @endif
    </tbody>
</table>
