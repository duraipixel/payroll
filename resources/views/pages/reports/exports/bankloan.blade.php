<table border="1">
    <thead>
          <tr>
    <th colspan="12" style="text-align: center;"> {{getInstituteName($institute_id)}}, PUDUCHERRY</th>
    </tr>
    <tr>
     <th colspan="12" style="text-align: center; text-transform: capitalize">BANK LOAN REPORT FOR THE MONTH OF {{getMonthName($start_date)}}</th>
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
              <td>{{$details['staff']->firstAppointment->work_place->name ?? ''}}</td>
              <td>{{$details['staff']->firstAppointment->joining_date ?? ''}}</td>
              <td>{{$details['staff']->institute_emp_code ?? ''}}</td>
              <td>{{$details['staff']->name ?? ''}}</td>
              <td>{{$details['staff']->firstAppointment->designation->name?? ''}}</td>
               

              <td>{{$details->StaffLoan->bank_name ?? ''}}</td>
              <td>{{$details->StaffLoan->loan_ac_no ?? ''}}</td>
              <td>{{$details->StaffLoan->loan_start_date ?? ''}}</td>
              <td>{{$details->StaffLoan->loan_end_date ?? ''}}</td>
               <td>{{$details->StaffLoan->loan_amount ?? ''}}</td>
              <td>{{$details->StaffLoan->loan_end_date ?? ''}}</td>
              <td>{{$details->amount?? ''}}</td>
             
              
                
          </tr>
          @endforeach
           @else 
                <tr>
                    <td> No  records </td>
                </tr>
            @endif
    </tbody>
</table>
