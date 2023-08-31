<div class="row g-3 mb-6 mb-xl-9">
    <div class="col-xl-3 col-lg-4 col-md-6">
        @include('pages.dashboard.noti_card._employee')
    </div>
    <div class="col-xl-3 col-lg-4 col-md-6">
        @include('pages.dashboard.noti_card._leave_approval')
    </div>
    <div class="col-xl-3 col-lg-4 col-md-6">
        @include('pages.dashboard.noti_card._birthday')
    </div>
    <div class="col-xl-3 col-lg-4 col-md-6">
        @include('pages.dashboard.noti_card._anniversary')
    </div>
    <div class="col-xl-3 col-lg-4 col-md-6">
        @include('pages.dashboard.noti_card._announcement')
    </div>
    <div class="col-xl-3 col-lg-4 col-md-6">
        @include('pages.dashboard.noti_card._doc_approval')
    </div>
</div>
<div class="row pt-4">
    <div class="col-4 pb-4">
        @include('pages.dashboard._staff_entrollment')
    </div>
    <div class="col-4 pb-4">
        @include('pages.dashboard._birthday_card')
    </div>
    <div class="col-4 pb-4">
        @include('pages.dashboard._anniversary_card')
    </div>
    <div class="col-6 pb-4">
        @include('pages.dashboard._appointment_status')
    </div>
    <div class="col-6 pb-4">
        @include('pages.dashboard._top_leave_taker')
    </div>
    <div class="col-6 pb-4">
        @include('pages.dashboard._retirement_card')
    </div>
    <div class="col-6 pb-4">
        @include('pages.dashboard._resigned_list')
    </div>
</div>
<div class="row pt-4">
    <div class="col-md-12 pb-4">
        @include('pages.dashboard._age_wise_chart')
    </div>
    <div class="col-md-6 pb-4">
        @include('pages.dashboard._gender_chart')
    </div>
    <div class="col-md-6 pb-4">
        @include('pages.dashboard._monthly_graph')
    </div> 
    <div class="col-md-12 pb-4">
        @include('pages.dashboard._leave_category')
    </div>
    <div class="col-md-12 pb-4">
        @include('pages.dashboard._salary_paid_chart')
    </div>
</div>

