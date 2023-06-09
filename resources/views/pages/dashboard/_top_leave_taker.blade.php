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
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>
                            <div class="d-flex text-start align-items-left">
                                <div class="symbol symbol-45px me-5">
                                    <img src="{{ url('/') }}/assets/media/avatars/300-19.jpg" alt="">
                                </div>
                                <div class="d-flex justify-content-middle flex-column">
                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">John</a>
                                    <span class="text-muted fw-bold text-muted d-block fs-7">Teaching Staff</span>
                                </div>
                            </div>
                        </td>
                        <td class="ps-0 text-center">50</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
