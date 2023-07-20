<div class="row" id="generate-pane">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body text-center">
                <h3>  STATEMENT FOR CALCULATION OF INCOME TAX FOR THE YEAR
                    {{ $academic_data->from_year }}-{{ $academic_data->to_year }} 
                </h3>
                <div>
                    <button type="button" class="btn btn-success mt-3" onclick="generateCalculationForm()"> Click to Generate Calculation </button>
                </div>
            </div>
        </div>
    </div>
</div>