<tr>
    <td colspan="4" style="text-align: center"> For Office use  </td>            
</tr>
<tr>
    <td class="noborder-e" style="width:5%;text-align:center"> A.</td>
    <td class="noborder-x" style="width:45%;text-align:left"> Leaved Granted  </td>
    <td class="noborder-x" style="width:5%;text-align:center">:</td>
    <td class="noborder-s" style="width:45%;text-align:left"> {{ $is_leave_granted ?? '' }} </td>
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
    <td class="noborder-s" style="width:45%;text-align:left"> {{ $granted_designation ?? '' }}  </td>
</tr>
@if($status !='pending')
<tr>
    <tr>
      
        <td style="width:10%;">S.No</td>
        <td style="width:10%;">Date</td>
        <td style="width:30%;">Leave Type</td>
        <td style="width:50%;">Status</td>
    </tr>
    @foreach(json_decode($leave_days ?? []) as $key=>$day)
    <tr>
      
        <td style="width:10%;">{{$key+1}}</td>
        <td style="width:10%;">{{date('d/M/Y', strtotime($day->date))}}</td>
        <td style="width:30%;text-transform:capitalize;">{{$day->type}}</td>
        <td style="width:50%;">{{($day->check==1)?'Approved' : 'Rejected' }}</td>
    </tr>
    @endforeach
</tr>
@endif
<tr>
    <td class="noborder-e" style="width:5%;text-align:center;height:100px"> F.</td>
    <td class="noborder-x" style="width:45%;text-align:left"> Signature    </td>
    <td class="noborder-x" style="width:5%;text-align:center">:</td>
    <td class="noborder-s" style="width:45%;text-align:left">   </td>
</tr>