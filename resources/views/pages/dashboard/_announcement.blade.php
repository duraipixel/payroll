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
                    <th class="min-w-150px">Date</th>
                    <th class="min-w-150px text-end">View</th>
                </tr>
            </thead>
            <!--end::Thead-->
            <!--begin::Tbody-->
            <tbody class="fs-6 fw-bold text-gray-600">
                
                @if(count($announcement_list)>0)
                @foreach($announcement_list as $announcement)
                @if($announcement->announcement_type=='Full Time')
                <tr>
                    <td class="ps-9">{{$announcement->message}}</td>
                    <td class="ps-0">-</td>
                    <td class="ps-0 text-end">  
                         <a onclick="mypopup('{{$announcement->upload_type}}','{{$announcement->upload_url}}')"><i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                   </td>
                </tr>
                @else
                @if($announcement->announcement_type !='Full Time' && $announcement->to_date >= Carbon\Carbon::now()->format('Y-m-d'))

                 <tr>
                    <td class="ps-9">{{$announcement->message}}</td>
                    <td class="ps-0">{{$announcement->from_date}}  -  {{$announcement->to_date}}</td>
                    <td class="ps-0 text-end">
           <a onclick="mypopup('{{$announcement->upload_type}}','{{$announcement->upload_url}}')"><i class="fa fa-eye" aria-hidden="true"></i>
                        </a></td>
                </tr>
                @endif

                @endif
                
                @endforeach
                @else
                <tr><td></td><td>No data found</td> <td class="ps-0 text-end">-</td></tr>
                @endif
            </tbody>
            <!--end::Tbody-->
        </table>
    </div>

</div>
<div class="modal fade" id="kt_popup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body py-lg-10 px-lg-10" id="dynamic_content">
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
</div>
</div>
<script type="text/javascript">
    function mypopup(type,value){
        $('#kt_popup').modal('show');
        $('#dynamic_content').empty();
        console.log(value);
        if(type=='link'){
        $('#dynamic_content').append('<iframe style="top: 0; left: 0; width: 100%; height: 100%;  class="mt-3" src="'+value+'" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share;"></iframe>')  
        } 
        if(type=='file'){
         $('#dynamic_content').append('<img src="'+value+'">')  
         }
        
        }
</script>


