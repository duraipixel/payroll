<style>
    .tableFixHead {
        overflow: auto;
        height: 300px;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>
<div class="table-responsive tableFixHead" style="box-shadow: 1px 2px 3px 4px #98aac173;">
    <h3 class="p-3 text-center"> {{ $title }}
        
        <div class="btn btn-sm btn-icon btn-active-color-primary float-end" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
    </h3>
    <table class="table table-hover table-row-dashed align-middle gs-0 gy-3 my-0 ">
        <thead>
            <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                <th class="p-0 p-3 min-w-50px bg-dark">No</th>
                <th class="p-0 p-3 bg-dark">Insurance </th>
                <th class="p-0 p-3 bg-dark">Policy No</th>
                <th class="p-0 p-3 bg-dark pe-12">Amount</th>
                <th class="p-0 p-3 bg-dark pe-7">Maturity Date</th>
            </tr>
        </thead>

        <tbody>
            
            @if (isset($datas) && !empty($datas))
                @foreach ($datas as $item)
                    <tr>
                        <td class="p-3"> {{ $loop->iteration }} </td>
                        <td class="p-3">{{ $item->insurance_name }}</td>
                        <td class="p-3">{{ $item->policy_no }}</td>
                        <td class="p-3">{{ $item->amount ?? '' }}</td>
                        <td class="p-3">{{ $item->maturity_date ?? '' }}</td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td class="p-3"> No Records </td>
            </tr>
            @endif

        </tbody>
    </table>
</div>
