<div class="row">

    <div class="col-sm-2">
        <div class="pay-salary-month">
            <ul type="none">
                <li role="button" class="active">
                    April 2023
                </li>
                <li role="button">
                    May 2023
                </li>
                <li role="button">
                    June 2023
                </li>
                <li role="button">
                    July 2023
                </li>
            </ul>
        </div>
    </div>
    <div class="col-sm-10">
        <div class="payheads-pane p-3 border border-2">
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
            @for ($i = 0; $i < 5; $i++)
                
            <div class="d-flex w-100 m-2 p-2 payrow">
                <div class="w-30">
                    Earnings
                </div>
                <div class="w-35 text-end">
                    <input type="text" name="previous_head" id="">
                </div>
                <div class="w-35 text-end">
                    <input type="text" name="current_head" id="">
                </div>
            </div>
            @endfor
            <div class="d-flex w-100 m-2 p-2 bg-secondary text-muted">
                <div class="w-100">
                    Deductions
                </div>
            </div>
            @for ($i = 0; $i < 5; $i++)
                
            <div class="d-flex w-100 m-2 p-2 payrow">
                <div class="w-30">
                    Earnings
                </div>
                <div class="w-35 text-end">
                    <input type="text" name="previous_head" id="">
                </div>
                <div class="w-35 text-end">
                    <input type="text" name="current_head" id="">
                </div>
            </div>
            @endfor
            <div class="d-flex w-100 m-2 p-2 payrow">
                <div class="w-30">
                    Net Salary
                </div>
                <div class="w-35 text-end">
                    <input type="text" class="text-end numberonly" name="previous_head" id="" value="9876">
                </div>
                <div class="w-35 text-end">
                    <input type="text" class="text-end numberonly" name="current_head" id="" value="8745678">
                </div>
            </div>
        </div>
    </div>
</div>
