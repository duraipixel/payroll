
<div class="cursor-pointer">
    <div class="card-title m-0 mb-5">
        <h3 class="fw-bold m-0">Insurance Details</h3>
    </div>
</div>
<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3" class="table align-middle gy-4">
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light">
                <th>Insurance</th>
                <th>Policy No</th>
                <th>Maturity Date</th>
                <th>Amount</th>
                <th>Completed Date</th>
                <th>Document</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($info->insurance) && !empty($info->insurance))
                @foreach ($info->insurance as $item)
                    <tr>
                        <td>{{ $item->insurance_name }}</td>
                        <td>{{ $item->policy_no }}</td>
                        <td>{{ commonDateFormat($item->maturity_date) }}</td>
                        <td>₹ {{ $item->amount }}</td>
                        <td>{{ $item->completed_date ? commonDateFormat($item->completed_date) : '' }}</td>
                        <td>
                            @if (isset($item->file) && !empty($item->file))
                                {{-- <a href="{{ asset(Storage::url($item->file)) }}" class="" target="_blank"> Download File </a> --}}
                                <a href="{{ asset('public' . Storage::url($item->file)) }}" class=""
                                    target="_blank"> Download File </a>
                            @else
                                <a href="javascript:void(0)"> No File Uploaded </a>
                            @endif
                        </td>
                        <td>{{ ucfirst($item->status) }}</td>
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