<table class="common-table" style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%" cellpadding="5">
    <tbody>
        <tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
            <td colspan="6"
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
                Relation working in AEWS </td>
        </tr>
        <tr>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:5%;">
                Relationship Name
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Relationship
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                EMP Code
            </td>
            <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
                Place of Work 
            </td>
        </tr>
        
        @if (isset($user->workingRelations) && count($user->workingRelations) > 0)
            @foreach ($user->workingRelations as $item)
                <tr>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->belonger->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->relationship->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                       {{ $item->belonger->emp_code ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
                        {{ $item->belonger->work_place->name ?? '' }}
                    </td>
                </tr>
            @endforeach
        @else
        <tr>
            <td colspan="6" style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;"> No Records </td>
        </tr>
        @endif


    </tbody>
</table>
