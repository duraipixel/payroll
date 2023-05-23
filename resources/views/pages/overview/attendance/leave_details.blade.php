<div class="cursor-pointer">
    
    <div class="card-title m-0 mb-5">
        <h3 class="fw-bold m-0">Leave Details</h3>
    </div>

</div>

<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3" class="table align-middle gy-4">
        
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light">
                <th> Application No </th>
                <th> Leave Category </th>
                <th> Reason </th>
                <th> From </th>
                <th> To </th>
                <th> No of Leaves </th>
                <th> File </th>
                <th> Remarks </th>
                <th> Approved By </th>
                <th> Status </th>
            </tr>
        </thead>
    
        <tbody class="fs-6 fw-bold text-gray-600">
            @if (isset($info->leaves) && !empty($info->leaves))
                @foreach ($info->leaves as $item)
                    <tr>
                        <td>{{ $item->application_no }}</td>
                        <td>{{ $item->leave_category }}</td>
                        <td>{{ $item->reason }}</td>
                        <td>{{ commonDateFormat($item->from_date) }}</td>
                        <td>{{ commonDateFormat($item->to_date) }}</td>
                        <td>{{ $item->no_of_days }}</td>
                        <td>
                            @if (isset($item->approved_document) && !empty($item->approved_document))
                                {{-- <a href="{{ asset(Storage::url($item->approved_document)) }}" class="" target="_blank"> Download approved_document </a> --}}
                                <a href="{{ asset('public' . Storage::url($item->approved_document)) }}" class=""
                                    target="_blank"> Download File </a>
                            @else
                                <a href="javascript:void(0)"> No File Uploaded </a>
                            @endif
                        </td>
                        <td>{{ $item->remarks  }}</td>
                        <td>
                            @if( isset( $item->granted_info ) && !empty( $item->granted_info )) 
                                {{ $item->granted_info->name }}
                            @endif
                        </td>
                        <td>
                            {{ ucfirst($item->status) }}
                        </td>
                       
                    </tr>
                @endforeach
            @endif

        </tbody>
        
    </table>
</div>
