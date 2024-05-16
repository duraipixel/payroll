<div class="card">
    @php
     $start_year='';
     $end_year='';
     $el_granted=0;
     $el_accumulated=0;
     $el_availed=0;
     $el_balance=0;
     if(count($el_count)>0){
     $firstItem = $el_count[0];
     $lastItem = $el_count[count($el_count)-1];
     foreach($el_count as $key =>$el_data){
        if($el_data === $firstItem) {
            $start_year=$el_data->calanderYear->year;
        }
        if($el_data === $lastItem) {

          $end_year=$el_data->calanderYear->year;
          $el_accumulated=$el_data->accumulated;
          
         }
         $el_granted +=$el_data->no_of_leave_actual;
         $el_balance=$el_data->carry_forward_count;
         $el_availed +=$el_data->availed;
         

     }
     }
    @endphp
<div class="col-sm-12">
            <div class="mb-2 d-flex justify-content-between">
                <div class="p-2 px-4 border border-2 w-200px" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; text-align: center;">
                    <div class="fw-bold">
                        Year
                    </div>
                    <div class="badge badge-light-info fs-6">
                        @if(isset($start_year) && $start_year !='')
                       {{$start_year}} - {{$end_year}}
                       @endif
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;text-align: center;">
                    <div class="fw-bold">
                        EL Granted
                    </div>
                    <div class="badge badge-light-success fs-6">
                        {{$el_granted}}
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;text-align: center;">
                    <div class="fw-bold">
                       EL Accumulated
                    </div>
                    <div class="badge badge-light-warning fs-6">
                        {{$el_accumulated}}
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;text-align: center;">
                    <div class="fw-bold">
                       EL Availed
                    </div>
                    <div class="badge badge-light-primary fs-6">
                      
                        {{$el_availed}}
                    </div>
                </div>
                  <div class="p-2 px-4 border border-2 w-200px" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;text-align: center;">
                    <div class="fw-bold">
                       EL Balance
                    </div>
                    <div class="badge badge-light-primary fs-6">
                      
                        {{$el_balance}}
                    </div>
                </div>
            </div>
        </div>
    <form action="{{ route('reports.el.entry.export',['user_id'=>$staff_details ? $staff_details->id : 0]) }}" class="input-group w-auto d-inline"method="GET">
        <div class="card-header border-0">
            <div class="card-title">
                <!-- <div class="d-flex align-items-center position-relative my-1">
                    {!! searchSvg() !!}
                   <input type="text" data-kt-user-table-filter="search" id="data_search" name="data_search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search User" value="{{request()->data_search}}">
                </div> -->
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    @php
                        $route_name = request()
                            ->route()
                            ->getName();
                    @endphp
        
              <button onclick="this.form.action = '{{ route('reports.el.entry.export',['user_id'=>$staff_details ? $staff_details->id : 0]) }}'" type="submit"
                            class="btn btn-sm btn-success"><i class="fa fa-table me-2"></i>Export</button>
            
                            &nbsp;&nbsp;
                </div>
                
                            &nbsp;&nbsp;
            </div>
        </div>
    </form>
  <div class="card-body py-4">
        <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="table-responsive">
                <table class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
                    id="leave_table">
                    <thead class="bg-primary">
                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th class="text-center text-white">
                                Year
                            </th>
                            <th class="text-center text-white">
                                EL Granted
                            </th>
                            <th class="text-center text-white">
                               EL Accumulated
                            </th>
                            <th class="text-center text-white">
                               EL Availed
                            </th>
                            <th class="text-center text-white">
                              EL Balance
                            </th>
                            <th class="text-center text-white">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-bold">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
     async function ValidationEl() {
     return false;
    }
    $('#leave_table_length').hide();
     var id="{{$staff_details->id ?? 0}}";
     var url = "{{ route('staff.el.summary', ['id' => ':id']) }}";
     url = url.replace(':id', id);
     var dtTable = $('#leave_table').DataTable({

            processing: false,
            serverSide: true,
            order: [
                [0, "DESC"]
            ],
            type: 'POST',
            ajax: {
                "url":url,
                "data": function(d) {
                    
                }
            },

            columns: [{
                    data: 'year',
                    name: 'Year',
                },
                {
                    data: 'no_of_leave',
                    name: 'EL Granted'
                },
                {
                    data: 'accumulated',
                    name: 'EL Accumulated'
                },
                {
                    data: 'el_availed',
                    name: 'EL Availed'
                },
                {
                    data: 'el_balance',
                    name: 'EL Balance'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←' 
                }
            },
            "aaSorting": [],
            "pageLength": 25
        });
       $('.dataTables_wrapper').addClass('position-relative');
        $('.dataTables_info').addClass('position-absolute');
      function getElModal( id = '',type='') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formMethod = "addEdit" ;
            $.ajax({
                url: "{{ route('staff.el.summary.edit') }}",
                type: 'POST',
                data: {
                    id: id,
                    type: type,
                    
                },
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                    
                }
            })

        }
</script>