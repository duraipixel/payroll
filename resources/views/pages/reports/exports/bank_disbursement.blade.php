<table border="1">
    <thead>
         <tr>
    <th colspan="11" style="text-align: center;"> {{getInstituteName($institute_id)}}, PUDUCHERRY</th>
    </tr>
    <tr>
     <th colspan="11" style="text-align: center; text-transform: capitalize">Bank Disbursement REPORT FOR THE MONTH OF {{getMonthName($from_date)}}</th>
    </tr>
        <tr>
                             
                            <th>
                               BANK CODE
                            </th>
                             <th>
                               NET SALARY
                            </th>
                             <th>
                               DATE OF DISBURSEMENT
                            </th>
                             <th>
                              STAFF NAME 
                            </th>
                             <th>
                              STAFF ACCOUNT NO
                            </th>
                              <th></th><th></th>
                            <th>
                         SCHOOL ACCOUNT NO
                            </th> 
                            <th>REMARKS</th>
                             <th>
                           BULK UPLOAD REF CODE 
                            </th>     
        </tr>
    </thead>
    <tbody>
        @if (isset($data) && count($data)>0)
        @foreach($data as $details)
          <tr>
              <td>@if(isset($row['staff']->bank->bankDetails) && $details['staff']->bank->bankDetails->name=="AXIS BANK")
                           I
                      @else
                            N
                       
                   @endif</td>
              <td>{{$details->net_salary ?? ''}}</td>
              <td>{{$details->salary_date ?? ''}}</td>
              <td>{{$details['staff']->name ?? ''}}</td>
              <td>{{$details['staff']->bank->account_number ?? ''}}</td>
              <td></td><td></td><td></td><td></td>
               

              <td>{{$details['staff']->bank->bankBranch->ifsc_code ?? ''}}</td>
              <td>10</td>
             
              
                
          </tr>
          @endforeach
           @else 
                <tr>
                    <td> No  records </td>
                </tr>
            @endif
    </tbody>
</table>
