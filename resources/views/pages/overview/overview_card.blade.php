<div class="card mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">

                    @if ( (isset(auth()->user()->image) && !empty(auth()->user()->image)) || (isset($info->image) && !empty($info->image)) )
                    @php
                        $image_path = $info->image ?? ((auth()->user()->id == $info->id && isset(auth()->user()->image) && !empty(auth()->user()->image) ) ? auth()->user()->image : '' );
                        

                $profile_image=storage_path('app/public/' . $image_path);
                @endphp
                       
                  
                    @if(file_exists($profile_image))
                        <img alt="user" src="{{ asset('public' . $profile_image) }}" />
                    @else
                        <img alt="user" src="{{ asset('assets/images/no_Image.jpg') }}" />
                        @endif
                    @endif
                    <div  class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px">
                    </div>
                </div>
            </div>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-gray-900 text-hover-primary fs-4 fw-bolder me-1">{{ $info->name }}</a>
                            <a href="#" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3">{{ ucfirst($info->status) }}</a>
                        </div>
                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                            @isset($info->personal->gender)
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    {!! genderMaleSvg() !!}
                                    {{ ucfirst($info->personal->gender ?? '') }}
                                </a>
                            @endisset
                            @isset($info->position->designation->name)
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    {!! userSvg() !!}
                                    {{ ucwords($info->position->designation->name ?? '') }}
                                </a>
                            @endisset
                            @isset($info->personal->contact_address)
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    {!! locationSvg() !!}
                                    {{ $info->personal->contact_address ?? '' }}
                                </a>
                            @endisset
                            @isset($info->personal->phone_no)
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    {!! mobileSvg() !!}
                                    {{ $info->personal->phone_no ?? '' }}
                                </a>
                            @endisset
                            @isset($info->personal->dob)
                                <a href="#"  class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    {!! calenderSvg() !!}
                                    {{ isset($info->personal->dob) ? date('d/m/Y', strtotime($info->personal->dob)) : '' }}
                                </a>
                            @endisset
                            @isset($info->email)
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    {!! emailSvg() !!}
                                    {{ $info->email }}
                                </a>
                            @endisset
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bolder" data-kt-countup="false" data-kt-countup-value="12589"
                                        data-kt-countup-prefix="">{{ $info->emp_code ?? '00000' }}
                                    </div>
                                </div>
                                <div class="fw-bold fs-6 text-gray-400">Employe ID</div>
                            </div>
                            @isset($info->reporting->name )
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bolder" data-kt-countup="false" data-kt-countup-value="08">
                                        {{ ucwords($info->reporting->name ?? '') }}</div>
                                </div>
                                <div class="fw-bold fs-6 text-gray-400">Reporting Person</div>
                            </div>
                            @endisset

                            @isset($info->personal->marital_status)
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bolder" data-kt-countup="false" data-kt-countup-value="08">
                                        {{ ucfirst($info->personal->marital_status ?? '') }}</div>
                                </div>
                                <div class="fw-bold fs-6 text-gray-400">Marital Status</div>
                            </div>
                            @endisset
                            
                            @isset($info->position->department->name)
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bolder" data-kt-countup="false" data-kt-countup-value="2000">
                                        {{ ucwords($info->position->department->name ?? '') }}</div>
                                </div>
                                <div class="fw-bold fs-6 text-gray-400">Employee category</div>
                            </div>
                            @endisset

                            @isset($info->firstAppointment->from_appointment)
                                
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bolder" data-kt-countup="false" data-kt-countup-value="2000">
                                        {{ $info->firstAppointment->from_appointment ?? '' }}</div>
                                </div>

                                <div class="fw-bold fs-6 text-gray-400">Employed Since</div>
                            </div>
                            @endisset

                            
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bolder" data-kt-countup="false" data-kt-countup-value="08">
                                        {{ getTotalExperience($info->id) }}</div>
                                </div>
                                <div class="fw-bold fs-6 text-gray-400">Total Experience</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
