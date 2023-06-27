<form class="" id="it_slab_form">
    @csrf

    <div class="row form-group ">
        <div class="col-md-6">
            <label class="form-label required" for="">
                Tax Scheme
            </label>
            <div>
                <select name="scheme_id" id="scheme_id" class="form-input w-100">
                    <option value="">--select--</option>
                    @if (isset($tax_scheme) && !empty($tax_scheme))
                        @foreach ($tax_scheme as $item)
                        <option value="{{ $item->id }}" @if( isset( $details[0]->scheme_id ) && $details[0]->scheme_id == $item->id ) selected @endif>{{ $item->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <input type="hidden" name="slug" value="{{ $details[0]->slug ?? '' }}">
        <div class="col-md-6">
            <label class="form-label required" for="">
                Slab Amount
            </label>
            <div>
                <input type="text" name="slab_amount" id="slab_amount" value="{{ $details[0]->slab_amount ?? '' }}"
                    class="form-input price" required>
            </div>
        </div>
        <div class="col-md-12 mt-3" id="tax_slab_row">
            @if (isset($details) && !empty($details))
                @foreach ($details as $item)
                    <div class="d-flex justify-content-between border border-2 p-3 slab_tax_each_row">
                        <div class="form-group w-25">
                            <label for="">From Amount</label>
                            <div>
                                <input type="text" name="from_amount[]"
                                    value="{{ $item->from_amount ? (int) $item->from_amount : '' }}" id="from_amount"
                                    required class="form-input price ">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="">To Amount</label>
                            <div>
                                <input type="text" name="to_amount[]" id="to_amount"
                                    value="{{ $item->to_amount ? (int) $item->to_amount : '' }}" required
                                    class="form-input price ">
                            </div>
                        </div>
                        <div class="form-group w-100px">
                            <label class="" for="">Percentage</label>
                            <div>
                                <input type="text" name="percentage[]" required id="percentage"
                                    class="form-input price w-100 text-end"
                                    value="{{ $item->percentage ? (int) $item->percentage : '' }}">

                            </div>
                        </div>
                        <div class="mt-3">
                            <i class="fa fa-close btn btn-sm btn-danger" onclick="return removeSlabRow(this)"></i>
                        </div>
                    </div>
                @endforeach
            @else
                @for ($i = 0; $i < 6; $i++)
                    <div class="d-flex justify-content-between border border-2 p-3 slab_tax_each_row">
                        <div class="form-group w-25">
                            <label for="">From Amount</label>
                            <div>
                                <input type="text" name="from_amount[]" id="from_amount" required
                                    class="form-input price ">
                            </div>
                        </div>
                        <div class="form-group w-25">
                            <label for="">To Amount</label>
                            <div>
                                <input type="text" name="to_amount[]" id="to_amount" required
                                    class="form-input price ">
                            </div>
                        </div>
                        <div class="form-group w-100px">
                            <label class="" for="">Percentage</label>
                            <div>
                                <input type="text" name="percentage[]" required id="percentage"
                                    class="form-input price w-100 text-end">
                            </div>
                        </div>
                        <div class="mt-3">
                            <i class="fa fa-close btn btn-sm btn-danger" onclick="return removeSlabRow(this)"></i>
                        </div>
                    </div>
                @endfor
            @endif

        </div>
        <div class="mt-2">
            <button class="btn btn-sm btn-light-success" onclick="return addTaxNewRow()"> Add new row </button>
        </div>
    </div>

    <div class="form-group text-end mt-3">
        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
        <button type="submit" class="btn btn-primary" id="form-submit-btn">
            <span class="indicator-label">
                Submit
            </span>
            <span class="indicator-progress">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
</form>

<script>
    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });

    var slab_row = `<div class="d-flex justify-content-between border border-2 p-3 slab_tax_each_row">
                    <div class="form-group w-25">
                        <label for="">From Amount</label>
                        <div>
                            <input type="text" name="from_amount[]" id="from_amount" required class="form-input price ">
                        </div>
                    </div>
                    <div class="form-group w-25">
                        <label for="">To Amount</label>
                        <div>
                            <input type="text" name="to_amount[]" id="to_amount" required class="form-input price ">
                        </div>
                    </div>
                    <div class="form-group w-100px">
                        <label class="" for="">Percentage</label>
                        <div>
                            <input type="text" name="percentage[]" required id="percentage" class="form-input text-end price w-100 ">
                        </div>
                    </div>
                    <div class="mt-3">
                        <i class="fa fa-close btn btn-sm btn-danger" onclick="return removeSlabRow(this)"></i>
                    </div>
                </div>`;

    $('#it_slab_form').submit(function() {

        event.preventDefault();
        console.log('running');

        var formData = $('#it_slab_form').serialize();
        $.ajax({
            url: "{{ route('it.tabulation.save') }}",
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#form-submit-btn').attr('disabled', true);
            },
            success: function(res) {
                $('#form-submit-btn').attr('disabled', false);
                if (res.error == 1) {
                    if (res.message) {
                        toastr.error("Error",
                            res.message);

                    }
                } else {
                    toastr.success('Success', res.message)
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            }
        })
    })

    function addTaxNewRow() {
        $('#tax_slab_row').append(slab_row);
    }

    function removeSlabRow(element) {
        var child = element.closest('.slab_tax_each_row').remove();
    }

    $('#slab_amount').keyup(function() {
        let amount = $(this).val();

        var start_amount = 0;
        var end_amount = parseInt(amount);
        var tab_amount = [];
        for (let index = 0; index < 6; index++) {

            let data = {
                "from_amount": start_amount,
                "to_amount": end_amount
            };
            start_amount = (end_amount + 1);
            end_amount = (end_amount + parseInt(amount));
            tab_amount.push(data);

        }
        if (tab_amount.length > 0) {
            var slab_html = '';
            for (let index = 0; index < tab_amount.length; index++) {

                slab_html += `<div class="d-flex justify-content-between border border-2 p-3 slab_tax_each_row">
                    <div class="form-group w-25">
                        <label for="">From Amount</label>
                        <div>
                            <input type="text" name="from_amount[]" id="from_amount" value="${tab_amount[index].from_amount}" required class="form-input price ">
                        </div>
                    </div>
                    <div class="form-group w-25">
                        <label for="">To Amount</label>
                        <div>
                            <input type="text" name="to_amount[]" id="to_amount" value="${tab_amount[index].to_amount}" required class="form-input price ">
                        </div>
                    </div>
                    <div class="form-group w-100px">
                        <label class="" for="">Percentage</label>
                        <div>
                            <input type="text" name="percentage[]" required id="percentage" class="form-input text-end price w-100 ">
                        </div>
                    </div>
                    <div class="mt-3">
                        <i class="fa fa-close btn btn-sm btn-danger" onclick="return removeSlabRow(this)"></i>
                    </div>
                </div>`
            }
            $('#tax_slab_row').html(slab_html);

        }

    })
</script>
