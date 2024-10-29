<div class="row">
    <div class="col-sm-6">
        <label for=""> Common Remarks for All Employees ( <span class="small text-muted">This will overwrite every staff remarks </span> ) </label>
        <div>
            <textarea name="common_remarks" id="common_remarks" cols="30" rows="3" class="form-control"></textarea>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label for=""> Salary Month </label>
            <div>
                @php
                    $months = 4;
                    $dates =$search_date;
                @endphp
                <select name="salary_month" id="salary_month" class="form-control form-control-sm">
                    @for ($i = 0; $i < 12; $i++)
                        @php
                            $dates = date('Y-m-d', strtotime($dates . '+1 months'));
                        @endphp
                        <option value="{{ $dates }}" @if ($salary_date == $dates) selected="selected" @endif>
                            {{ date('M Y', strtotime($dates)) }} 
                        </option>
                        @php
                            if ($months == 12) {
                                $months = 1;
                            } else {
                                $months++;
                            }
                        @endphp
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4 text-end mt-3 position-relative">
        <div class="position-absolute" style="right: 0px;bottom:0px;">
            <a href="{{ route('earnings.index', ['type' => $page_type ]) }}" class="btn btn-dark btn-sm"> 
                Cancel 
            </a>
            <button class="btn btn-success btn-sm" type="button" id="earning_btn" onclick="submitEarningsStaff()">Save</button>
        </div>
    </div>
    
</div>

