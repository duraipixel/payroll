<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="  cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Personal Details</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">

            <div class="card-body cstmzed-witpad">
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Name in English</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->name }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Name in Tamil</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->first_name_tamil ?? '' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Short Name</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->short_name ?? '' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted"> Employee Code</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->emp_code ?? '' }}</span>
                    </div>
                </div>
                @isset($info->institute_emp_code)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted">Institution Employee Code</label>
                        <div class="col-lg-7">
                            <span class="fw-bold fs-6 text-gray-800">{{ $info->institute_emp_code ?? '-' }}</span>
                        </div>
                    </div>
                @endisset
                @isset($info->society_emp_code)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted">Society Employee Code</label>
                        <div class="col-lg-7">
                            <span class="fw-bold fs-6 text-gray-800">{{ $info->society_emp_code ?? '-' }}</span>
                        </div>
                    </div>
                @endisset
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Mother Tongue</label>
                    <div class="col-lg-7">
                        <span
                            class="fw-bold fs-6 text-gray-800">{{ ucfirst($info->personal->motherTongue->name ?? '') }}</span>
                    </div>
                </div>
                @if( isset( $info->personal->dob ) && !empty( $info->personal->dob ))
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">DOB</label>
                    <div class="col-lg-7">
                        <span
                            class="fw-bold fs-6 text-gray-800">{{ commonDateFormat($info->personal->dob ?? '') }}</span>
                    </div>
                </div>
                @endif
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Phone Number</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->phone_no ?? '-' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Whatsapp Number</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->whatsapp_no ?? '-' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Emergency Number</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->emergency_no ?? '-' }}</span>
                    </div>
                </div>
                @if (isset($info->personal->marriage_date) && !empty($info->personal->marriage_date))
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted">Marriage Date</label>
                        <div class="col-lg-7">
                            <span
                                class="fw-bold fs-6 text-gray-800">{{ date('d/M/Y', strtotime($info->personal->marriage_date)) }}</span>
                        </div>
                    </div>
                @endif
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Place of Birth</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->birthPlace->name ?? '-' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Nationality</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->nationality->name ?? '-' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Religion</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->religion->name ?? '-' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Caste</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->caste->name ?? '-' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Community</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->community->name ?? '-' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Contact Address</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->contact_address ?? '-' }}</span>
                    </div>
                </div>
                <div class="row mb-7">
                    <label class="col-lg-5 fw-semibold text-muted">Permanent Address</label>
                    <div class="col-lg-7">
                        <span class="fw-bold fs-6 text-gray-800">{{ $info->personal->permanent_address ?? '-' }}</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6">

            <div class="card-body cstmzed-witpad">

                @isset($info->staffDocuments)
                    @foreach ($info->staffDocuments as $stitem)
                        <div class="row mb-7">

                            <label class="col-lg-5 fw-semibold text-muted">
                                {{ $stitem->documentType->name ?? '' }}
                            </label>

                            <div class="col-lg-7 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-800 me-2">
                                    {{ $stitem->doc_number ?? '' }}
                                </span>
                            </div>

                        </div>
                    @endforeach
                @endisset

                @isset($info->bank->bankDetails)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Bank </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->bank->bankDetails->name ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Bank Branch </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->bank->bankBranch->name ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> IFSC CODE </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->bank->bankBranch->ifsc_code ?? '-' }} </span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Account Name </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->bank->account_name ?? '-' }} </span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Account Number </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->bank->account_number ?? '-' }} </span>
                        </div>
                    </div>
                @endisset

                @isset($info->pf)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> PF Number </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->pf->ac_number ?? '-' }} </span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> PF Account Location </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->pf->lcoation ?? '-' }} </span>
                        </div>
                    </div>
                @endisset
                @isset($info->esi)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> ESI Number </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->esi->ac_number ?? '-' }} </span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> ESI Account Location </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->esi->lcoation ?? '-' }} </span>
                        </div>
                    </div>
                @endisset

                @isset($info->institute)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Institution </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6"> {{ $info->institute->name ?? '-' }}</span>
                        </div>
                    </div>
                @endisset
                @isset($info->position->department)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Department </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6">
                                {{ $info->position->department->name ?? '-' }}</span>
                        </div>
                    </div>
                @endisset
                @isset($info->position->designation)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Designation </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6">
                                {{ $info->position->designation->name ?? '-' }}</span>
                        </div>
                    </div>
                @endisset
                @isset($info->appointment->work_place)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Place of Work </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6">
                                {{ $info->appointment->work_place->name ?? '-' }}</span>
                        </div>
                    </div>
                @endisset
                @isset($info->appointment->employment_nature)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Nature of Employee </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6">
                                {{ $info->appointment->employment_nature->name ?? '-' }}</span>
                        </div>
                    </div>
                @endisset
                @isset($info->appointment->staffCategory)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Staff Category </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6">
                                {{ $info->appointment->staffCategory->name ?? '-' }}</span>
                        </div>
                    </div>
                @endisset
                @isset($info->appointment->teachingType)
                    <div class="row mb-7">
                        <label class="col-lg-5 fw-semibold text-muted"> Teaching Type </label>
                        <div class="col-lg-7 fv-row">
                            <span class="fw-bold text-gray-800 fs-6">
                                {{ $info->appointment->teachingType->name ?? '-' }}</span>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
    
    @include('pages.overview.personal.salary_details')
    @include('pages.overview.personal.appointment')
    {{-- @include('pages.overview.personal.locker_details') --}}
    @include('pages.overview.personal.medical_info')
    
</div>
