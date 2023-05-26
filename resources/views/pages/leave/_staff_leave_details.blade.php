<ul class="list-group">
    <li class="list-group-item p-2 active">{{ $user->institute->name ?? '' }}</li>
    <li class="list-group-item p-2 d-flex align-items-center">
        <label for="" class="fs-5 w-75">
            Working Days for {{ $month }}
        </label>
        <span class="fw-bold fs-3 float-end px-3"> {{ $working_days ?? 0 }}</span>
    </li>
    <li class="list-group-item p-2 d-flex align-items-center">
        <label for="" class="fs-5 w-75">
            Holidays for {{ $month }}
        </label>
        <span class="fw-bold fs-3 float-end px-3"> {{ $holidays ?? 0 }}</span>
    </li>
    @if( isset( $user->position->attendance_scheme ) && !empty( $user->position->attendance_scheme ) ) 
    <li class="list-group-item p-2 active">{{ $user->position->attendance_scheme->name ?? '' }}</li>
    <li class="list-group-item p-2 d-flex align-items-center">
        <label for="" class="fs-5 w-75">
            Total Hours per Day
        </label>
        
        <span class="fw-bold fs-3 float-end px-3"> {{ $user->position->attendance_scheme->totol_hours ?? '' }}</span>
    </li>
    <li class="list-group-item p-2 d-flex align-items-center">
        <label for="" class="fs-5 w-50">
            Start Time
        </label>
        <span class="fw-bold fs-3 float-end w-50 px-3 text-end"> {{  isset($user->position->attendance_scheme->start_time) ? \Carbon\Carbon::parse($user->position->attendance_scheme->start_time)->format('H:i A') : '-' }}</span>
    </li>
    <li class="list-group-item p-2 d-flex align-items-center">
        <label for="" class="fs-5 w-50">
            End Time
        </label>
        <span class="fw-bold fs-3 float-end w-50 px-3 text-end"> {{  isset($user->position->attendance_scheme->end_time) ? \Carbon\Carbon::parse($user->position->attendance_scheme->end_time)->format('h:i A') : '-' }}</span>
    </li>
    @endif
    <li class="list-group-item p-2 active"> Leave Details </li>
    @php
        $total_leave_taken = 0;
    @endphp
    @if (isset($leaves) && !empty($leaves))
        @foreach ($leaves as $item)
        @php
            $total_leave_taken += $item->leaves;
        @endphp
        <li class="list-group-item p-2 d-flex align-items-center">
            <label for="" class="fs-5 w-50">
                {{ $item->leave_category }}
            </label>
            <span class="fw-bold fs-3 float-end w-50 text-end px-3"> {{ $item->leaves ?? 0 }}</span>
        </li>
        @endforeach
        <li class="list-group-item p-2 d-flex align-items-center">
            <label for="" class="fs-5 w-50">
                Total Taken Leaves
            </label>
            <span class="fw-bold fs-3 float-end w-50 text-end px-3"> {{ $total_leave_taken ?? 0 }}</span>
        </li>
    @endif
</ul>
