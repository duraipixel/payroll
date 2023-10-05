<!DOCTYPE html>
<html lang="en">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    .noborder td{
        font-size:12px;
    }
    .leave-table td, th {
        padding: 5px;
        border:1px solid black;
    }
    .noborder-x {
        border-left: none !important;
        border-right: none !important;
    }
    .noborder-s {
        border-left: none !important;
    }
    .noborder-e {
        border-right: none !important;
    }
</style>
<body>
    <div>
        <h2 style="text-align:center"> {{$institute_name ?? ''}} </h2>
        <h3 style="text-align:center">  {{$form_title ?? ''}} APPPLICATION </h3>
    </div>
    <table class="noborder" style="width: 100%">
        <tr>
            <td style="width:16%;text-align:left">APPLICATION NO : </td>
            <td style="width:34%;text-align:left"> <b> {{ $application_no ?? '' }}</b></td>
            <td style="width:40%;text-align:right">DATE  OF APPLICATION : </td>
            <td style="width:10%;text-align:right"><b>{{ $application_date ?? '' }}</b></td>
        </tr>
    </table>
    <table class="leave-table" style="width: 100%;margin-top:5px;" cellspacing="0" padding="0">
        <tr style="border:1px solid">
            <td class="noborder-e" style="width:5%;text-align:center">01.</td>
            <td class="noborder-x" style="width:45%;text-align:left">Name of  the  Staff</td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $staff_name ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">02.</td>
            <td class="noborder-x" style="width:45%;text-align:left">Staff Id</td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left">{{ $staff_code ?? '' }}</td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">03.</td>
            <td class="noborder-x" style="width:45%;text-align:left">Designation</td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $designation ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">04.</td>
            <td class="noborder-x" style="width:45%;text-align:left">Place of Work </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $place_of_work ?? ''}} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">05.</td>
            <td class="noborder-x" style="width:45%;text-align:left">Salary Details</td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $salary ?? ''}} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">06.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Sundays and holidays, if any, proposed to be prefixed/suffixed to leave </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $holiday_date ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">07.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Nature and period of leave applied for and date from which required </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{$date_requested ?? ''}} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">08.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Grounds on which leave is applied for </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $reason ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">09.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Date of return from last leave, and the nature and period of that leave </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $taken_leave ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center;">09.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Address during leave period </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $address ?? '' }} </td>
        </tr>
        @if(isset($leave_days))
            <tr>
                <td style="width:10%;"></td>
                <td style="width:10%;">S.No</td>
                <td style="width:30%;">Date</td>
                <td style="width:50%;">Leave Type</td>
            </tr>
            @foreach(json_decode($leave_days ?? []) as $key=>$day)
            <tr>
                <td style="width:10%;"></td>
                <td style="width:10%;">{{$key+1}}</td>
                <td style="width:30%;">{{date('d/M/Y', strtotime($day->date))}}</td>
                <td style="width:50%;text-transform:capitalize;">{{$day->type}}</td>
            <tr>
            @endforeach
        </tr>
        @endif
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center;height:100px">09.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Signature of the Staff</td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> </td>
        </tr>
        @include('leave_form.parts.office_use_td')
    </table>
</body>

</html>
