<div class="card shadow border card-table">
    <div class="p-3 bg-light sticky-top">
        <b>Staffs Anniversary <span class="badge ms-2 bg-dark">{{ count($anniversary) }}</span></b>
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
                @isset($anniversary)
                    @foreach ($anniversary as $item)
                        <tr>
                            <td>
                                <div class="d-flex text-start align-items-left">
                                    <div class="symbol symbol-45px me-5">
                                        @php
                                            if (isset($item->staffInfo->image) && !empty($item->staffInfo->image)) {
                                               $profile_image=storage_path('app/public/' . $item->staffInfo->image);
                                            }
                                        @endphp
                                       @if (file_exists($profile_image))
                                        <img src="{{ asset('storage/app/public/' .$item->staffInfo->image) }}" alt="{{ $item->staffInfo->name ?? '' }}">
                                        @else
                                        <img src="{{ url('/') }}/assets/images/no_Image.jpg"
                                                    alt="{{ $item->staffInfo->name ?? '' }}">
                                        @endif
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
                            <td class="ps-0 text-end">{{ date('d F', strtotime($item->marriage_date)) }} </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
</div>
