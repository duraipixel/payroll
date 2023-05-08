
<div class="fv-row form-group mb-3 row">
    <div class="col-sm-5">
        <label class="form-label required" for="">
            Address during leave period
        </label>
    </div>
    <div class="col-sm-7">
        <textarea name="address" id="address" cols="30" rows="e" class="form-control">{{ $info->address ?? '' }}</textarea>
    </div>
</div>
<script>
    $('#el_eol_form').removeClass('d-none');
</script>