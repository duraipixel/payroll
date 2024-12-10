@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    @include('pages.overview.overview_card')
    <div class="card pt-2 mb-6 mb-xl-9">
        <div class="card-header border-0">
            <div class="card-toolbar m-0">
                <!--begin::Tab nav-->
                <ul class="nav nav-stretch fs-5 fw-bolder nav-line-tabs nav-line-tabs-2x border-transparent"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_year_tab" class="nav-link text-active-primary  active"
                            data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_1"
                            aria-selected="True">Overview</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2019_tab" class="nav-link text-active-primary ms-3"
                            data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_2"
                            aria-selected="false">Personal Info</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2018_tab" class="nav-link text-active-primary ms-3"
                            data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_3"
                            aria-selected="false">Family Info</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2017_tab" class="nav-link text-active-primary"
                            data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_4"
                            aria-selected="false">Academics Info</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2016_tab" class="nav-link text-active-primary"
                            data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_5"
                            aria-selected="false">Leave Info</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2020_tab" class="nav-link text-active-primary"
                            data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_9"
                            aria-selected="false">Document Info</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2015_tab" class="nav-link text-active-primary"
                            data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_6"
                            aria-selected="false">Utilities</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2014_tab" class="nav-link text-active-primary"
                            data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_7"
                            aria-selected="false">Others</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_referrals_2024_tab" class="nav-link text-active-primary" data-bs-toggle="tab"
                            role="tab" href="#kt_customer_details_invoices_8" aria-selected="false">Change
                            Password</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body pt-0">
            <br>
            <div id="kt_referred_users_tab_content" class="tab-content">
               <div id="kt_customer_details_invoices_1" class="py-0 tab-pane fade active show" role="tabpanel">
                    @include('pages.overview.overview.index')
                </div>
                <div id="kt_customer_details_invoices_2" class="py-0 tab-pane fade" role="tabpanel">
                    @include('pages.overview.personal.index')
                </div>
                <div id="kt_customer_details_invoices_3" class="py-0 tab-pane fade" role="tabpanel">
                    @include('pages.overview.family.index')
                </div>
                <div id="kt_customer_details_invoices_4" class="py-0 tab-pane fade" role="tabpanel">
                    @include('pages.overview.academic.index')
                </div>
                <div id="kt_customer_details_invoices_5" class="py-0 tab-pane fade" role="tabpanel">
                    @include('pages.overview.attendance.index')
                </div>
                <div id="kt_customer_details_invoices_9" class="py-0 tab-pane fade" role="tabpanel">
                    @include('pages.overview.document.index')
                </div>
                <div id="kt_customer_details_invoices_6" class="py-0 tab-pane fade" role="tabpanel">
                    @include('pages.overview.utilitites.index')
                </div>
                <div id="kt_customer_details_invoices_7" class="py-0 tab-pane fade" role="tabpanel">
                    @include('pages.overview.others.index')
                </div>
                <div id="kt_customer_details_invoices_8" class="py-0 tab-pane fade" role="tabpanel">
                    @include('pages.overview.password.form')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
{{-- <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script> --}}

@endsection
