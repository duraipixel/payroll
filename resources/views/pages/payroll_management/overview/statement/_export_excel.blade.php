@php
$basic=0;
$da=0;
$hra=0;
$ta=0;
$pba=0;
$pbada=0;
$dsa=0;
$mna=0;
$arrear=0;
$others=0;
$bonus=0;
$esi=0;
$bankloan=0;
$lic=0;
$pt=0;
$it=0;
$darrear=0;
$contributions=0;
$epf=0;
$dother=0;
$oloan=0;
$others=0;
$contribution1=0;
if(isset($salary_info) && !empty($salary_info)){
foreach ($salary_info as $key=>$item){

if(isset($earings_field)&&!empty($earings_field)){
foreach ($earings_field as $eitem){
if($eitem->name=='Basic Pay'){
$basic +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='Dearness Allowance'){
$da +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='House Rent Allowance'){
$hra +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='Traveling Allowance'){
$ta +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='Performance Based Allowance'){
$pba +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='Performance Based Allowance Dearness Allowance'){
$pbada +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='Dedication & Sincerity Allowance'){
$dsa +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='Medical & Nutrition Allowance'){
$mna +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='ARREAR'){
$arrear +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='Others'){
$others +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
if($eitem->name=='Bonus'){
$bonus +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);  
}
}
}
if(isset($deductions_field)&& !empty($deductions_field)){
foreach($deductions_field as $sitem){

if($sitem->name=="Employees' State Insurance"){
$esi +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='Bank Loan'){
$bankloan +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='Life Insurance Corporation'){
$lic +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='Professional Tax'){
$pt +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='Income Tax'){
$it +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='Arrears'){
$darrear +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='Contributions'){
$contributions +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='Employee Provident Fund'){
$epf +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='OTHER'){
$dother +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='Contribution'){
$contribution1 +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}

if($sitem->name=='OTHER LOAN'){
$oloan +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
if($sitem->name=='Others'){
$others +=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS'); 
}
}
}
}
}
@endphp 
<table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer" id="revision_table">
    <thead class="bg-primary">
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase align-middle gs-0">
            <th class="px-3 text-primary sticky-col first-col">
                Emp Code
            </th>
            <th class="px-3 text-primary sticky-col second-col">
                Name
            </th>
            <th class="px-3 text-white">
                Join Date
            </th>
            <th class="px-3 text-white">
                Workdays
            </th>
            @if (isset($earings_field) && !empty($earings_field))
                @foreach ($earings_field as $eitem)
                    <th class="px-3 text-white">
                        {{ $eitem->short_name }}
                    </th>
                @endforeach
                <th class="px-3 text-white">
                    Gross
                </th>
            @endif
            @if (isset($deductions_field) && !empty($deductions_field))
                @foreach ($deductions_field as $sitem)
                    <th class="px-3 text-white">
                        {{ $sitem->short_name }}
                    </th>
                @endforeach
                <th class="px-3 text-white">
                    Total Deduction
                </th>
            @endif
            <th class="px-3 text-white w-100px">Net Pay</th>
        </tr>
    </thead>

    <tbody class="text-gray-600 fw-bold">
             @php
                $total_net_pay = 0;
                $gross_salary=0;
                $net_salary=0;
                $total_deductions=0;
            @endphp
        @if (isset($salary_info) && !empty($salary_info))
            @foreach ($salary_info as $item)
                <tr>
                    <td class="sticky-col first-col px-3">
                        {{ $item->staff->society_emp_code ?? '' }}
                    </td>
                    <td class="sticky-col second-col px-3">
                        {{ $item->staff->name ?? '' }}
                    </td>
                    <td class="px-3">
                        {{ $item->staff->firstAppointment->joining_date ?? '' }}
                    </td>

                    <td class="px-3">
                        {{ $item->working_days ?? 0 }}
                    </td>
                    @if (isset($earings_field) && !empty($earings_field))
                        @foreach ($earings_field as $eitem)
                            <td class="px-3">
                                {{ amountFormat(getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name)) }}
                            </td>
                        @endforeach
                        <td class="px-3">
                            {{ amountFormat($item->gross_salary) }}
                        </td>
                    @endif
                    @if (isset($deductions_field) && !empty($deductions_field))
                        @foreach ($deductions_field as $sitem)
                            <td class="px-3">
                                {{ amountFormat(getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS')) }}
                            </td>
                        @endforeach
                        <td class="px-3">
                            {{ amountFormat($item->total_deductions) }}
                        </td>
                    @endif
                    <td class="px-3">
                        {{ RsFormat($item->net_salary) }}
                    </td>
                </tr>
                @php
                    $gross_salary +=$item->gross_salary;
                    $net_salary +=$item->net_salary;
                    $total_deductions+=$item->total_deductions;
                    @endphp
            @endforeach
            @if(count($salary_info)>0)
                  <tr>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{amountFormat($basic)}}</td>
                    <td>{{amountFormat($da)}}</td>
                    <td>{{amountFormat($hra)}}</td>
                    <td>{{amountFormat($ta)}}</td>
                    <td>{{amountFormat($pba)}}</td>
                    <td>{{amountFormat($pbada)}}</td>
                    <td>{{amountFormat($dsa)}}</td>
                    <td>{{amountFormat($mna)}}</td>
                    <td>{{amountFormat($arrear)}}</td>
                    <td>{{amountFormat($others)}}</td>
                    <td>{{amountFormat($bonus)}}</td>
                    <td>{{amountFormat($gross_salary)}}</td>
                    <td>{{amountFormat($esi)}}</td>
                    <td>{{amountFormat($bankloan)}}</td>
                    <td>{{amountFormat($lic)}}</td>
                    <td>{{amountFormat($pt)}}</td>
                    <td>{{amountFormat($it)}}</td>
                    <td>{{amountFormat($darrear)}}</td>
                    <td>{{amountFormat($contributions)}}</td>
                    <td>{{amountFormat($epf)}}</td>
                    <td>{{amountFormat($dother)}}</td>
                    <td>{{amountFormat($contribution1)}}</td>
                    
                    <td>{{amountFormat($oloan)}}</td>
                    <td>{{amountFormat($others)}}</td>
                    <td>{{amountFormat($total_deductions)}}</td>
                    <td>{{amountFormat($net_salary)}}</td>
                  </tr>
                  @endif
                  @else
                  <tr>
                    <td> No Payroll records </td>
                 </tr>
        @endif
    </tbody>

</table>