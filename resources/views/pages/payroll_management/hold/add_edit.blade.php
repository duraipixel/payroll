<div class="modal-dialog modal-dialog-centered mw-600px">
<div class="modal-content">
<div class="modal-header">
<h2>{{ isset($title) ? ucwords(str_replace(['-', '_'], ' ', $title)). ' '. date('F Y', strtotime($payroll_hold_month)) : 'Add Form' }}</h2>
<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
{!! cancelSvg() !!}
</div>
</div>
<div class="modal-body py-lg-10 px-lg-10" id="dynamic_content">
<form id="hold_form">
@csrf
<div class="w-100">
<div class="card card-flush py-0">
<div class="pt-0">
<div class="mb-10 fv-row" id="kt_ecommerce_add_product_discount_percentage">
    <input type="hidden" name="hold_month" value="{{ $payroll_hold_month }}">
    <div class="col-lg-12 mb-5">
        <label class="form-label required"> Staff </label>
        <span class="text-muted float-end ">
            Staff list only displays salaries created. 
        </span>
        <div class="d-flex">
            <select name="staff_id" autofocus id="staff_id"
                class="form-control" required>
                <option value="">-- Select staff --</option>
                @isset($staff)
                    @foreach ($staff as $item)
                        <option value="{{ $item->id }}" 
                            @if(isset($salary_detail))
                            {{$salary_detail->staff_id==$item->id ? 'selected' : '' }}@endif>
                            {{ $item->name }} - {{ $item->institute_emp_code }}
                        </option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
  <input type="hidden" name="id" value="{{$salary_detail->id ?? ''}}"/>
    <div class="col-lg-12 mb-5">
        <label class="form-label required"> Reason </label>
        <input name="hold_reason" id="hold_reason" value="{{$salary_detail->hold_reason?? ''}}" class="form-control" />
    </div>
    <div class="col-lg-12 mb-5">
        <label class="form-label"> Remarks </label>
        <textarea name="remarks" id="remarks" class="form-control" cols="30" rows="3">{{$salary_detail->remarks ?? ''}}</textarea>
    </div>

</div>
</div>
<div class="row">
<div class="col-sm-12 text-end">
    <button type="button" class="btn btn-light-dark mx-2" data-bs-dismiss="modal">
        cancel </button>
    <button type="button" class="btn btn-primary" id="hold_btn"
        onclick="return doHold()"> Hold Salary </button>
</div>
</div>
</div>
</div>

</form>
</div>
<!--end::Modal body-->
</div>
<!--end::Modal content-->
</div>
<script>
function doHold() {
event.preventDefault();
var hold_error = false;

var key_name = [
'staff_id',
'hold_reason'
];

$('.form-control,.form-select').removeClass('border-danger');

const pattern = /_/gi;
const replacement = " ";

key_name.forEach(element => {
var name_input = document.getElementById(element).value;

if (name_input == '' || name_input == undefined) {

hold_error = true;
var elementValues = element.replace(pattern, replacement);
var name_input_error =
'<div class="fv-plugins-message-container appointment-form-errors invalid-feedback"><div data-validator="notEmpty">' +
elementValues.toUpperCase() + ' is required</div></div>';
// $('#' + element).after(name_input_error);
$('#' + element).addClass('border-danger')
$('#' + element).focus();
}
});

if (!hold_error) {

loading();
var forms = $('#hold_form')[0];
var formData = new FormData(forms);
$('#hold_btn').attr('disabled', true);
const kycResponse = fetch("{{ route('holdsalary.save') }}", {
method: 'POST',
body: formData
})
.then((response) => response.json())
.then((data) => {
unloading();
$('#hold_btn').attr('disabled', false);
if (data.error == 1) {
var err_message = '';
if (data.message) {

toastr.error("Error", data.message);

// data.message.forEach(element => {
//     err_message += '<p>' + element + '</p>';
// });
// toastr.error("Error", err_message);
}
return false;
} else {
toastr.success("Success", 'Salary Holded successfully');
$('#kt_dynamic_app').modal('hide');
setTimeout(() => {
dtTable.draw();
}, 500);
return true;
}

});
return kycResponse;

} else {
return true;
}
}
</script>
