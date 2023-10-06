<div class="card h-100 cstmzed">
    <div class="card-body p-9">
        <div class="card-title">
            <h3 class="mb-5 text-gray-800">List of Announcement</h3>
        </div>
        <table
            class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
            <!--begin::Thead-->
            <thead class="border-gray-200 fs-5 fw-bold bg-lighter">
                <tr>
                    <th class="min-w-150px ps-9">Announcement Name</th>
                    <th class="min-w-150px text-end">Date</th>
                </tr>
            </thead>
            <!--end::Thead-->
            <!--begin::Tbody-->
            <tbody class="fs-6 fw-bold text-gray-600">
                
                @foreach($announcement_list as $announcement)
                @if($announcement->announcement_type=='Full Time')
                <tr>
                    <td class="ps-9">{{$announcement->message}}</td>
                    <td class="ps-0 text-end">-</td>
                </tr>
                @else
                @if($announcement->announcement_type !='Full Time' && $announcement->to_date >= Carbon\Carbon::now()->format('Y-m-d'))

                 <tr>
                    <td class="ps-9">{{$announcement->message}}</td>
                    <td class="ps-0 text-end">{{$announcement->from_date}}  -  {{$announcement->to_date}}</td>
                </tr>
                @endif

                @endif
                @endforeach
            </tbody>
            <!--end::Tbody-->
        </table>
    </div>

</div>