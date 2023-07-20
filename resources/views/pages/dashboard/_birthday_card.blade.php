<div class="card shadow border card-table">
    <div class="p-3 bg-light sticky-top">
        <b>Staffs Birthday <span class="badge ms-2 bg-dark">{{ count($dob) }}</span></b>
    </div>
    <div class="p-2 px-3">
        <table class="table table-bordered m-0 ">
            <thead>
                <tr>
                    <th class="fw-bold"><i>Name</i></th>
                    <th class="fw-bold text-center"><i>Date</i></th>
                </tr>
            </thead>
            <tbody>
                @isset($dob)
                    @foreach ($dob as $item)
                        <tr>
                            <td>
                                <div class="d-flex text-start align-items-left">
                                    <div class="symbol symbol-45px me-5">
                                        @php
                                            if (isset($item->staffInfo->image) && !empty($item->staffInfo->image)) {
                                                $url = asset('public' . Storage::url($item->staffInfo->image));
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
                            <td class="ps-0 text-end">{{ date('d F', strtotime($item->dob)) }}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
</div>
