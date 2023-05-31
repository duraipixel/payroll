<tr style="background-color: #ddd;-webkit-print-color-adjust: exact;">
    <td colspan="4"
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;">
        Languages Known</td>
</tr>
<tr>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:5%;">
        Languages</td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
        Read</td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
        Write</td>
    <td
        style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;width:10%;">
        Speak</td>
</tr>

@if( isset( $user->knownLanguages ) && !empty( $user->knownLanguages ) )
    @foreach ($user->knownLanguages as $item)
        
    <tr>
        <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
            {{ $item->language->name ?? '' }}
        </td>
        <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
            {{ $item->read ? 'Yes' : 'No' }}
        </td>
        <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
            {{ $item->write ? 'Yes' : 'No' }}
        </td>
        <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;">
            {{ $item->speak ? 'Yes' : 'No' }}
        </td>
    </tr>
    @endforeach
@endif
