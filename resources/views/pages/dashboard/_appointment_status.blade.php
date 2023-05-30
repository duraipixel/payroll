<div class="card h-100 cstmzed">
    <div class="card-body p-9">
        <div class="card-title">
            <h3 class="mb-5 text-gray-800">Appointment status </h3>
        </div>
        <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 320px">
            <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                
                <thead class="border-gray-200 fs-5 fw-bold bg-lighter">
                    <tr>
                        <th class="min-w-150px ps-9">Staffs</th>
                        <th class="min-w-150px ps-0 text-end">Nos</th>
                    </tr>
                </thead>
           
                <tbody class="fs-6 fw-bold text-gray-600">
                    @if (isset($nature_of_works) && !empty($nature_of_works))
                        @foreach ($nature_of_works as $item)
                            <tr>
                                <td class="ps-9">{{ $item->name }}</td>
                                <td class="ps-0 text-end">{{ count($item->appointments) }}</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
                
            </table>
        </div>
    </div>
</div>
