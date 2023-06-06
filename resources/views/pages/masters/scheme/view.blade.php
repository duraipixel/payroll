 <style>
    .aligment{
        text-align: left;
    font-size: 14px !important;
    padding: 22px  !important;
    font-weight: 600  !important;
    }
    </style>
<table class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
    <tr>
        <td class="aligment">Scheme Name</td>
        <td>  {{$info->name ?? ''}}</td>
    </tr>
    <tr>
        <td class="aligment">Scheme Code</td>
        <td>  {{$info->scheme_code ?? ''}}</td>
    </tr>
    <tr>
        <td class="aligment">Start Time</td>
        <td>  {{$info->start_time ?? ''}}</td>
    </tr>
    <tr>
        <td class="aligment">End Time</td>
        <td>  {{$info->end_time ?? ''}}</td>
    </tr>
    <tr>
        <td class="aligment">Total Hours</td>
        <td>  {{$info->totol_hours ?? ''}}</td>
    </tr>
    <tr>
        <td class="aligment">Permission CutOff Time</td>
        <td>  {{$info->permission_cutoff_time ?? ''}}</td>
    </tr>
    <tr>
        <td class="aligment">Late CutOff Time</td>
        <td>  {{$info->late_cutoff_time ?? ''}}</td>
    </tr>
    <tr>
        <td class="aligment">Status</td>
        <td>  {{ucfirst($info->status ?? '')}}</td>
    </tr>
</table>
<button type="button" class="btn btn-secondary" style="float:right" data-bs-dismiss="modal">Close</button>
  