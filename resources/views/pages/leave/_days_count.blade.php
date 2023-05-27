<ul class="list-group">
    <li class="list-group-item p-4 active">{{ getInstituteInfo(session()->get('staff_institute_id'))->name ?? '' }}</li>
    <li class="list-group-item p-4 d-flex align-items-center">
        <label for="" class="fs-5 w-75">
            Working Days
        </label>
        <span class="fw-bold fs-3 float-end px-3"> {{ $working_days ?? 0 }}</span>
    </li>
    <li class="list-group-item p-4 d-flex align-items-center">
        <label for="" class="fs-5 w-75">
            Holidays
        </label>
        <span class="fw-bold fs-3 float-end px-3"> {{ $holidays ?? 0 }}</span>
    </li>
    <li class="list-group-item p-4 d-flex align-items-center">
        <label for="" class="fs-5 w-75">
            WeekOff
        </label>
        <span class="fw-bold fs-3 float-end px-3"> {{ $week_off ?? 0 }}</span>
    </li>
</ul>
