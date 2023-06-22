<div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10 text-end my-2 w-700px">
        <button class="btn btn-primary" type="button" onclick="return addNewRevision()">
            Add New Revision
        </button>
        <button class="btn btn-info">
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
                        <li role="button" @if ($item->is_current == 'yes') class="active" @endif>
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
                staff_id:staff_id
            },
            beforeSend: function() {
                // set loader here
            },
            success: function(res) {

               $('#payout-salary-revision').html( res );
            }
        });
    }
</script>
