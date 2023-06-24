@if (isset($staff_details) && !empty($staff_details))
    <div class="row">
        <div class="col-sm-12">
            <div class="mb-2 d-flex justify-content-between">
                <div class="p-2 px-4 border border-2 w-200px">
                    <div class="fw-bold">
                        Staff Name:
                    </div>
                    <div class="badge badge-light-info fs-6">
                        {{ $staff_details->name }}
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px">
                    <div class="fw-bold">
                        Society Code:
                    </div>
                    <div class="badge badge-light-success fs-6">
                        {{ $staff_details->society_emp_code ?? 'n/a' }}
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px">
                    <div class="fw-bold">
                        Designation
                    </div>
                    <div class="badge badge-light-warning fs-6">
                        {{ $staff_details->position->designation->name ?? 'n/a' }}
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px">
                    <div class="fw-bold">
                        Nature of Work
                    </div>
                    <div class="badge badge-light-primary fs-6">
                        {{ $staff_details->appointment->employment_nature->name ?? 'n/a' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
@endif
<div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10 text-start my-2 w-700px">
        <button class="btn btn-primary" type="button" onclick="return addNewRevision()">
            Add New Revision
        </button>
        <button class="btn btn-info" onclick="return updateCurrentSalary()">
            Update Salary
        </button>
    </div>
</div>
<div class="row">


    <div class="col-sm-2">
        <div class="pay-salary-month">
            <ul type="none">
                @if (isset($all_salary_patterns) && count($all_salary_patterns))
                    @foreach ($all_salary_patterns as $item)
                        <li data-id="{{ $item->payout_month }}" role="button"
                            class="payout-month @if ($item->is_current == 'yes') active @endif"
                            onclick="return getSalaryPatterList('{{ $item->payout_month }}', this)">
                            {{ date('F Y', strtotime($item->payout_month)) }}
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="col-sm-10" id="payout-salary-revision">
        @include('pages.payroll_management.salary_creation._salary_view')
        {{-- @include('pages.payroll_management.salary_creation._salary_update') --}}
    </div>
</div>


<script>
    function addNewRevision() {

        var staff_id = $('#staff_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('salary.update.pattern') }}",
            type: 'POST',
            data: {
                staff_id: staff_id
            },
            beforeSend: function() {
                $('#payout-salary-revision').addClass('blur_loading_3px');
            },
            success: function(res) {
                $('#payout-salary-revision').removeClass('blur_loading_3px');
                $('#payout-salary-revision').html(res);
            }
        });
    }

    function getSalaryPatterList(payout_date, elem) {

        var staff_id = $('#staff_id').val();
        $('.payout-month').removeClass('active');

        $(elem).addClass('active');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('salary.pattern.list') }}",
            type: 'POST',
            data: {
                staff_id: staff_id,
                payout_date: payout_date
            },
            beforeSend: function() {
                $('#payout-salary-revision').addClass('blur_loading_3px');
            },
            success: function(res) {

                $('#payout-salary-revision').html(res);
                $('#payout-salary-revision').removeClass('blur_loading_3px');

            }
        });
    }

    function updateCurrentSalary() {

        let payout_month = $('.payout-month.active').data('id');
        let staff_id = $('#staff_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('salary.update.current.pattern') }}",
            type: 'POST',
            data: {
                staff_id: staff_id,
                payout_date: payout_month
            },
            beforeSend: function() {
                $('#payout-salary-revision').addClass('blur_loading_3px');
            },
            success: function(res) {

                $('#payout-salary-revision').html(res);
                $('#payout-salary-revision').removeClass('blur_loading_3px');

            }
        });

    }
</script>
