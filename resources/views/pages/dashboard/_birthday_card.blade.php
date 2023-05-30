<div class="card h-100 cstmzed">
    <div class="card-body p-9">
        <div class="card-title">
            <h3 class="mb-5 text-gray-800">Staffs Birthday <span>(6)</span></h3>
        </div>
        <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 320px">
            <table
                class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                
                <thead class="border-gray-200 fs-5 fw-bold bg-lighter">
                    <tr>
                        <th class="min-w-150px ps-9">Name</th>
                        <th class="min-w-150px ps-0 text-end">Date</th>
                    </tr>
                </thead>
              
                <tbody class="fs-6 fw-bold text-gray-600">
                    @isset($dob)
                    @foreach ($dob as $item)
                    <tr>
                        <td>
                            <div class="d-flex text-start align-items-left">
                                <div class="symbol symbol-45px me-5">
                                    @php
                                    if( isset($item->staffInfo->image) && !empty( $item->staffInfo->image)){

                                        $url = asset('public'.Storage::url($item->staffInfo->image));
                                    } else {
                                        $url = asset('assets/images/no_Image.jpg');
                                    }
                                    @endphp
                                    <img src="{{ $url }}" alt="{{ $item->staffInfo->name ?? '' }}">
                                </div>
                                <div class="d-flex justify-content-middle flex-column">
                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                        {{ $item->staffInfo->name ?? '' }}
                                    </a>
                                    <span class="text-muted fw-bold text-muted d-block fs-7">
                                        {{ $item->staffInfo->appointment->employment_nature->name ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="ps-0 text-end">{{ date('M d, Y', strtotime($item->dob)) }}</td>
                    </tr>
                    @endforeach
                        
                    @endisset
                    
                    
                </tbody>
                <!--end::Tbody-->
            </table>
        </div>
    </div>
</div>