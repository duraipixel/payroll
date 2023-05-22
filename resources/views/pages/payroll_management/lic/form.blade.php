<form id="lic_form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="" class="required">Insurance Company</label>
                <input type="text" name="insurance_name" id="insurance_name" class="form-control">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="" class="required">
                    Policy No
                </label>
                <input type="text" name="policy_no" id="policy_no" class="form-control">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="" class="required">
                    Policy Maturity Date
                </label>
                <input type="date" name="policy_date" id="policy_date" class="form-control">
            </div>
        </div>
        
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="required">
                    Amount
                </label>
                <input type="text" name="amount" id="amount" class="form-control price">
            </div>
        </div>
        
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="">
                    Documents
                </label>
                <div>
                    <input type="file" name="document" id="document">
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-5 float-end">
            <div class="form-group text-end">
                <button class="btn btn-sm btn-primary" type="button" onclick="return licFormSubmit()"
                    id="submit_button"> Submit
                </button>
                <a class="btn btn-sm btn-dark" href="{{ route('salary.lic') }}"> Cancel </a>
            </div>
        </div>
    </div>
</form>