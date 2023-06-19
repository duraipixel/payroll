<hr>
<div class="row mt-3">
    <div class="col-sm-12 m-auto">

        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="row">
                @isset($salary_heads)
                    @foreach ($salary_heads as $item)
                        <div class="col-sm-6">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button"
                                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapseOne">
                                        {{ $item->name }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <div class="list-group">
                                            @if (isset($item->fields) && !empty($item->fields))
                                                @foreach ($item->fields as $item_fields)
                                                    @if (isset($salary_info) && !empty($salary_info))
                                                        @php
                                                            $old_data = getSalarySelectedFields($salary_info->staff_id, $salary_info->id, $item_fields->id);
                                                        @endphp
                                                    @endif
                                                    <label class="list-group-item p-3 d-flex justify-content-between">
                                                        <input class="form-check-input me-1" type="checkbox"
                                                            data-id="{{ str_replace(' ', '_', $item_fields->short_name) }}"
                                                            onchange="getInputValue(this)" value=""
                                                            @if (isset($old_data) && !empty($old_data)) checked @endif>
                                                        <span class="px-3 w-50"> {{ $item_fields->name }}
                                                            ({{ $item_fields->short_name }})
                                                            @if (isset($item_fields->field_items) && count($item_fields->field_items) > 0)
                                                                [
                                                                @foreach ($item_fields->field_items as $sfield_items)
                                                                    {{ $sfield_items->field_name }}*{{ $sfield_items->percentage }}%
                                                                @endforeach
                                                                ]
                                                            @endif
                                                            @if ($item_fields->short_name == 'LIC' || strtolower($item_fields->short_name) == 'bank loan' )
                                                                <i class="fa fa-exclamation-circle loans_info"
                                                                    role="button"
                                                                    data-id="{{ $item_fields->short_name }}"></i>
                                                            @endif
                                                        </span>
                                                        <input type="text" name="amount_{{ $item_fields->id }}"
                                                            onkeyup="getNetSalary(this.value)"
                                                            id="{{ str_replace(' ', '_', $item_fields->short_name) }}_input"
                                                            value="{{ $old_data->amount ?? '' }}"
                                                            @if ($item_fields->no_of_numerals) maxlength="{{ $item_fields->no_of_numerals }}" @endif
                                                            class="border border-2 float-end text-end price @if ($item->id == '1') add_input @else minus_input @endif @if (isset($item_fields->field_items) && count($item_fields->field_items) > 0) automatic_calculation @endif"
                                                            data-id=""
                                                            @if (isset($old_data) && !empty($old_data)) @else disabled @endif>
                                                    </label>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-sm-12">

                        <h2 class="accordion-header netsalary" id="panelsStayOpen-headingOne">
                            <input type="hidden" name="net_salary" id="net_salary" value="">
                            Net Salary
                            <span class="float-end">₹ <span
                                    id="net_salary_text">{{ $salary_info->net_salary ?? '0.00' }}</span></span>
                        </h2>
                    </div>
                @endisset


            </div>
            <div class="row mt-3">
                <div class="col-sm-4 px-10">

                    <div class="form-group">
                        <label for="" class="fs-5 required"> Effective From </label>
                        <div class="mt-3">
                            <input type="date" name="effective_from" id="effective_from" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group mt-5">
                        <label for="" class="fs-5"> Employee Remarks </label>
                        <div class="mt-3">
                            <textarea name="employee_remarks" class="form-control" id="employee_remarks" cols="30" rows="3" placeholder="This will be visible to employee"></textarea>
                        </div>
                    </div>

                </div>
              
                <div class="col-sm-4 px-10">
                    <div class="form-group">
                        <label for="" class="fs-5 required"> Payout Month </label>
                        <div class="mt-3">
                            <select name="payout_month" id="payout_month" class="form-control" required>
                                <option value="">-select-</option>
                                @if( isset( $payout_year ) && !empty( $payout_year ) )
                                    @foreach ($payout_year as $item)
                                        <option value="{{ $item }}"> {{ date('F Y', strtotime($item)) }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-5 text-end">
                <button class="btn btn-primary btn-sm" type="submit"> Submit & Lock </button>
                <a class="btn btn-dark btn-sm"
                    href="@if (isset($staff_id) && !empty($staff_id)) {{ route('staff.register', ['id' => $staff_id]) }} @else {{ route('salary.creation') }} @endif">
                    Cancel </a>
            </div>

        </div>
        <script>
            $(document).ready(function() {

                $(document).on('mouseenter', '.loans_info', function(event) {
                    var staff_id = $('#staff_id').val();
                    var data_id = $(this).data('id');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('show.loans.info') }}",
                        type: 'POST',
                        data: {
                            staff_id: staff_id,
                            data_id: data_id
                        },
                        beforeSend: function() {

                        },
                        success: function(res) {
                            $('#kt_dynamic_app').modal('show');
                            $('#kt_dynamic_app').html(res);
                        }
                    });

                }).on('mouseleave', '.loans_info', function() {
                    console.log('outside');
                });
            })
        </script>
    </div>
