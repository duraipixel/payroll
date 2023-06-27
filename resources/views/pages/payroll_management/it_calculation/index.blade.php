<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        #deduction_table td {
            border-bottom: 1px solid #ddd;
        }
    </style>
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <div class="form-group mx-3 w-300px">
                        <label for="" class="fs-6">Select Employee</label>
                        <select name="staff_id" id="staff_id" class="form-control form-control-sm" onchange="return getStaffTaxPane(this.value)">
                            <option value="">-select-</option>
                            @isset($employees)
                                @foreach ($employees as $item)
                                    <option value="{{ $item->id }}" @if (isset($staff_id) && $staff_id == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>

                    </div>
                </div>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
    </div>
    <div class=" mt-3">
        <div class="py-4" id="staff_tax_pane">
            <div class="row">
                <div class="col-sm-9">
                    <div class="card">
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td>Total Income during the financial year 2021-2022 </td>
                                    <td> 100000 x 12 </td>
                                    <td>
                                        <input type="text" name="" class="form-input" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Less : Standard Deduction
                                    </td>
                                    <td>50,000</td>
                                    <td>
                                        <input type="text" name="" class="form-input" value="1150000">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Less : House Rent Allowance</td>
                                    <td>
                                        <input type="text" name="" class="form-input" value="40,000">
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td colspan="2">Total Salary Income for the year 2021-2022   </td>
                                    <td>
                                        <input type="text" name="" class="form-input" value="1110000">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Deduct Loss from Self-Occupied House on account of  Housing Loan Interest    
                                        (Maximum Rs.2,00,000)
                                    </td>
                                    <td> 40000   </td>
                                    <td>
                                        <input type="text" name="" class="form-input" value="1070000">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Profession Tax – Amount of profession tax actually paid (section 16 (I))                                                           
                                    </td>
                                    <td>
                                        2500 
                                    </td>
                                    <td>
                                        <input type="text" name="" class="form-input" value="1067500">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>                            
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        $('#staff_id').select2({
            theme: 'bootstrap-5'
        });
    </script>
@endsection
