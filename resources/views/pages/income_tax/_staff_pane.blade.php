@if (isset($salary_pattern) && !empty($salary_pattern))
    @if (isset($staff_details) && $staff_details->verification_status == 'approved')
        @if (isset($staff_details) && !empty($staff_details))
            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-2 d-flex justify-content-between">
                        <div class="p-2 px-4 border border-2 w-200px">
                            <div class="fw-bold">
                                Staff Name:
                            </div>
                            <div class="badge badge-light-info fs-6">
                                {{ $staff_details->name }}
                            </div>
                        </div>
                        <div class="p-2 px-4 border border-2 w-200px">
                            <div class="fw-bold">
                                Society Code:
                            </div>
                            <div class="badge badge-light-success fs-6">
                                {{ $staff_details->society_emp_code ?? 'n/a' }}
                            </div>
                        </div>
                        <div class="p-2 px-4 border border-2 w-200px">
                            <div class="fw-bold">
                                Designation
                            </div>
                            <div class="badge badge-light-warning fs-6">
                                {{ $staff_details->position->designation->name ?? 'n/a' }}
                            </div>
                        </div>
                        <div class="p-2 px-4 border border-2 w-200px">
                            <div class="fw-bold">
                                Nature of Work
                            </div>
                            <div class="badge badge-light-primary fs-6">
                                {{ $staff_details->appointment->employment_nature->name ?? 'n/a' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endif
        @if (isset($statement_data) && !empty($statement_data))
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active tax-link income" data-id="income" onclick="return getTaxTabInfo('income')"
                        aria-current="page" href="javascript:void(0)">
                        Income
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tax-link deductions" data-id="deductions"
                        onclick="return getTaxTabInfo('deductions')" href="javascript:void(0)">Deductions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tax-link other_income" data-id="other_income"
                        onclick="return getTaxTabInfo('other_income')" href="javascript:void(0)">Other Income</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tax-link rent" data-id="rent" onclick="return getTaxTabInfo('rent')"
                        href="javascript:void(0)">House Rent</a>
                </li>
                 <li class="nav-item">
                <a class="nav-link tax-link regime" data-id="regime" onclick="return getTaxTabInfo('regime')"
                    href="javascript:void(0)">Regime / Schemes </a>
            </li>
                {{-- @if ($statement_data->is_staff_calculation_done == 'no' && $statement_data->total_income_tax_payable > 0) --}}
                <li class="nav-item">
                    <a class="nav-link tax-link taxpayable" data-id="taxpayable"
                        onclick="return getTaxTabInfo('taxpayable')" href="javascript:void(0)"> TaxPayable Calculation
                    </a>
                </li>
                {{-- @endif --}}
            </ul>
            <div id="tab_load_content" class="p-3">
                @include('pages.income_tax._income_pane')
            </div>
        @else
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger">
                        <label> Income tax statement not generated </label>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    <label> Staff Verification Pending </label>
                </div>
            </div>
        </div>
    @endif
@else
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger">
                <label> Salary not Created or Salary Approval pending </label>
            </div>
        </div>
    </div>
@endif
