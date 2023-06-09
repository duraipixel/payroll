<div class="card shadow border card-table">
    <div class="p-3 bg-light sticky-top">
        <b>Appointment status</b>
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
                @if (isset($nature_of_works) && !empty($nature_of_works))
                @foreach ($nature_of_works as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ count($item->appointments) }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div> 