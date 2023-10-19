<!DOCTYPE html>
<html>
<head>
<style>

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  
}

.br-bot th,td{
    padding:3px;
}
th,td {
   border:1px solid black;
  
}
.tabl-border-none1 td{
    border:1px solid #fff !important
}
.tabl-border-none1 th{
    border:1px solid #fff !important
}
 </style>
</head>
<body>
     @php
          
                                $path = Storage::url($info->staff->image);
                                $logo = Storage::url($info->staff->institute->logo);
                            @endphp
<div style="background: url('{{asset("public" . $logo) }}') center;background-repeat: no-repeat !important;overflow:hidden;">
<table border="1" class="body-sub">
    
    <tr>

        <td width="20%" style="text-align: center;margin-top:10px"><img src="{{ asset('public' . $path) }}" width=150></td>
        <td width="50%" style="text-align: center;text-transform: uppercase;">{{ $institution_name ?? '' }}<br>
             {{ $institution_address ?? '' }}–<br>
            605001<br>
            URL : www.amalorpavamschool.org<br><br>
            SALARY SLIP FOR THE MONTH<br>
            OF {{ $pay_month ?? '' }}</td>
        <td  width="20%" style="text-align: center;"><img src="{{ asset('public' . $logo) }}" width=150></td>
    </tr>
    
    <!-----2 row--->
   
</table>
<table>
    <tr class="br-bot">
        <th width="20%">Staff Name </th>
        <td width="40%">{{ $info->staff->name ?? '' }}</td>
        <th width="10%">Staff ID</th>
        <td width="20%">{{ $info->staff->institute_emp_code ?? '' }}</td>
    </tr>
</table>
<table  class="tabl-border-none" >
    <tr class="br-bot">
        <th style="text-align: left;">FATHER’S /SPOUSE’S NAME : @if($info->staff->familyMembers[0]->relation_type_id==16) {{ $info->staff->familyMembers[0]->first_name ?? '' }} @endif</th>
    </tr>
</table>
<table  class="tabl-border-none" >
    <tr class="br-bot">
        <th width="15%">PAN</th>
        <td width="15%">{{ $info->staff->pancard->doc_number ?? '' }}</td>
        <th width="15%">UAN</th>
        <td width="15%">{{$info->staff->pf->ac_number ?? ''}}</td>
        <th width="15%">ESI.NO</th>
        <td width="15%">{{$info->staff->esi->ac_number ?? ''}}</td> 
        </tr>
</table>
<table  class="tabl-border-none" >
    
        <tr class="br-bot">
            <th width="25%">DESIGNATION </th>
            <td width="15%"> {{ $info->staff->position->designation->name ?? 'N/A' }}</td>
            <th width="15%">PLACE OF WORK</th>
            <td width="15%">  {{ $info->staff->appointment->work_place->name ?? 'N/A' }}</td>
        </tr>
    
</table>
<table  class="tabl-border-none" >
    <tr>
        @foreach($leave_types as $type)
        <th width="15%" style=" text-transform: uppercase;">{{$type->name}}</th>
        <td width="15%">{{$type->count}}</td>
        @endforeach
        
        </tr>
</table>
<table  class="tabl-border-none" >
    <tr class="br-bot">
        <th width="50%">EARNINGS</th>
        <th width="50%">DEDUCTIONS</th>
        </tr>
</table>
<table  class="tabl-border-none" style="background:rgb(199, 196, 196);text-align: center;">
    <tr class="br-bot">
        <td width="25%">HEADS </td>
        <td width="15%">AMOUNT IN RS</td>
        <td width="25%">HEADS</td>
        <td width="15%">AMOUNT IN RS</td>
    </tr>
</table>
<table  class="tabl-border-none"  style="text-align: center;">
    <tr class="br-bot">
        <td width="25%">BASIC PAY</td>
        <td width="15%">@if(isset($basic_pay)) {{$basic_pay ?? 0.00 }} @else 0.00 @endif</td>
        <td width="25%">EMPLOYEE PROVIDENT FUND</td>
        <td width="15%">@if(isset($pf)) {{$pf ?? 0.00 }} @else 0.00 @endif</td>
    </tr>
</table>
<table  class="tabl-border-none" style="text-align: center;">
    <tr class="br-bot">
        <td width="25%">DEARNESS ALLOWANCE (BASIC)</td>
        <td width="15%">@if(isset($dearness)) {{$dearness ?? 0.00 }} @else 0.00 @endif</td>
        <td width="25%">BANK LOAN</td>
        <td width="15%">@if(isset($bank_loan)) {{$bank_loan ?? 0.00 }} @else 0.00 @endif</td>
    </tr>
</table>
<table  class="tabl-border-none" style="text-align: center;">
    <tr class="br-bot">
        <td width="25%">HOUSE RENT ALLOWANCE</td>
        <td width="15%">@if(isset($house_rent)) {{$house_rent ?? 0.00 }} @else 0.00 @endif</td>
        <td width="25%">EMPLOYEES’ STATE
            INSURANCE</td>
        <td width="15%">@if(isset($insurance)) {{$insurance ?? 0.00 }} @else 0.00 @endif</td>
    </tr>
</table>
<table  class="tabl-border-none" style="text-align: center;">
    <tr class="br-bot">
        <td width="25%">TRANSPORT ALLOWANCE</td>
        <td width="15%">@if(isset($traveling)) {{$traveling ?? 0.00 }} @else 0.00 @endif</td>
        <td width="25%">SCHOOL LOAN</td>
        <td width="15%">@if(isset($loan)) {{$loan ?? 0.00 }} @else 0.00 @endif</td>
    </tr>
</table>
<table  class="tabl-border-none" style="text-align: center;">
    <tr class="br-bot">
        <td width="25%">PERFORMANCE BASED ALLOWANCE</td>
        <td width="15%">@if(isset($performance)) {{$performance ?? 0.00 }} @else 0.00 @endif</td>
        <td width="25%">INCOME TAX</td>
        <td width="15%">@if(isset($income_tax)) {{$income_tax ?? 0.00 }} @else 0.00 @endif</td>
    </tr>
</table>
<table  class="tabl-border-none" style="text-align: center;">
    <tr class="br-bot">
        <td width="25%">DEARNESS ALLOWANCE (PBA)</td>
        <td width="15%">@if(isset($performance_allowance)) {{$performance_allowance ?? 0.00 }} @else 0.00 @endif</td>
        <td width="25%">PROFESSIONAL TAX</td>
        <td width="15%">@if(isset($p_tax)) {{$p_tax ?? 0.00 }} @else 0.00 @endif</td>
    </tr>
</table>
<table  class="tabl-border-none" style="text-align: center;">
    <tr class="br-bot">
        <td width="25%">DEDICATION AND SINCERITY ALLOWANCE</td>
        <td width="15%">@if(isset($dedication)) {{$dedication ?? 0.00 }} @else 0.00 @endif</td>
        <td width="25%">LIC / OTHER SAVINGS</td>
        <td width="15%">0.00</td>
    </tr>
</table>
<table  class="tabl-border-none" style="text-align: center;">
    <tr class="br-bot">
        <td width="25%">MEDICAL AND NUTRITION ALLOWANCE</td>
        <td width="15%">@if(isset($medical)) {{$medical ?? 0.00 }} @else 0.00 @endif</td>
        <td width="25%">CONTRIBUTION</td>
        <td width="15%">@if(isset($contributions)) {{$contributions ?? 0.00 }} @else 0.00 @endif</td>
    </tr>
</table>
<table  class="tabl-border-none" style="text-align: center;">
    <tr class="br-bot">
        <td width="25%">ARREARS</td>
        <td width="15%">@if(isset($arrears)) {{$arrears ?? 0.00 }} @else 0.00 @endif</td>
        <td width="25%">OTHERS</td>
        <td width="15%">@if(isset($others)) {{$others ?? 0.00 }} @else 0.00 @endif</td>
    </tr>
</table>
<table  class="tabl-border-none" style="text-align: center;">
    <tr class="br-bot">
        <th width="25%">GROSS SALARY</th>
        <td width="15%">{{$info->gross_salary}}</td>
        <th width="25%">GROSS DEDUCTION</th>
        <td width="15%">@if(isset($others)) {{$others ?? 0.00 }} @else 0.00 @endif</td>
    </tr>
</table>
<table  class="tabl-border-none" style="background:rgb(199, 196, 196);text-align: center;" >
    <tr class="br-bot">
        <th width="50%">NET SALARY</th>
        <th width="50%">{{$info->total_earnings}}</th>
        </tr>
</table>
<table  class="tabl-border-none" >
    <tr class="br-bot">
        <th style="text-align: left;">In words :
           @if(isset($word))
    {{$word}}
@endif</th>
    </tr>
</table>
<table  class="tabl-border-none" >
    <tr class="br-bot">
        <th style="text-align: center;">Payment details</th>
    </tr>
</table>
<table  class="tabl-border-none">
    <tr class="br-bot">
        <td width="15%">Mode of Payment</td>
        <td width="15%">Disbursement date</td>
        <td width="15%">BANK NAME</td>
        <td width="15%">Beneficiary a/c no</td>
        <td width="15%">Amount transferred</td>
    </tr>
    <tr class="br-bot">
        <td width="15%" style="padding: 1%;"></td>
        <td width="15%"></td>
        <td width="15%"></td>
        <td width="15%"></td>
        <td width="15%"></td>
    </tr>
</table>


<table  class="tabl-border-none1" style="padding: 0%;">
    <tr class="">
        <td style="text-align: center;"> “Do not work for the food that perishes but for the food that endures for eternal life</td> 
    </tr>
   
</table>

<table class="tabl-border-none1">
<th style="text-align:right;" >SENIOR PRINCIPAL.</th>
</table>
</div>

</body>
</html>