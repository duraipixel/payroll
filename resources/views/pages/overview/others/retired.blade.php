

<div class="cursor-pointer">
    <div class="card-title m-0 mb-5">
        <h3 class="fw-bold m-0">Retired/Resigned Details</h3>
    </div>
</div>
<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3" class="table align-middle gy-4">
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light">
                <th>Last Working Date</th>
                <th>Type</th>
                <th>Reason</th>
                <th>document</th>
                
            </tr>
        </thead>
        <tbody>
            @if( isset($retired) && !empty( $retired) )
                @foreach ($retired as $retired_data)
                    <tr>
                        <td>{{ $retired_data->last_working_date }}</td>
                        <td style=" text-transform: capitalize;">{{ $retired_data->types }}</td>
                        <td>{{ $retired_data->reason }}</td>
                         <td> <a href="{{ url('storage/app/public' . '/' . $retired_data->document) }}"
                                            class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px"
                                            target="_blank" download>
                                            <i class="fa fa-download"></i></a></td>
                       
                    </tr>
                @endforeach
            @else 
            <tr>
                <td colspan="6" class="text-center"> No records</td>
            </tr>
            @endif
        </tbody>
        
    </table>
</div>