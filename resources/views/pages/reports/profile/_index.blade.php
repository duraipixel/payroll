@extends('layouts.template')
@section('content')
    <style>
        div.dt-buttons {
            padding: 10px;
        }
    </style>
    <div class="p-3">
        <div class="text-center lead fw-bold my-3">Staff Report</div>
        <div class="card border shadow m-0">
            {{-- <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        {!! searchSvg() !!}
                        <input type="text" data-kt-user-table-filter="search" id="board_dataTable_search"
                            class="form-control form-control-solid w-250px ps-14" placeholder="Search University">
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a type="button" class="btn btn-light-primary me-3 btn-sm" href="{{ route('reports.export') }}">
                            {!! exportSvg() !!}
                            Export
                        </a>
                    </div>
                </div>
            </div> --}}

            <div class="card-body py-4">
                <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover table-bordered table-striped fs-7 no-footer"
                            id="profile_table">
                            <thead class="bg-primary text-white align-middle">
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Staff Name</th>
                                    <th>Emp Code</th>
                                    <th>Inst Emp Code</th>
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>Designation</th>
                                    {{-- <th>Place Of Work</th> --}}
                                    <th>Mother Tongue</th>
                                    <th>Phone Number</th>
                                    <th>Whatsapp Number</th>
                                    <th>Emergency Number</th>
                                    <th>Place of Birth</th>
                                    <th>Nationality</th>
                                    <th>Religion</th>
                                    <th>Caste</th>
                                    <th>Community</th>
                                    <th>Contact Address</th>
                                    <th>Permanent Address</th>
                                    <th>Marital Status</th>
                                    <th>Marriage Date</th>
                                    {{-- <th>Adhaar</th>
                                    <th> Pan Card </th>
                                    <th> Ration Card </th>
                                    <th> Voter ID </th> --}}
                                </tr>
                            </thead>

                            <tbody class="text-gray-600 fw-bold" id="profile_report_content">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('add_on_script')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            $('#profile_table').DataTable({
                buttons: [{
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }]
            });
        });
    </script> --}}
    <script>
        getProfileReports();

        function getProfileReports() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('reports.profile') }}",
                type: 'GET',
                data: {

                },
                beforeSend: function() {
                    loading();
                },
                success: function(res) {
                    $('#profile_report_content').html(res);
                    unloading();
                    setTimeout(() => {
                        $('#profile_table').DataTable({
                            dom: 'Blfrtip',
                            buttons: [
                                'excel'
                            ],
                            pageLength: 50,
                            lengthMenu: [
                                [50, 100, -1],
                                [50, 100, "All"]
                            ],
                            lengthChange: true,
                            // buttons: [{
                            //     extend: 'excelHtml5',
                            //     text: 'Export to Excel',
                            //     exportOptions: {
                            //         columns: ':visible'
                            //     }
                            // }],

                        });
                        $('.buttons-excel').addClass(
                            "btn btn-light-primary me-3 btn-sm border shadow-sm border-primary")
                        $('.buttons-excel').removeClass("dt-button  buttons-html5")
                    }, 100);
                }
            })
        }
    </script>

    <!-- DataTables Buttons -->
@endsection
