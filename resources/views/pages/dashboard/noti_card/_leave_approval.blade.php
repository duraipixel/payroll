<a class="card d-block" href="{{ route('staff.list') }}">
    <div class="card-body p-3">
        <div class="row m-0">
            <div class="col-lg-4">
                <div class="symbol symbol-60px mx-auto text-center">
                    <div class="symbol-label fs-2 fw-bold bg-danger text-inverse-danger">
                        <span class="svg-icon svg-icon-primary svg-icon-3x">
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none"
                            fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path
                            d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z M10.875,15.75 C11.1145833,15.75 11.3541667,15.6541667 11.5458333,15.4625 L15.3791667,11.6291667 C15.7625,11.2458333 15.7625,10.6708333 15.3791667,10.2875 C14.9958333,9.90416667 14.4208333,9.90416667 14.0375,10.2875 L10.875,13.45 L9.62916667,12.2041667 C9.29375,11.8208333 8.67083333,11.8208333 8.2875,12.2041667 C7.90416667,12.5875 7.90416667,13.1625 8.2875,13.5458333 L10.2041667,15.4625 C10.3958333,15.6541667 10.6354167,15.75 10.875,15.75 Z"
                            fill="#fff" fill-rule="nonzero"></path>
                            <path
                            d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z"
                            fill="#F1416C"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-8 p-0">
        <div class="fs-5 fw-bolder mb-2">Authorized Leave
            @if (count($leave_approved))
            <span class="badge bg-danger">{{ count($leave_approved) }}</span>
            @endif
        </div>
          <div class="fs-5 fw-bolder mb-2">Un-authorised Leave
            @if (count($leave_pending))
            <span class="badge bg-danger">{{ count($leave_pending) }}</span>
            @endif
        </div>
        <div class="fs-8 fw-bold text-gray-400">{{ $result_month_for ?? '' }}</div>
    </div>
</div>
</div>
</a>
