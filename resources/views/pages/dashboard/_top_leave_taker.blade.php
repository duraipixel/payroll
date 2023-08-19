<div class="card shadow border card-table">
    <div class="p-3 bg-light sticky-top">
        <b>Top 10 Leave Takers</b>
    </div>
    <div class="p-2 px-3">
        <table class="table table-bordered m-0 ">
            <thead>
                <tr>
                    <th class="fw-bold"><i>Staffs</i></th>
                    <th class="fw-bold text-center"><i>Nos</i></th>
                </tr>
            </thead>
            <tbody>
                @if (isset($top_ten_leave_taker) && !empty($top_ten_leave_taker))
                    @foreach ($top_ten_leave_taker as $item)
                        <tr>
                            <td>
                                <div class="d-flex text-start align-items-left">
                                    <div class="symbol symbol-45px me-5">
                                        @if (isset($item->user->image) && !empty($item->user->image))
                                            @php
                                                $profile_image = Storage::url($item->user->image);
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
                                            class="text-dark fw-bolder text-hover-primary fs-6">{{ $item->user->name }}</a>
                                        <span
                                            class="text-muted fw-bold text-muted d-block fs-7">{{ $item->user->institute_emp_code }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="ps-0 text-center">{{ $item->total ?? 0 }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
