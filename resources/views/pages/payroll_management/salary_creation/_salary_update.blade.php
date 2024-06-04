<div class="payheads-pane p-3 border border-2">
  <form id="add_new_revision">
    @csrf
    <input type="hidden" name="from" value="ajax_revision">
    <div class="d-flex w-100 m-2 p-2 bg-primary text-white">
      <div class="w-30">
        Salary Heads
      </div>
      <div class="w-35 text-end">
        Previous Pay
      </div>
      <div class="w-35 text-end">
        Revision Pay
      </div>
    </div>
    <div class="d-flex w-100 m-2 p-2 bg-secondary text-muted">
      <div class="w-100">
        Earnings
      </div>
    </div>
    @if (isset($earnings_data) && count($earnings_data) > 0)
    @foreach ($earnings_data as $item)
    <div class="d-flex w-100 m-2 p-2 payrow">
      <div class="w-30 d-flex">
        <div class="me-2">
          <input class="form-check-input me-1" type="checkbox"
          data-id="{{ str_replace(' ', '_', $item->short_name) }}" onchange="getInputValue(this)"
          value="" @if (isset($old_data) && !empty($old_data)) checked @endif>
        </div>
        <div>
          {{ $item->name ?? '' }}
          <div class="text-muted small">
            @if (isset($item->field_items) && !empty($item->field_items))
            [
            {{ $item->field_items->field_name }}*{{ $item->field_items->percentage+SalaryPrecentage($current_pattern->id, $item->id)  }}%
            ]
            @endif
          </div>
        </div>
      </div>
      @if (isset($item->field_items) && !empty($item->field_items))
      <div class="w-30 d-flex">
        <div>
          <input type="text" name="tax_{{$item->id}}" id="addtional_tax_{{$item->id}}" style="width: 100px" onkeyup="handleChange('{{previousSalaryData($current_pattern->id, $item->id)->amount??''}}','{{$item->field_items->percentage+SalaryPrecentage($current_pattern->id, $item->id)}}','{{$item->id}}')" disabled>
       <input type="hidden" name="precentage_{{ $item->id }}" value="{{SalaryPrecentage($current_pattern->id, $item->id)}}">
        </div>
        &nbsp;&nbsp;
        <div>

          <label id="percentageLabel_{{$item->id}}"> </label> 
        </div>
      </div>
      @else
      <div class="w-30 d-flex">
        <div>
        </div>&nbsp;&nbsp;
        <div>
        </div>
      </div>
      @endif
      <div class="w-35 text-end">
        <label for=""
        class="">{{ previousSalaryData($current_pattern->id, $item->id)->amount ?? '0.00' }}</label>
      </div>
      <div class="w-35 text-end">
        <input type="text" name="amount_{{ $item->id }}"
        id="{{ str_replace(' ', '_', $item->short_name) }}_input"
        onkeyup="getNetSalary(this.value, '{{ $item->id }}', '{{ $item->short_name }}')"
        @if ($item->no_of_numerals) maxlength="{{ $item->no_of_numerals }}" @endif
        class="add_input form-control form-control-sm w-200px float-end text-end" disabled>
      </div>
    </div>
    @endforeach
    @endif
    <div class="d-flex w-100 m-2 p-2 bg-secondary text-muted">
      <div class="w-100">
        Deductions
      </div>
    </div>
    @if (isset($deduction_data) && count($deduction_data) > 0)
    @foreach ($deduction_data as $item)
    <div class="d-flex w-100 m-2 p-2 payrow">
      <div class="w-30 d-flex">
        <div class="me-2">

          <input class="form-check-input me-1" type="checkbox"
          data-id="{{ str_replace(' ', '_', $item->short_name) }}" onchange="getInputValue(this)"
          value="" @if (isset($old_data) && !empty($old_data)) checked @endif>
        </div>
        <div>

          {{ $item->name ?? '' }}
          <div class="text-muted small">

            @if (isset($item->field_items) && !empty($item->field_items))
            [

            {{ $item->field_items->field_name }}*{{ $item->field_items->percentage+SalaryPrecentage($current_pattern->id, $item->id)  }}%
            ]
            @endif
          </div>
        </div>
      </div>
      @if (isset($item->field_items) && !empty($item->field_items))
      <div class="w-30 d-flex">
        <div>
          <input type="text" name="tax_{{$item->id}}" id="addtional_tax_{{$item->id}}" style="width: 100px" onkeyup="handleChange('{{previousSalaryData($current_pattern->id, $item->id)->amount??''}}','{{$item->field_items->percentage+SalaryPrecentage($current_pattern->id, $item->id)}}','{{$item->id}}')">
           <input type="hidden" name="precentage_{{ $item->id }}" value="{{SalaryPrecentage($current_pattern->id, $item->id)}}" disabled>
        </div>
        &nbsp;&nbsp;
        <div>

          <label id="percentageLabel_{{$item->id}}"> </label> 
        </div>
      </div>
      @else
      <div class="w-30 d-flex">
        <div>
        </div>&nbsp;&nbsp;
        <div>
        </div>
      </div>
      @endif
      <div class="w-35 text-end">
        <label for=""
        class="">{{ previousSalaryData($current_pattern->id, $item->id)->amount ?? '0.00' }}</label>
      </div>
      <div class="w-35 text-end">
        <input type="text" name="amount_{{ $item->id }}"
        id="{{ str_replace(' ', '_', $item->short_name) }}_input"
        onkeyup="getNetSalary(this.value, '{{ $item->id }}', '{{ $item->short_name }}')"
        @if ($item->no_of_numerals) maxlength="{{ $item->no_of_numerals }}" @endif
        class="minus_input form-control form-control-sm w-200px float-end text-end" disabled>
      </div>
    </div>
    @endforeach
    @endif
    <div class="d-flex w-100 m-2 p-2 payrow">
      <div class="w-30">
        Net Salary
      </div>
      <div class="w-35 text-end">
        <label for="" class="fw-bold fs-5">{{ $current_pattern->net_salary }}</label>
      </div>
      <div class="w-35 text-end">
        <input type="text" class="form-control form-control-sm w-200px float-end text-end numberonly"
        name="net_salary" id="net_salary" value="">
      </div>
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
            <textarea name="employee_remarks" class="form-control" id="employee_remarks" cols="30" rows="3"
            placeholder="This will be visible to employee"></textarea>
          </div>
        </div>

      </div>

      <div class="col-sm-4 px-10">
        <div class="form-group">
          <label for="" class="fs-5 required"> Payout Month </label>
          <div class="mt-3">
            <select name="payout_month" id="payout_month" class="form-control" required>
              <option value="">-select-</option>
              @if (isset($payout_year) && !empty($payout_year))
              @foreach ($payout_year as $item)
              <option value="{{ $item }}"> {{ date('F Y', strtotime($item)) }}
              </option>
              @endforeach
              @endif
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group mt-5 text-end">
      <button class="btn btn-primary btn-sm" type="button" id="submit_button" onclick="return newRevisionFormSubmit()"> Submit & Lock </button>
      <a class="btn btn-dark btn-sm" href="{{ route('salary.creation') }}">
        Cancel
      </a>
    </div>
  </form>
</div>
<script>
  function handleChange(previousSalaryAmount, percentage, id) {
    var tax = previousSalaryAmount / percentage;
    var addtional_tax = $('#addtional_tax_'+id).val();
    var new_tax = tax * addtional_tax;
    var label = document.getElementById("percentageLabel_" + id);
    label.innerText = "+" + new_tax.toFixed(2);
    var textBox = document.getElementsByName("amount_" + id)[0];
    var total = parseFloat(previousSalaryAmount) + parseFloat(new_tax);
    textBox.value = total.toFixed(2);
    console.log(tax+' '+new_tax+' ' +total +' '+addtional_tax);
  }
  function newRevisionFormSubmit() {

    var form = document.getElementById('add_new_revision');
    const submitButton = document.getElementById('submit_button');

    event.preventDefault();
    var revision_form_error = false;

    var key_name = [
      'effective_from',
      'payout_month',
      'net_salary',
      ];

    $('.revision-form-errors').remove();
    $('.form-control,.form-select').removeClass('border-danger');

    const pattern = /_/gi;
    const replacement = " ";

    key_name.forEach(element => {
      var name_input = document.getElementById(element).value;

      if (name_input == '' || name_input == undefined) {

        revision_form_error = true;
        var elementValues = element.replace(pattern, replacement);
        var name_input_error =
        '<div class="fv-plugins-message-container revision-form-errors invalid-feedback"><div data-validator="notEmpty">' +
        elementValues.toUpperCase() + ' is required</div></div>';
// $('#' + element).after(name_input_error);
        $('#' + element).addClass('border-danger')
        $('#' + element).focus();
      }
    });

// Validate form before submit

    if (!revision_form_error) {
      submitButton.disabled = true;
      let staff_id = $('#staff_id').val();
      var forms = $('#add_new_revision')[0];
      var formData = new FormData(forms);
      formData.append('staff_id', staff_id);

      $.ajax({
        url: "{{ route('salary.creation_add') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {

          submitButton.disabled = false;

          if (res.error == 1) {
            if (res.message) {
              res.message.forEach(element => {
                toastr.error("Error",
                  element);
              });
            }
          } else {
            toastr.success(
              "Salary revision added successfully"
              );

            getSalaryHeadFields(staff_id);

          }
        }
      })

    }

  }
</script>
