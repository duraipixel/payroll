
<div class="cursor-pointer">
    <div class="card-title m-0 mb-5">
        <h3 class="fw-bold m-0">Invigilation Details</h3>
    </div>
</div>
<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3" class="table align-middle gy-4">
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light">
                <th>Duty School</th>
                <th>Duty Place</th>
                <th>Duty Class</th>
                <th>Duty Type</th>
                <th>Duty Date</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @if( isset($info->invigilation) && !empty( $info->invigilation ) )
                @foreach ($info->invigilation as $item)
                    <tr>
                        <td>{{ $item->school->name }}</td>
                        <td>{{ $item->place->name }}</td>
                        <td>{{ $item->classes->name }}</td>
                        <td>{{ $item->dutyType->name }}</td>
                        <td>{{ commonDateFormat($item->from_date). ' - '. commonDateFormat($item->to_date) }}</td>
                        <td>{{ $item->facility }}</td>
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