<table class="w-100 mt-5 border border-2" id="deduction_table">
    <thead class="bg-primary text-white p-4">
        <tr>
            <th class="p-2  w-200px"> Rent Amount </th>
            <th class="p-2  w-200px"> Annual Rent Amount (P.A) </th>
            <th class="p-2"> Remarks </th>
            <th class="p-2 text-center"> Upload Receipt </th>
            <th class="p-2 text-center"> Action </th>
        </tr>
    </thead>
    <tbody id="">
        @if (isset($staff_details->staffRentByAcademic) && !empty($staff_details->staffRentByAcademic))
            <tr class="">
                <td class="p-2">
                    {{ $staff_details->staffRentByAcademic->amount ?? '' }}
                </td>
                <td class="p-2 w-100px">
                    {{ $staff_details->staffRentByAcademic->annual_rent ?? '' }}
                </td>
                <td class="p-2">
                    {{ $staff_details->staffRentByAcademic->remarks ?? '' }}
                </td>
                <td class="p-2 text-center">
                    @if (isset($staff_details->staffRentByAcademic->document) && !empty($staff_details->staffRentByAcademic->document))
                        <a href="{{ asset('public' . Storage::url($staff_details->staffRentByAcademic->document)) }}" target="_blank">
                            Download Receipt
                        </a>
                    @else
                        <a href="javascript:void(0)">
                            No Receipt
                        </a>
                    @endif
                </td>
                <td class="p-2 text-center">
                    <i class="fa fa-trash p-2 text-danger" role="button"
                        onclick="return deleteRent('{{ $staff_details->staffRentByAcademic->id }}')"></i>
                </td>
            </tr>
        @else
            <tr class="">
                <td class="p-2" colspan="5">
                    No records found
                </td>
            </tr>
        @endif

    </tbody>
</table>
