<div class="card">
    <div class="p-3 d-flex">
        <div>

            <label for="">Lock Calculation </label>
        </div>
        <div>
            <select name="lock_calculation" id="lock_calculation" onchange="listTaxCalculation(this.value)" class="form-input w-100px mx-3">
                <option value="">All</option>
                <option value="yes" @if( isset($lock_calculation) && $lock_calculation == 'yes' ) selected @endif>Yes</option>
                <option value="no" @if( isset($lock_calculation) && $lock_calculation == 'no' ) selected @endif>No</option>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" id="it_calculation_table">
            <thead class="bg-primary">
                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                    <th class="px-3 text-white">
                        S.No
                    </th>
                    <th class="px-3 text-white">
                        Staf Name
                    </th>
                    <th class="px-3 text-white">
                        Employee Code
                    </th>
                    <th class="px-3 text-white">
                        Institution Code
                    </th>
                    <th class="px-3 text-white text-center w-150px">
                        Gross Salary Anum
                    </th>
                    <th class="px-3 text-white text-center w-150px">
                        Tax Payable
                    </th>
                    <th class="px-3 text-white text-center w-150px">
                        Lock Calculation
                    </th>
                    <th class="px-3 text-white text-center">
                        Action
                    </th>
                </tr>
            </thead>
    
            <tbody class="text-gray-600 fw-bold">
                @if (isset($statement_details) && !empty($statement_details))
                    @foreach ($statement_details as $item)
                        <tr>
                            <td class="ps-3 text-center">{{$loop->iteration}}</td>
                            <td>{{ $item->staff->name }}</td>
                            <td>{{ $item->staff->society_emp_code }}</td>
                            <td>{{ $item->staff->institute_emp_code }}</td>
                            <td class="text-end">{{ commonAmountFormat($item->gross_salary_anum) }}</td>
                            <td class="text-end">{{ commonAmountFormat($item->total_income_tax_payable) }}</td>
                            <td class="text-center">
                                {{$item->lock_calculation}}
                            </td>
                            <td class="text-center">
                                <label for="" role="button" class="text-success" onclick="getStaffTaxCalculationPane('{{$item->staff_id}}')">
                                    <i class="fa fa-eye" ></i>
                                </label>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
    
        </table>
    </div>
</div>

<script>
    var it_calculation_table = $('#it_calculation_table').DataTable();
</script>
