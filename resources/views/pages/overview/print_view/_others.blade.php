<tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
    <td colspan="4"
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
        Other Talents</td>
</tr>

@if (isset($user->talents) && !empty($user->talents))
    @foreach ($user->talents as $item)
    <tr>
        <td style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
            {{ $item->talent_fields }}
        </td>
        <td colspan="7" style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
            {{ $item->talent_descriptions }}
        </td>
    </tr>
    @endforeach
@endif
