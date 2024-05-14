<table border="1">
    <thead>
        <tr>
                             
                            <th>
                                Year
                            </th>
                             <th>
                                El Granded
                            </th>
                             <th>
                                EL Accumulated
                            </th>
                             <th>
                                EL Availed
                            </th>
                             <th>
                                EL Balance
                            </th>
                                 
        </tr>
    </thead>
    <tbody>
        @if (isset($data) && count($data)>0)
        @foreach($data as $details)
          <tr>
              <td>{{$details->calanderYear->year ?? ''}}</td>
              <td>{{$details->no_of_leave ?? ''}}</td>
               <td>{{$details->accumulated ?? ''}}</td>
              <td>{{$details->availed ?? ''}}</td>
              <td>{{$details->carry_forward_count ?? ''}}</td>
                
          </tr>
          @endforeach
           @else 
                <tr>
                    <td> No el records </td>
                </tr>
            @endif
    </tbody>
</table>
