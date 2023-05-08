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
        <h2 style="text-align:center">{{$institute_name ?? ''}}</h2>
        <h3 style="text-align:center"> {{$form_title ?? ''}} APPPLICATION </h3>
    </div>
    <table class="noborder" style="width: 100%">
        <tr>
            <td style="width:16%;text-align:left">APPLICATION NO : </td>
            <td style="width:34%;text-align:left"> <b> {{ $application_no ?? '' }} </b></td>
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
            <td class="noborder-s" style="width:45%;text-align:left">{{ $designation ?? '' }}</td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">04.</td>
            <td class="noborder-x" style="width:45%;text-align:left">No. of  Days requested</td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left">{{ $no_of_days ?? ''}}</td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">05.</td>
            <td class="noborder-x" style="width:45%;text-align:left">Dates requested</td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left">{{ $date_requested ?? '' }}</td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">06.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Reason for leave </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $reason ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center">07.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Number of  days  taken  so  far </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $taken_leave ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center;height:100px">08.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Signature  of  the  Staff </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left">  </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center"> For Office use  </td>            
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center"> A.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Leaved Granted  </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $is_leave_granted ?? ''}} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center"> B.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> No. of days Granted   </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $granted_days ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center"> C.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Remarks </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $remarks ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center"> D.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Leave Granted By  </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $leave_granted_by ?? ''}}  </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center"> E.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Designation   </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left"> {{ $granted_designation ?? '' }} </td>
        </tr>
        <tr>
            <td class="noborder-e" style="width:5%;text-align:center;height:100px"> F.</td>
            <td class="noborder-x" style="width:45%;text-align:left"> Signature    </td>
            <td class="noborder-x" style="width:5%;text-align:center">:</td>
            <td class="noborder-s" style="width:45%;text-align:left">   </td>
        </tr>
    </table>
</body>

</html>
