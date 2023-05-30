<div class="row g-6 g-xl-9 mb-6 mb-xl-9">

    <div class="col-md-6 col-lg-2">
        <div class="card h-100 cstmzed">
            @include('pages.dashboard.noti_card._employee')
        </div>
    </div>

    <div class="col-md-6 col-lg-2">
        <div class="card h-100 cstmzed">
            @include('pages.dashboard.noti_card._leave_approval')
        </div>
    </div>

    <div class="col-md-6 col-lg-2">
        <div class="card h-100 cstmzed">
            @include('pages.dashboard.noti_card._birthday')
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
        <div class="card h-100 cstmzed">
            @include('pages.dashboard.noti_card._anniversary')
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
        <div class="card h-100 cstmzed">
            @include('pages.dashboard.noti_card._announcement')
        </div>
    </div>
    <div class="col-md-6 col-lg-2">
        <div class="card h-100 cstmzed">
            @include('pages.dashboard.noti_card._doc_approval')
        </div>
    </div>

</div>
<div class="row g-6 g-xl-9">
    <div class="col-lg-6 col-xxl-4">
        @include('pages.dashboard._staff_entrollment')
    </div>
    <div class="col-lg-6 col-xxl-4">
        @include('pages.dashboard._birthday_card')
    </div>
    <div class="col-lg-6 col-xxl-4">
        @include('pages.dashboard._anniversary_card')
    </div>


    <div class="row g-6 g-xl-9">
        <div class="col-lg-6 col-xxl-4">
            {{-- @include('pages.dashboard._anniversary_card') --}}
            @include('pages.dashboard._age_wise_chart')
            
        </div>
        <div class="col-lg-6 col-xxl-4">
            {{-- @include('pages.dashboard._pending_approval') --}}
            @include('pages.dashboard._gender_chart')
        </div>
        <div class="col-lg-6 col-xxl-4">
            {{-- @include('pages.dashboard._announcement') --}}
            @include('pages.dashboard._monthly_graph')
        </div>

        <div class="col-lg-6 col-xxl-4">
            @include('pages.dashboard._appointment_status')
        </div>
        <div class="col-lg-6 col-xxl-4">
            @include('pages.dashboard._top_leave_taker')
        </div>
        <div class="col-lg-6 col-xxl-4">
            @include('pages.dashboard._leave_category')
        </div>
        <div class="col-lg-12 col-xxl-12">
            @include('pages.dashboard._salary_paid_chart')
        </div>

    </div>
</div>
