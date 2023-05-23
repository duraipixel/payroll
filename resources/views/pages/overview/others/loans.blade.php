

<div class="cursor-pointer">
    <div class="card-title m-0 mb-5">
        <h3 class="fw-bold m-0">Bank Loan Details</h3>
    </div>
</div>
<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3" class="table align-middle gy-4">
        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light">
                <th>Bank</th>
                <th>IFSC Code</th>
                <th>Account No</th>
                <th>Loan Type</th>
                <th>Amount</th>
                <th>Loan Months</th>
                <th>Loan Period </th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if( isset($info->loans) && !empty( $info->loans ) )
                @foreach ($info->loans as $item)
                    <tr>
                        <td>{{ $item->bank_name }}</td>
                        <td>{{ $item->ifsc_code }}</td>
                        <td>{{ $item->loan_ac_no }}</td>
                        <td>{{ ucfirst($item->loan_due) }}</td>
                        <td>₹ {{ $item->every_month_amount }}</td>
                        <td>{{ $item->period_of_loans}}</td>
                        <td>{{ commonDateFormat($item->loan_start_date). ' - '. commonDateFormat($item->loan_end_date) }}</td>
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