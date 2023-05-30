<div class="card-body d-flex justify-content-center text-center flex-column p-8">
    <a href="{{ route('staff.list') }}" class="text-gray-800 text-hover-primary d-flex flex-column">
        <div class="symbol mb-5 symbol-60px mx-auto text-center">
            <div class="symbol-label fs-2 fw-bold bg-success text-inverse-danger">
                <span class="svg-icon svg-icon-primary svg-icon-3x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Add-user.svg--><svg
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none"
                            fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path
                                d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                fill="#fff" fill-rule="nonzero"></path>
                            <path
                                d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                fill="#fff" fill-rule="nonzero"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </div>
        </div>
        <div class="fs-5 fw-bolder mb-2">Manage Users</div>
    </a>
    <div class="fs-7 fw-bold text-gray-400">{{ $last_user_added ? 'Last Added :  '.date('d M Y', strtotime($last_user_added->created_at)) : '' }}</div>
    <span class="cstemed fs-1.8hx fw-bolder text-light-800 counted" data-kt-countup="true"
        data-kt-countup-value="30467" style="margin-top:-186px">
        <span class="fs-6 text-light-700 fw-bolder">
            <span class="fs-6 text-light-700 fw-bolder">
                <span class="ms-n1 counted" data-kt-countup="true"
                    data-kt-countup-value="45">{{ $user_count ?? 0 }}</span>
            </span>
        </span>
    </span>
</div>