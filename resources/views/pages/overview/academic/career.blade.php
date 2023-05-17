<div class="  cursor-pointer">

    <div class="card-title m-0 mb-5">
        <h3 class="fw-bold m-0">Career</h3>
    </div>

</div>
<div class="table-responsive cstmzes-tble">
    <table id="kt_customer_details_invoices_table_3"
        class="table align-middle table-row-dashed fs-6 fw-bolder gy-5 dataTable no-footer">

        <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
            <tr class="text-start text-muted bg-light gs-0">
                <th> Intitution </th>
                <th> Designation </th>
                <th> From </th>
                <th> To </th>
                <th> Address </th>
                <th> Salary </th>
                <th> Experience </th>
                <th> Remarks </th>
                <th> Document </th>
            </tr>
        </thead>

        <tbody class="fs-6 fw-bold text-gray-600">
            @isset($info->careers)
                @foreach ($info->careers as $item)
                    <tr class="odd">
                        <td>{{ $item->institute->name }}</td>
                        <td>{{ $item->designation->name }}</td>
                        <td>{{ $item->from }}</td>
                        <td>{{ $item->to }}</td>
                        <td>{{ $item->address }}</td>
                        <td>₹{{ $item->salary_drawn ?? 0 }}</td>
                        <td>{{ $item->experience_year ? $item->experience_year : 'year' }}</td>
                        <td>{{ $item->remarks }}</td>
                        <td>
                            @if (isset($item->doc_file) && !empty($item->doc_file))
                                {{-- <a href="{{ asset(Storage::url($item->doc_file)) }}" class="" target="_blank"> Download File </a> --}}
                                <a href="{{ asset('public' . Storage::url($item->doc_file)) }}" class=""
                                    target="_blank"> Download File </a>
                            @else
                                <a href="javascript:void(0)"> No File Uploaded </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endisset
        </tbody>
    </table>
</div>
