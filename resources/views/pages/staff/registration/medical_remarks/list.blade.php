<div class="table-responsive">

    <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">

        <thead>
            <tr class="fw-bolder text-muted">
                <th class="min-w-50px">Date</th>
                <th class="min-w-120px">Reason</th>
                <th class="min-w-120px">View File</th>
                <th class="min-w-120px text-end">Actions</th>
            </tr>
        </thead>

        <tbody>
            @isset($medical_remarks)
                @foreach ($medical_remarks as $item)
                    <tr>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            {{ date('d-m-Y', strtotime($item->medic_date)) }}
                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">
                                Age - 30
                            </span> --}}
                        </td>

                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            {{ $item->reason }}
                        </td>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            @if( isset( $item->medic_documents ) && !empty($item->medic_documents) )
                                {{-- <a href="{{ asset(Storage::url($item->medic_documents)) }}" class="" target="_blank"> Download File </a> --}}
                                <a href="{{ asset('public'.Storage::url($item->medic_documents)) }}" class="" target="_blank"> Download File </a>
                            @else 
                                <a href="javascript:void(0)" > No File Uploaded </a>
                            @endif
                        </td>

                        <td class="text-end">
                            <a href="javascript:void(0)" onclick="return editMedicRemarksForm('{{ $item->staff_id }}', '{{ $item->id }}')" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                {!! editSvg() !!}
                            </a>
                            <a href="javascript:void(0)" onclick="return deleteMedicRemark('{{ $item->staff_id }}', '{{ $item->id }}')" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                {!! deleteSvg() !!}
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endisset

        </tbody>
    </table>
</div>
