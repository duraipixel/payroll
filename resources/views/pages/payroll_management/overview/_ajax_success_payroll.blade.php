<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped">
            <tr>
                <td> Employee </td>
                <td> {{ $info->salaryStaff->count() }} </td>
            </tr>
            <tr>
                <td> Gross Pay </td>
                <td> {{ $info->salaryStaff->sum('gross_salary') }}</td>
            </tr>
            <tr>
                <td> Deduction </td>
                <td> {{ $info->salaryStaff->sum('total_deductions') }} </td>
            </tr>
            
        </table>

    </div>
    <div class="col-sm-12 text-start">
        <a href="{{ route('payroll.statement', ['id' => $info->id]) }}" class="btn btn-primary"> 
            View Salary Statement
        </a>
        <a href="{{ route('payroll.overview') }}" class="btn btn-dark">
            Close
        </a>
    </div>
</div>
