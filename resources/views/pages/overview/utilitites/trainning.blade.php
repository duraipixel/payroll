
<div class="cursor-pointer">
    <div class="card-title m-0 mb-5">
        <h3 class="fw-bold m-0">Training Details</h3>
    </div>
</div>
<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3" class="table align-middle gy-4">
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light">
                <th>Training Topic</th>
                <th>Trainer Name</th>
                <th>Training Date</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @if( isset($info->training) && !empty( $info->training ) )
                @foreach ($info->training as $item)
                    <tr>
                        <td>{{ $item->topics->name }}</td>
                        <td>{{ $item->trainer_name}}</td>
                        <td>{{ commonDateFormat($item->from). ' - '. commonDateFormat($item->to) }}</td>
                        <td>{{ $item->remarks }}</td>
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