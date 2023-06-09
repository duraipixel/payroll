<a class="card d-block" href="{{ route('staff.list') }}">
    <div class="card-body p-3">
        <div class="row m-0">
            <div class="col-lg-4">
                <div class="symbol symbol-60px mx-auto text-center">
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
            </div>
            <div class="col-lg-8  p-0">
                <div class="fs-5 fw-bolder mb-2">Anniversary
                    @if (count($anniversary))
                        <span class="badge bg-danger">{{ count($anniversary) }}</span>
                    @endif
                </div>
                <div class="fs-8 fw-bold text-gray-400">{{ $result_month_for ?? '' }}</div>
            </div>
        </div>
    </div>
</a>

