<div class="card">
    <form action="{{ route('reports.el.entry.export',['user_id'=>$staff_details->id]) }}" class="input-group w-auto d-inline"
                        method="GET">
        <div class="card-header border-0 pt-6">
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
        
              <button onclick="this.form.action = '{{ route('reports.el.entry.export',['user_id'=>$staff_details->id]) }}'" type="submit"
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
    $('#leave_table_length').hide();
     var id="{{$staff_details->id}}";
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