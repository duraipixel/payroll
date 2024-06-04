<table border="1">
    <thead>
        <tr>
    <th colspan="9" style="text-align: center;"> {{getInstituteName($institute_id)}}, PUDUCHERRY</th>
    </tr>
    <tr>
     <th colspan="9" style="text-align: center; text-transform: capitalize">RESIGNED REPORT FOR THE MONTH OF {{getMonthName($from_date)}}</th>
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
                                Dt of Join
                            </th>
                           
                          
                             <th >
                                Dt of resign
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
               

              <td>{{$details['staff']->appointment->joining_date}}</td>
                <td>{{$details->last_working_date ?? ''}}</td>
              <td>{{$details->reason ?? ''}}</td>
             
              
                
          </tr>
          @endforeach
           @else 
                <tr>
                    <td> No  records </td>
                </tr>
            @endif
    </tbody>
</table>
