<div class="card shadow border card-table">
    <div class="p-3 bg-light sticky-top">
        <b>Resigned Staff List</b>
    </div>
    <div class="p-2 px-3">
        <table class="table table-bordered m-0 ">
            <thead>
                <tr>
                    <th class="fw-bold"><i>Staffs</i></th>
                    <th class="fw-bold text-center"><i>Last Date</i></th>
                    <th class="fw-bold text-center"><i>Status</i></th>
                </tr>
            </thead>
            <tbody>
                @if (isset($resigned) && !empty($resigned))
                    @foreach ($resigned as $item)
                        <tr>
                            <td>
                                <div class="d-flex text-start align-items-left">
                                    <div class="symbol symbol-45px me-5">
                                        @if (isset($item->staff->image) && !empty($item->staff->image))
                                            @php
                                                $profile_image = Storage::url($item->staff->image);
                                            @endphp
                                            @if (file_exists($profile_image))
                                                <img src="{{ asset('public' . $profile_image) }}" alt=""
                                                    width="100" style="border-radius:10%">
                                            @else
                                                <img src="{{ url('/') }}/assets/media/avatars/300-19.jpg"
                                                    alt="">
                                            @endif
                                        @else
                                            <img src="{{ url('/') }}/assets/media/avatars/300-19.jpg"
                                                alt="">
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-middle flex-column">
                                        <a href="#"
                                            class="text-dark fw-bolder text-hover-primary fs-6">{{ $item->staff->name }}</a>
                                        <span
                                            class="text-muted fw-bold text-muted d-block fs-7">{{ $item->staff->institute_emp_code }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="ps-0 text-center">{{ commonDateFormat($item->last_working_date) }}</td>
                            <td class="ps-0 text-center">{{ $item->is_completed == 'yes' ? 'Completed' : 'Not Yet' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
