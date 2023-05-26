@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
<style>
    .canvasjs-chart-credit {
        display: none !important;
    }
</style>
<div class="card">

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
                    <div class="col-md-6 col-lg-2">
                        <div class="card h-100 cstmzed">
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                <a href="#" class="text-gray-800 text-hover-primary d-flex flex-column">
                                    <!--begin::Image-->

                                <div class="symbol mb-5 symbol-60px mx-auto text-center">
                                    <div class="symbol-label fs-2 fw-bold bg-success text-inverse-danger">
                                        <span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Add-user.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#fff" fill-rule="nonzero"></path>
                                        <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#fff" fill-rule="nonzero"></path>
                                        </g></svg><!--end::Svg Icon--></span>
                                    </div>
                                </div> 
                                    <!--end::Image-->
                                    <!--begin::Title-->
                                    <div class="fs-5 fw-bolder mb-2">Manage Users</div>
                                    
                                    <!--end::Title-->
                                </a>
                                <div class="fs-7 fw-bold text-gray-400">Last Updated : 3 days ago</div>
                                <span class="cstemed fs-1.8hx fw-bolder text-light-800 counted" data-kt-countup="true" data-kt-countup-value="30467" style="margin-top:-186px">
                                    <span class="fs-6 text-light-700 fw-bolder">
                                        <span class="fs-6 text-light-700 fw-bolder">
                                            <span class="ms-n1 counted" data-kt-countup="true" data-kt-countup-value="45">45</span>
                                        </span>
                                    </span>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-2">
                        <div class="card h-100 cstmzed">
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                <a href="#" class="text-gray-800 text-hover-primary d-flex flex-column">
                                    <div class="symbol mb-5 symbol-60px mx-auto text-center">
                                        <div class="symbol-label fs-2 fw-bold bg-danger text-inverse-danger">
                                            <span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/File-done.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z M10.875,15.75 C11.1145833,15.75 11.3541667,15.6541667 11.5458333,15.4625 L15.3791667,11.6291667 C15.7625,11.2458333 15.7625,10.6708333 15.3791667,10.2875 C14.9958333,9.90416667 14.4208333,9.90416667 14.0375,10.2875 L10.875,13.45 L9.62916667,12.2041667 C9.29375,11.8208333 8.67083333,11.8208333 8.2875,12.2041667 C7.90416667,12.5875 7.90416667,13.1625 8.2875,13.5458333 L10.2041667,15.4625 C10.3958333,15.6541667 10.6354167,15.75 10.875,15.75 Z" fill="#fff" fill-rule="nonzero"></path>
                                            <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#F1416C"></path>
                                            </g>
                                            </svg><!--end::Svg Icon--></span>
                                        </div>
                                    </div>                                         
                                        <!--begin::Title-->
                                        <div class="fs-5 fw-bolder mb-2">Leave Approval</div>
                                        <!--end::Title-->
                                </a>
                                <div class="fs-7 fw-bold text-gray-400">Last Updated : 3 days ago</div>
                                
                                <span class="cstemed fs-1.8hx fw-bolder text-light-800 counted" data-kt-countup="true" data-kt-countup-value="30467" style="margin-top:-186px">
                                    <span class="fs-6 text-light-700 fw-bolder">
                                        <span class="fs-6 text-light-700 fw-bolder">
                                            <span class="ms-n1 counted" data-kt-countup="true" data-kt-countup-value="45">20</span>
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="card h-100 cstmzed">
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                <a href="#" class="text-gray-800 text-hover-primary d-flex flex-column">
                                    <!--begin::Image-->
                                    <div class="symbol mb-5 symbol-60px mx-auto text-center">
                                        <div class="symbol-label fs-2 fw-bold bg-primary text-inverse-danger">
                                            <span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Food/Cake.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M13,11 L17,11 C19.0758626,11 20.7823939,12.5812954 20.980747,14.6050394 L20.2928932,15.2928932 C19.1327768,16.4530096 18.0387961,17 17,17 C16.5220296,17 16.1880664,16.8518214 15.5648598,16.401988 C15.504386,16.3583378 15.425236,16.3005045 15.2756717,16.1912639 C14.1361881,15.3625486 13.3053476,15 12,15 C10.7177731,15 9.87894492,15.3373247 8.58005831,16.1531954 C8.42732855,16.2493619 8.35077622,16.2975179 8.28137728,16.3407226 C7.49918122,16.8276828 7.06530257,17 6.5,17 C5.8272085,17 5.18146841,16.7171497 4.58539107,16.2273674 C4.21125802,15.9199514 3.94722374,15.6135435 3.82536894,15.4354062 C3.58523105,15.132389 3.4977165,15.0219591 3.03793571,14.4468552 C3.3073102,12.4994956 4.97854212,11 7,11 L11,11 L11,9 L13,9 L13,11 Z" fill="#fff"></path>
                                                <path d="M12,7 C13.1045695,7 14,6.1045695 14,5 C14,4.26362033 13.3333333,3.26362033 12,2 C10.6666667,3.26362033 10,4.26362033 10,5 C10,6.1045695 10.8954305,7 12,7 Z" fill="#fff"></path>
                                                <path d="M21,17.3570374 L21,21 C21,21.5522847 20.5522847,22 20,22 L4,22 C3.44771525,22 3,21.5522847 3,21 L3,17.4976746 C3.098145,17.5882704 3.2035241,17.6804734 3.31568417,17.7726326 C4.24088818,18.5328503 5.30737928,19 6.5,19 C7.52608715,19 8.26628185,18.7060277 9.33838848,18.0385822 C9.41243034,17.9924871 9.49377318,17.9413176 9.64386645,17.8468046 C10.6511414,17.2141042 11.1835561,17 12,17 C12.7988191,17 13.2700619,17.2056332 14.0993283,17.8087361 C14.2431314,17.9137812 14.3282387,17.9759674 14.3943239,18.0236679 C15.3273176,18.697107 16.0099741,19 17,19 C18.3748985,19 19.7104312,18.4390637 21,17.3570374 Z" fill="#fff"></path>
                                                </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                        </div>
                                    </div> 
                                    <!--end::Image--> 
                                    <!--begin::Title-->
                                    <div class="fs-5 fw-bolder mb-2">Birthdays</div>
                                    <!--end::Title-->
                                </a>
                                <div class="fs-7 fw-bold text-gray-400">Last Updated : 3 days ago</div>
                                
                                <span class="cstemed fs-1.8hx fw-bolder text-light-800 counted" data-kt-countup="true" data-kt-countup-value="30467" style="margin-top:-186px">
                                    <span class="fs-6 text-light-700 fw-bolder">
                                        <span class="fs-6 text-light-700 fw-bolder">
                                            <span class="ms-n1 counted" data-kt-countup="true" data-kt-countup-value="45">15</span>
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="card h-100 cstmzed">
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                <a href="../file-manager/files.html" class="text-gray-800 text-hover-primary d-flex flex-column">
                                    <!--begin::Image-->
                                <div class="symbol mb-5 symbol-60px mx-auto text-center">
                                    <div class="symbol-label fs-2 fw-bold bg-warning text-inverse-danger">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Heart.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M16.5,4.5 C14.8905,4.5 13.00825,6.32463215 12,7.5 C10.99175,6.32463215 9.1095,4.5 7.5,4.5 C4.651,4.5 3,6.72217984 3,9.55040872 C3,12.6834696 6,16 12,19.5 C18,16 21,12.75 21,9.75 C21,6.92177112 19.349,4.5 16.5,4.5 Z" fill="#fff" fill-rule="nonzero"></path>
                                            </g>
                                            </svg><!--end::Svg Icon-->
                                        </span>
                                    </div>
                                </div> 
                                    <!--end::Image-->  
                                    <!--begin::Title-->
                                    <div class="fs-5 fw-bolder mb-2">Anniversary</div>
                                    <!--end::Title-->
                                </a>
                                <div class="fs-7 fw-bold text-gray-400">Last Updated : 3 days ago</div>
                                
                                <span class="cstemed fs-1.8hx fw-bolder text-light-800 counted" data-kt-countup="true" data-kt-countup-value="30467" style="margin-top:-186px">
                                    <span class="fs-6 text-light-700 fw-bolder">
                                        <span class="fs-6 text-light-700 fw-bolder">
                                            <span class="ms-n1 counted" data-kt-countup="true" data-kt-countup-value="45">45</span>
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="card h-100 cstmzed">
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                <a href="../file-manager/files.html" class="text-gray-800 text-hover-primary d-flex flex-column">
                                    <!--begin::Image-->
                                <div class="symbol mb-5 symbol-60px mx-auto text-center">
                                    <div class="symbol-label fs-2 fw-bold bg-dark text-inverse-danger">
                                        <span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Alarm-clock.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path d="M7.14319965,19.3575259 C7.67122143,19.7615175 8.25104409,20.1012165 8.87097532,20.3649307 L7.89205065,22.0604779 C7.61590828,22.5387706 7.00431787,22.7026457 6.52602525,22.4265033 C6.04773263,22.150361 5.88385747,21.5387706 6.15999985,21.0604779 L7.14319965,19.3575259 Z M15.1367085,20.3616573 C15.756345,20.0972995 16.3358198,19.7569961 16.8634386,19.3524415 L17.8320512,21.0301278 C18.1081936,21.5084204 17.9443184,22.1200108 17.4660258,22.3961532 C16.9877332,22.6722956 16.3761428,22.5084204 16.1000004,22.0301278 L15.1367085,20.3616573 Z" fill="#fff"></path>
                                            <path d="M12,21 C7.581722,21 4,17.418278 4,13 C4,8.581722 7.581722,5 12,5 C16.418278,5 20,8.581722 20,13 C20,17.418278 16.418278,21 12,21 Z M19.068812,3.25407593 L20.8181344,5.00339833 C21.4039208,5.58918477 21.4039208,6.53893224 20.8181344,7.12471868 C20.2323479,7.71050512 19.2826005,7.71050512 18.696814,7.12471868 L16.9474916,5.37539627 C16.3617052,4.78960984 16.3617052,3.83986237 16.9474916,3.25407593 C17.5332781,2.66828949 18.4830255,2.66828949 19.068812,3.25407593 Z M5.29862906,2.88207799 C5.8844155,2.29629155 6.83416297,2.29629155 7.41994941,2.88207799 C8.00573585,3.46786443 8.00573585,4.4176119 7.41994941,5.00339833 L5.29862906,7.12471868 C4.71284263,7.71050512 3.76309516,7.71050512 3.17730872,7.12471868 C2.59152228,6.53893224 2.59152228,5.58918477 3.17730872,5.00339833 L5.29862906,2.88207799 Z" fill="#fff"></path>
                                            <path d="M11.9630156,7.5 L12.0475062,7.5 C12.3043819,7.5 12.5194647,7.69464724 12.5450248,7.95024814 L13,12.5 L16.2480695,14.3560397 C16.403857,14.4450611 16.5,14.6107328 16.5,14.7901613 L16.5,15 C16.5,15.2109164 16.3290185,15.3818979 16.1181021,15.3818979 C16.0841582,15.3818979 16.0503659,15.3773725 16.0176181,15.3684413 L11.3986612,14.1087258 C11.1672824,14.0456225 11.0132986,13.8271186 11.0316926,13.5879956 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z" fill="#000"></path>
                                            </g></svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                </div> 
                                    <!--end::Image--> 
                                    <!--begin::Title-->
                                    <div class="fs-5 fw-bolder mb-2">Reminders</div>
                                    <!--end::Title-->
                                </a>
                                <div class="fs-7 fw-bold text-gray-400">Last Updated : 3 days ago</div>
                                
                                <span class="cstemed fs-1.8hx fw-bolder text-light-800 counted" data-kt-countup="true" data-kt-countup-value="30467" style="margin-top:-186px">
                                    <span class="fs-6 text-light-700 fw-bolder">
                                        <span class="fs-6 text-light-700 fw-bolder">
                                            <span class="ms-n1 counted" data-kt-countup="true" data-kt-countup-value="45">50</span>
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="card h-100 cstmzed">
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                <a href="#" class="text-gray-800 text-hover-primary d-flex flex-column">
                                    <div class="symbol mb-5 symbol-60px mx-auto text-center">
                                        <div class="symbol-label fs-2 fw-bold bg-danger text-inverse-danger">
                                            <span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/File-done.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z M10.875,15.75 C11.1145833,15.75 11.3541667,15.6541667 11.5458333,15.4625 L15.3791667,11.6291667 C15.7625,11.2458333 15.7625,10.6708333 15.3791667,10.2875 C14.9958333,9.90416667 14.4208333,9.90416667 14.0375,10.2875 L10.875,13.45 L9.62916667,12.2041667 C9.29375,11.8208333 8.67083333,11.8208333 8.2875,12.2041667 C7.90416667,12.5875 7.90416667,13.1625 8.2875,13.5458333 L10.2041667,15.4625 C10.3958333,15.6541667 10.6354167,15.75 10.875,15.75 Z" fill="#fff" fill-rule="nonzero"></path>
                                            <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#F1416C"></path>
                                            </g>
                                            </svg><!--end::Svg Icon--></span>
                                        </div>
                                    </div>                                         
                                        <!--begin::Title-->
                                        <div class="fs-5 fw-bolder mb-2">Leave Approval</div>
                                        <!--end::Title-->
                                    </a>
                                <div class="fs-7 fw-bold text-gray-400">Last Updated : 3 days ago</div>
                                
                                <span class="cstemed fs-1.8hx fw-bolder text-light-800 counted" data-kt-countup="true" data-kt-countup-value="30467" style="margin-top:-186px">
                                    <span class="fs-6 text-light-700 fw-bolder">
                                        <span class="fs-6 text-light-700 fw-bolder">
                                            <span class="ms-n1 counted" data-kt-countup="true" data-kt-countup-value="45">30</span>
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row g-6 g-xl-9">
                <div class="col-lg-6 col-xxl-4">
                    <div class="card h-100 cstmzed">
                        <div class="card h-100 cstmzed">
                            <div class="card-body p-9">
                            <div class="card-title">
                            <h3 class="mb-5 text-gray-800">Staffs Enrollment <span>(12)</span></h3>
                        </div>
                        <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 320px">
                                <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                                    <!--begin::Thead-->
                                    <thead class="border-gray-200 fs-5 fw-bold bg-lighter">
                                        <tr>
                                            <th class="min-w-150px ps-9">Staffs</th>
                                            <th class="min-w-150px ps-0 text-end">Nos</th> 
                                        </tr>
                                    </thead>
                                    <!--end::Thead-->
                                    <!--begin::Tbody-->
                                    <tbody class="fs-6 fw-bold text-gray-600">
                                        <tr>
                                            <td class="ps-9">Teaching Staff</td>
                                            <td class="ps-0 text-end">200</td> 
                                        </tr>
                                        <tr>
                                            <td class="ps-9">Non-teaching Staff</td>
                                            <td class="ps-0 text-end">100</td> 
                                        </tr>
                                        <tr>
                                            <td class="ps-9">Sanitary Staff</td>
                                            <td class="ps-0 text-end">20</td> 
                                        </tr>
                                        <tr>
                                            <td class="ps-9">Cleaners</td>
                                            <td class="ps-0 text-end">5</td> 
                                        </tr>
                                        <tr>
                                            <td class="ps-9">Drivers</td>
                                            <td class="ps-0 text-end">30</td> 
                                        </tr>
                                        <tr>
                                            <td class="ps-9">Wardens</td>
                                            <td class="ps-0 text-end">15</td> 
                                        </tr>
                                        <tr>
                                            <td class="ps-9">Watch Man</td>
                                            <td class="ps-0 text-end">8</td> 
                                        </tr>
                                        <tr>
                                            <td class="ps-9">Pantry workers</td>
                                            <td class="ps-0 text-end">7</td> 
                                        </tr>
                                        <tr>
                                            <td class="ps-9">Servants</td>
                                            <td class="ps-0 text-end">18</td> 
                                        </tr>
                                    </tbody>
                                    <!--end::Tbody-->
                                </table>
                                </div>
                            </div>
                        </div>
                    <!--end::Wrapper-->
                      
            </div>
        </div>
        <div class="col-lg-6 col-xxl-4">
            <div class="card h-100 cstmzed">
                <div class="card-body p-9">
                    <div class="card-title">
                    <h3 class="mb-5 text-gray-800">Staffs Birthday <span>(6)</span></h3>
                </div>
                <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 320px">
                        <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                            <!--begin::Thead-->
                            <thead class="border-gray-200 fs-5 fw-bold bg-lighter">
                                <tr>
                                    <th class="min-w-150px ps-9">Name</th>
                                    <th class="min-w-150px ps-0 text-end">Date</th> 
                                </tr>
                            </thead>
                            <!--end::Thead-->
                            <!--begin::Tbody-->
                            <tbody class="fs-6 fw-bold text-gray-600">
                                <tr>
                                    <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-1.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">John</a> 
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Teaching Staff</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1990</td> 
                                </tr>
                                <tr>
                                    <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-2.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Paul</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Non-Teaching Staff</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1985</td> 
                                </tr> 
                                <tr>
                                    <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-3.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Mani</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Driver</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1988</td>  
                                </tr>
                                <tr>
                                                                                                <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-4.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Sam</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Teaching Staff</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1981</td> 
                                </tr>
                                <tr>
                                                                                                <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-5.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Mike</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Non-Teaching Staff</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1983</td> 
                                </tr> 
                            </tbody>
                            <!--end::Tbody-->
                        </table>
                    </div>
                    </div>
        </div>
    </div>
        <div class="col-lg-6 col-xxl-4">
            <div class="card h-100 cstmzed">
                
                <div class="card-body p-9">
                    <div class="card-title">
                    <h3 class="mb-5 text-gray-800">Staffs Anniversary</h3>
                </div> 
                <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 320px">
                        <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                            <!--begin::Thead-->
                            <thead class="border-gray-200 fs-5 fw-bold bg-lighter">
                                <tr>
                                    <th class="min-w-150px ps-9">Name</th>
                                    <th class="min-w-150px text-end">Date</th> 
                                </tr>
                            </thead>
                            <!--end::Thead-->
                            <!--begin::Tbody-->
                            <tbody class="fs-6 fw-bold text-gray-600">
                                <tr>
                                    <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-6.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">John</a> 
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Teaching Staff</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1990</td> 
                                </tr>
                                <tr>
                                    <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-7.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Paul</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Non-Teaching Staff</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1985</td> 
                                </tr> 
                                <tr>
                                    <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-9.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Mani</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Driver</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1988</td>  
                                </tr>
                                <tr>
                                                                                                <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-10.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Sam</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Teaching Staff</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1981</td> 
                                </tr>
                                <tr>
                                                                                                <td>
                                            <div class="d-flex text-start align-items-left">
                                                <div class="symbol symbol-45px me-5">
                                                    <img src="../assets/media/avatars/300-11.jpg" alt="">
                                                </div>
                                                <div class="d-flex justify-content-middle flex-column">
                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Mike</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">Non-Teaching Staff</span>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="ps-0 text-end">Nov 01, 1983</td> 
                                </tr> 
                            </tbody>
                            <!--end::Tbody-->
                        </table>
                    </div>
                    </div>


    </div>
</div>


<div class="row g-6 g-xl-9">
    <div class="col-lg-6 col-xxl-4">
        <div class="card h-100 cstmzed">
        <div class="card-body p-9">
            <div class="card-title">
            <h3 class="mb-5 text-gray-800">Staffs Retirement</h3>
        </div>  
        <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 320px">
                <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                    <!--begin::Thead-->
                    <thead class="border-gray-200 fs-5 fw-bold bg-lighter">
                        <tr>
                            <th class="min-w-150px ps-9">Name</th>
                            <th class="min-w-150px text-end">Date</th> 
                        </tr>
                    </thead>
                    <!--end::Thead-->
                    <!--begin::Tbody-->
                    <tbody class="fs-6 fw-bold text-gray-600">
                        <tr>
                            <td>
                                    <div class="d-flex text-start align-items-left">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="../assets/media/avatars/300-12.jpg" alt="">
                                        </div>
                                        <div class="d-flex justify-content-middle flex-column">
                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">John</a> 
                                            <span class="text-muted fw-bold text-muted d-block fs-7">Teaching Staff</span>
                                        </div>
                                    </div>
                                </td>
                            <td class="ps-0 text-end">Nov 01, 1990</td> 
                        </tr>
                        <tr>
                            <td>
                                    <div class="d-flex text-start align-items-left">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="../assets/media/avatars/300-13.jpg" alt="">
                                        </div>
                                        <div class="d-flex justify-content-middle flex-column">
                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Paul</a>
                                            <span class="text-muted fw-bold text-muted d-block fs-7">Non-Teaching Staff</span>
                                        </div>
                                    </div>
                                </td>
                            <td class="ps-0 text-end">Nov 01, 1985</td> 
                        </tr> 
                        <tr>
                            <td>
                                    <div class="d-flex text-start align-items-left">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="../assets/media/avatars/300-14.jpg" alt="">
                                        </div>
                                        <div class="d-flex justify-content-middle flex-column">
                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Mani</a>
                                            <span class="text-muted fw-bold text-muted d-block fs-7">Driver</span>
                                        </div>
                                    </div>
                                </td>
                            <td class="ps-0 text-end">Nov 01, 1988</td>  
                        </tr>
                        <tr>
                                                                                        <td>
                                    <div class="d-flex text-start align-items-left">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="../assets/media/avatars/300-16.jpg" alt="">
                                        </div>
                                        <div class="d-flex justify-content-middle flex-column">
                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Sam</a>
                                            <span class="text-muted fw-bold text-muted d-block fs-7">Teaching Staff</span>
                                        </div>
                                    </div>
                                </td>
                            <td class="ps-0 text-end">Nov 01, 1981</td> 
                        </tr>
                        <tr>
                                                                                        <td>
                                    <div class="d-flex text-start align-items-left">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="../assets/media/avatars/300-19.jpg" alt="">
                                        </div>
                                        <div class="d-flex justify-content-middle flex-column">
                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Mike</a>
                                            <span class="text-muted fw-bold text-muted d-block fs-7">Non-Teaching Staff</span>
                                        </div>
                                    </div>
                                </td>
                            <td class="ps-0 text-end">Nov 01, 1983</td> 
                        </tr> 
                    </tbody>
                    <!--end::Tbody-->
                </table>
            </div>
        </div>
            
          
</div>
</div>
<div class="col-lg-6 col-xxl-4">
<div class="card h-100 cstmzed">
    <div class="card-body p-9">
        <div class="card-title">
        <h3 class="mb-5 text-gray-800">Pending Approvals</h3>
    </div>  
            <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                <!--begin::Thead-->
                <thead class="border-gray-200 fs-5 fw-bold bg-lighter">
                    <tr>
                        <th class="min-w-150px ps-9">Particulars</th>
                        <th class="min-w-150px text-end">Nos</th> 
                    </tr>
                </thead>
                <!--end::Thead-->
                <!--begin::Tbody-->
                <tbody class="fs-6 fw-bold text-gray-600">
                    <tr>
                        <td class="ps-9">Pending Certificates for undergoing qualifiers</td>
                        <td class="ps-0 text-end">10</td> 
                    </tr>
                    <tr>
                        <td class="ps-9">Prohibition Period Allocation</td>
                        <td class="ps-0 text-end">5</td> 
                    </tr> 
                    <tr>
                        <td class="ps-9">Appointment Order list</td>
                        <td class="ps-0 text-end">8</td>  
                    </tr>
                    <tr>
                        <td class="ps-9">Salary process</td>
                        <td class="ps-0 text-end">15</td> 
                    </tr> 
                </tbody>
                <!--end::Tbody-->
            </table>
        </div>
</div>
</div>
<div class="col-lg-6 col-xxl-4">
<div class="card h-100 cstmzed">
    <div class="card-body p-9">
        <div class="card-title">
        <h3 class="mb-5 text-gray-800">List of Events</h3>
    </div>  
            <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                <!--begin::Thead-->
                <thead class="border-gray-200 fs-5 fw-bold bg-lighter">
                    <tr>
                        <th class="min-w-150px ps-9">Event Name</th>
                        <th class="min-w-150px text-end">Date</th> 
                    </tr>
                </thead>
                <!--end::Thead-->
                <!--begin::Tbody-->
                <tbody class="fs-6 fw-bold text-gray-600">
                    <tr>
                        <td class="ps-9">Event - 1</td>
                        <td class="ps-0 text-end">Oct 01, 2022</td> 
                    </tr>
                    <tr>
                        <td class="ps-9">Event - 2</td>
                        <td class="ps-0 text-end">Nov 01, 2022</td> 
                    </tr> 
                    <tr>
                        <td class="ps-9">Event - 3</td>
                        <td class="ps-0 text-end">Dec 01, 2022</td>  
                    </tr>
                    <tr>
                        <td class="ps-9">Event - 4</td>
                        <td class="ps-0 text-end">Dec 08, 2022</td> 
                    </tr> 
                    <tr>
                        <td class="ps-9">Event - 5</td>
                        <td class="ps-0 text-end">Dec 23, 2022</td> 
                    </tr> 
                </tbody>
                <!--end::Tbody-->
            </table>
        </div>

</div>
</div>

<div class="col-lg-6 col-xxl-4">
    <div class="card h-100 cstmzed">
        <div class="card-body p-9">
            <div class="card-title">
            <h3 class="mb-5 text-gray-800">Institution Wise Age Chart</h3>
        </div>  
        <div class="d-flex flex-wrap px-0 mb-5">
            <!--begin::Stat-->
            <div class="rounded min-w-125px py-3 px-4 my-1 me-6" style="border: 1px dashed rgba(0, 0, 0, 0.35)">
                <!--begin::Number-->
                <div class="d-flex align-items-center">
                    <div class="text-dark fs-2 fw-bolder counted" data-kt-countup="true" data-kt-countup-value="4368" data-kt-countup-prefix="">4,368</div>
                </div>
                <!--end::Number-->
                <!--begin::Label-->
                <div class="fw-bold fs-6 text-dark opacity-50"> Amalarpavam Staffs</div>
                <!--end::Label-->
            </div>
            <!--end::Stat-->
            <!--begin::Stat-->
            <div class="rounded min-w-125px py-3 px-4 my-1" style="border: 1px dashed rgba(0, 0, 0, 0.35)">
                <!--begin::Number-->
                <div class="d-flex align-items-center">
                    <div class="text-dark fs-2 fw-bolder counted" data-kt-countup="true" data-kt-countup-value="120,000">120,000</div>
                </div>
                <!--end::Number-->
                <!--begin::Label-->
                <div class="fw-bold fs-6 text-dark opacity-50">Loudres Marry Staffs</div>
                <!--end::Label-->
            </div>
            <!--end::Stat-->
        </div>

        <div id="chartdiv_data"></div>
            </div>
    
    </div>
    </div>
                

</div></div></div></div></div>

<style>
    #chartdiv_data {
      width: 100%;
      height: 300px;
    }
    </style>
@endsection

@section('add_on_script')
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script>
    /*$(document).ready(function(){
       

    });*/

    am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv_data");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: false,
  panY: false,
  layout: root.verticalLayout
}));


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(
  am5.Legend.new(root, {
    centerX: am5.p50,
    x: am5.p50
  })
);

var data = [{
  "year": "2021",
  "europe": 2.5,
  "namerica": 2.5
}, {
  "year": "2022",
  "europe": 2.6,
  "namerica": 2.7
}, {
  "year": "2023",
  "europe": 2.8,
  "namerica": 2.9
}]


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, {
  cellStartLocation: 0.1,
  cellEndLocation: 0.9
})

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "year",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

xRenderer.grid.template.setAll({
  location: 1
})

xAxis.data.setAll(data);

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  renderer: am5xy.AxisRendererY.new(root, {
    strokeOpacity: 0.1
  })
}));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
function makeSeries(name, fieldName) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: fieldName,
    categoryXField: "year"
  }));

  series.columns.template.setAll({
    tooltipText: "{name}, {categoryX}:{valueY}",
    width: am5.percent(90),
    tooltipY: 0,
    strokeOpacity: 0
  });

  series.data.setAll(data);

  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/
  series.appear();

  series.bullets.push(function() {
    return am5.Bullet.new(root, {
      locationY: 0,
      sprite: am5.Label.new(root, {
        text: "{valueY}",
        fill: root.interfaceColors.get("alternativeText"),
        centerY: 0,
        centerX: am5.p50,
        populateText: true
      })
    });
  });

  legend.data.push(series);
}

makeSeries("Europe", "europe");
makeSeries("North America", "namerica");



// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

}); // end am5.ready()
</script>

@endsection
