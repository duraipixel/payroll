<div class="card-body d-flex justify-content-center text-center flex-column p-8">
    <a href="javascript:void(0)"
        class="text-gray-800 text-hover-primary d-flex flex-column">
        <div class="symbol mb-5 symbol-60px mx-auto text-center">
            <div class="symbol-label fs-2 fw-bold bg-warning text-inverse-danger">
                <span class="svg-icon svg-icon-primary svg-icon-2x">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none"
                            fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path
                                d="M16.5,4.5 C14.8905,4.5 13.00825,6.32463215 12,7.5 C10.99175,6.32463215 9.1095,4.5 7.5,4.5 C4.651,4.5 3,6.72217984 3,9.55040872 C3,12.6834696 6,16 12,19.5 C18,16 21,12.75 21,9.75 C21,6.92177112 19.349,4.5 16.5,4.5 Z"
                                fill="#fff" fill-rule="nonzero"></path>
                        </g>
                    </svg>
                </span>
            </div>
        </div>
        <div class="fs-5 fw-bolder mb-2">Anniversary</div>
    </a>
    <div class="fs-7 fw-bold text-gray-400">{{ $result_month_for ?? '' }}</div>

    <span class="cstemed fs-1.8hx fw-bolder text-light-800 counted" 
        data-kt-countup-value="30467" style="margin-top:-186px">
        <span class="fs-6 text-light-700 fw-bolder">
            <span class="fs-6 text-light-700 fw-bolder">
                <span class="ms-n1 counted" 
                    >{{ count( $anniversary ) }}</span>
            </span>
        </span>
    </span>
</div>