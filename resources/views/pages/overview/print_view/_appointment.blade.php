<table class="common-table" style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%"
    cellpadding="5">
    <tbody>
        <tr style="background-color: #1b488c;-webkit-print-color-adjust: exact;">
            <td colspan="12"
                style="border: 1px solid #1b488c;color:#fff;font-weight:bold;font-size:15px;vertical-align: middle;
                        height:0px;">
                Appointment Information</td>
        </tr>
        <tr>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Date of Joining
            </td>
            <td
                style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
               Order No
            </td>
             <td  style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 20%;font-size: 12px;">
                Period of Appointment (From - To)
            </td>
           
            <td  style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 20%;font-size: 12px;">
                Appointment
            </td>
             <td  style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
               Category
            </td>
            <td  style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
               Nature Of Employment
            </td>
            <td  style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Work Place
            </td>
           
            <td  style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Salary Scale
            </td>
            <td  style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                Probation
            </td>
           
        </tr>
        @if (isset($user->allAppointment) && count($user->allAppointment) > 0)
            @foreach ($user->allAppointment as $item)
                <tr>

                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                        {{ commonDateFormat($item->joining_date) }}
                    </td>
                     <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                        {{ $item->appointment_order_no ?? 'n/a'}}
                    </td>
                     <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                        {{ commonDateFormat($item->from_appointment) }} - {{ commonDateFormat($item->to_appointment) }}
                    </td>
                    <td
                        style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                        {{ $item->appointmentOrderModel->name ?? 'N/A' }}
                    </td>
                      <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                        {{ $item->staffCategory->name ?? ''}}
                    </td>
                       <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                        {{ $item->employment_nature->name ?? ''  }}
                    </td>
                       <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                        {{ $item->work_place->name ?? '' }}
                    </td>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                        {{ $item->salary_scale }}
                    </td>


                   
                    <td
                        style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;width: 10%;font-size: 12px;">
                        {{ $item->has_probation ?? 'N/A' }}
                        <br>
                        @if( $item->probation_period )
                        {{ $item->probation_period ?? 'N/A' }}
                        @endif
                    </td>
                   
                    
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="12"
                    style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">
                    No Records
                </td>
            </tr>
        @endif


    </tbody>
</table>
