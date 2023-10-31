@php
$balance=0;
foreach($loan->emi as $emi){
    if($emi->status=='active'){
      $balance+=$emi->amount;
    }

}
@endphp
<div class="card h-100 cstmzed">
    
    <div class="card-body p-9">
        <div class="fs-2hx fw-bolder">₹{{$loan->loan_amount}}</div>
        <div class="fs-4 fw-bold text-gray-400 mb-7">Total Loan Taken</div>
        <div class="fs-6 d-flex justify-content-between mb-4">
            <div class="fw-bold">Paid</div>
            <div class="d-flex fw-bolder">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr007.svg-->
                <span class="svg-icon svg-icon-3 me-1 svg-icon-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <path
                            d="M13.4 10L5.3 18.1C4.9 18.5 4.9 19.1 5.3 19.5C5.7 19.9 6.29999 19.9 6.69999 19.5L14.8 11.4L13.4 10Z"
                            fill="currentColor"></path>
                        <path opacity="0.3" d="M19.8 16.3L8.5 5H18.8C19.4 5 19.8 5.4 19.8 6V16.3Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->₹{{$loan->loan_amount}}
            </div>
        </div>
        <div class="separator separator-dashed"></div>
        <div class="fs-6 d-flex justify-content-between my-4">
            <div class="fw-bold">Yet to Paid</div>
            <div class="d-flex fw-bolder">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr006.svg-->
                <span class="svg-icon svg-icon-3 me-1 svg-icon-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <path
                            d="M13.4 14.8L5.3 6.69999C4.9 6.29999 4.9 5.7 5.3 5.3C5.7 4.9 6.29999 4.9 6.69999 5.3L14.8 13.4L13.4 14.8Z"
                            fill="currentColor"></path>
                        <path opacity="0.3" d="M19.8 8.5L8.5 19.8H18.8C19.4 19.8 19.8 19.4 19.8 18.8V8.5Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
                ₹{{$balance??0}}
            </div>
        </div>
        <div class="separator separator-dashed"></div>
        <div class="fs-6 d-flex justify-content-between my-4">
            <div class="fw-bold">Monthly EMI</div>
            <div class="d-flex fw-bolder"> ₹{{$loan->every_month_amount??0}}</div>
        </div>
        <div class="separator separator-dashed"></div>
        <div class="fs-6 d-flex justify-content-between my-4">
            <div class="fw-bold">Loan Issued Date</div>
            <div class="d-flex fw-bolder"> {{$loan->created_at->format('Y-m-d') }}</div>
        </div>
        <div class="separator separator-dashed"></div>
        <div class="fs-6 d-flex justify-content-between my-4">
            <div class="fw-bold">Loan Start Date</div>
            <div class="d-flex fw-bolder"> {{$loan->loan_start_date ??''}} </div>
        </div>
        <div class="separator separator-dashed"></div>
        <div class="fs-6 d-flex justify-content-between my-4">
            <div class="fw-bold">Loan End Date</div>
            <div class="d-flex fw-bolder"> {{$loan->loan_end_date ??''}} </div>
        </div>
    </div>

</div>
