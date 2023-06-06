<div class="card-body d-flex justify-content-center text-center flex-column p-8">
    <a href="javascript:void(0)" class="text-gray-800 text-hover-primary d-flex flex-column">
        
        <div class="symbol mb-5 symbol-60px mx-auto text-center">
            <div class="symbol-label fs-2 fw-bold bg-primary text-inverse-danger">
                <span class="svg-icon svg-icon-primary svg-icon-3x">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none"
                            fill-rule="evenodd">
                            <rect x="0" y="0" width="24"
                                height="24"></rect>
                            <path
                                d="M13,11 L17,11 C19.0758626,11 20.7823939,12.5812954 20.980747,14.6050394 L20.2928932,15.2928932 C19.1327768,16.4530096 18.0387961,17 17,17 C16.5220296,17 16.1880664,16.8518214 15.5648598,16.401988 C15.504386,16.3583378 15.425236,16.3005045 15.2756717,16.1912639 C14.1361881,15.3625486 13.3053476,15 12,15 C10.7177731,15 9.87894492,15.3373247 8.58005831,16.1531954 C8.42732855,16.2493619 8.35077622,16.2975179 8.28137728,16.3407226 C7.49918122,16.8276828 7.06530257,17 6.5,17 C5.8272085,17 5.18146841,16.7171497 4.58539107,16.2273674 C4.21125802,15.9199514 3.94722374,15.6135435 3.82536894,15.4354062 C3.58523105,15.132389 3.4977165,15.0219591 3.03793571,14.4468552 C3.3073102,12.4994956 4.97854212,11 7,11 L11,11 L11,9 L13,9 L13,11 Z"
                                fill="#fff"></path>
                            <path
                                d="M12,7 C13.1045695,7 14,6.1045695 14,5 C14,4.26362033 13.3333333,3.26362033 12,2 C10.6666667,3.26362033 10,4.26362033 10,5 C10,6.1045695 10.8954305,7 12,7 Z"
                                fill="#fff"></path>
                            <path
                                d="M21,17.3570374 L21,21 C21,21.5522847 20.5522847,22 20,22 L4,22 C3.44771525,22 3,21.5522847 3,21 L3,17.4976746 C3.098145,17.5882704 3.2035241,17.6804734 3.31568417,17.7726326 C4.24088818,18.5328503 5.30737928,19 6.5,19 C7.52608715,19 8.26628185,18.7060277 9.33838848,18.0385822 C9.41243034,17.9924871 9.49377318,17.9413176 9.64386645,17.8468046 C10.6511414,17.2141042 11.1835561,17 12,17 C12.7988191,17 13.2700619,17.2056332 14.0993283,17.8087361 C14.2431314,17.9137812 14.3282387,17.9759674 14.3943239,18.0236679 C15.3273176,18.697107 16.0099741,19 17,19 C18.3748985,19 19.7104312,18.4390637 21,17.3570374 Z"
                                fill="#fff"></path>
                        </g>
                    </svg>
                </span>
            </div>
        </div>
    
        <div class="fs-5 fw-bolder mb-2">Birthdays</div>
    </a>
    <div class="fs-7 fw-bold text-gray-400">{{ $result_month_for }}</div>

    <span class="cstemed fs-1.8hx fw-bolder text-light-800 counted" data-kt-countup="true"
        data-kt-countup-value="30467" style="margin-top:-186px">
        <span class="fs-6 text-light-700 fw-bolder">
            <span class="fs-6 text-light-700 fw-bolder">
                <span class="ms-n1 counted" data-kt-countup="true"
                    data-kt-countup-value="45">{{ count($dob) }}</span>
            </span>
        </span>
    </span>
</div>