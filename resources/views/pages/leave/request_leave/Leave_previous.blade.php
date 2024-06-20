@if( isset( $taken_leave ) && count( $taken_leave ) > 0 )
    <div class="table-wrap table-responsive popupresponse">
      <table id="leave_table_staff" class="table table-hover table-bordered" >
        <thead class="bg-dark text-white">
          <tr>
            <th>
              Date
            </th>
            @if(isset($taken_leave[0]->leave_days) && $taken_leave[0]->leave_days!='')
            <th>
              Day
            </th>
            @endif
            <th>
              Leave Type
            </th>
            <th>
              Leave Category
            </th>

          </tr>
        </thead>
        <tbody>
          @foreach ($taken_leave as $item)
          <tr>
            @if(isset($item->leave_days) && $item->leave_days!='')
            @foreach(json_decode($item->leave_days ?? []) as $key=>$day)
            @if(isset($day->check) && $day->check==1)
            <tr>

              <td >{{date('d/M/Y', strtotime($day->date))}}</td>
              <td >{{($day->type=='both')? 1 :0.5 }}</td>
              <td style="text-transform:capitalize;">{{$day->type}}</td>
              <td>{{ $item->leave_category }}</td>

              <tr>
                @endif
                @endforeach
                @else
                <td>
                  {{ commonDateFormat($item->from_date) .' - '. commonDateFormat($item->to_date) }}
                </td>
                <td>1</td>
                <td>Both</td>
                <td>
                  {{ $item->leave_category }}
                </td>

                @endif

              </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
        @endif