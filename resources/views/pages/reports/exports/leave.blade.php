<table border="1">
<thead>
<tr>
<th>DOJ</th>
<th>Emp ID</th>
<th>Name</th>
<th>DESIGNATION</th>
<th>CL Eligible</th>
<th>CL Availed</th>
<th>CL Balance</th>
<th>GL Sanctioned</th>
<th>GL Balance</th>
<th>EL Accumalted</th>
<th>EL Current yr</th>
<th>EL Total (L+M)</th>
<th>EL Availed</th>
<th>EL Balance</th>
<th>ML Eligible</th>
<th>ML Availed</th>
<th>ML Balance</th>
<th>LOP Eligible</th>
<th>LOP Amount deducted</th>
<th>LOP Reason</th>
</tr>
</thead>
<tbody>
@if(count($data)>0)
@foreach($data as $leave_detail)
@php
    $clAvailed = getLeaveDays($leave_detail->leaves, 'Casual Leave');
    $clEligible = getLeaveMapping($leave_detail->id,academicYearId(),'cl')->leave_days ?? 0;
    $elAvailed =  getLeaveDays($leave_detail->leaves, 'Earned Leave') +getLeaveELEntry($leave_detail->id,academicYearId(),$from_date,$to_date)->total_days;
    $el_total = getLeaveMapping($leave_detail->id,academicYearId(),'el')->accumulated ??0 - getLeaveMapping($leave_detail->id,academicYearId(),'el')->leave_days??0;
    $el_accumalted = getLeaveMapping($leave_detail->id,academicYearId(),'el')->accumulated   - getLeaveMapping($leave_detail->id,academicYearId(),'el')->leave_days ??0 ;
    $el_year = getLeaveMapping($leave_detail->id,academicYearId(),'el')->leave_days ?? 0;
    $ml_eligible=$leave_detail->appointment->ml->leave_days ?? 0;
    $ml_availed=getLeaveDays($leave_detail->leaves, 'Maternity Leave');

@endphp
<tr> 
    <td> {{$leave_detail->appointment->joining_date??''}}</td>
    <td> {{$leave_detail->institute_emp_code??''}}</td>
    <td> {{$leave_detail->name??''}}</td>
    <td> {{$leave_detail->appointment->designation->name??''}}</td>
    <td> {{$clEligible ?? 0}}</td>
    <td> {{$clAvailed}}</td>
    <td> {{($clEligible - $clAvailed)??0}}</td>
    <td> {{$leave_detail->appointment->gl->leave_days??0}}</td>
    <td> {{getLeaveDays($leave_detail->leaves, 'Maternity Leave')}}</td>

    <td> {{$el_accumalted}}</td>
    <td> {{$el_year}}</td>
    <td> {{$el_total}}</td>
    <td> {{$elAvailed}}</td>
    <td> {{($el_total - $elAvailed)}}</td>
    <td> {{$ml_eligible??0}}</td>
    <td> {{$ml_availed??0}}</td>
    <td> {{($ml_eligible - $ml_availed)??0}}</td>
    <td> {{getLeaveDays($leave_detail->leaves, 'Extra Ordinary Leave')}}</td>
    <td></td>
    <td></td>

</tr>
@endforeach
@else
<tr><td>No result found</td></tr>
@endif
</tbody>