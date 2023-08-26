@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    @include('pages.reporting.tree_css')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <div class="form-group mx-3 w-300px">
                        <a href="{{ route('reporting.list') }}" class="btn btn-light-primary @if( !$page_type ) active @endif btn-sm"> Table View</a>
                        <a href="{{ route('reporting.list', ['type' => 'tree']) }}" class="btn btn-light-primary @if( $page_type ) active @endif btn-sm"> Tree
                            View</a>
                    </div>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a type="button" class="btn btn-primary btn-sm" id="add_modal" onclick="return openTopLevelForm()">
                        Assign Top Level Manager
                    </a>
                    &emsp;
                    <a type="button" class="btn btn-dark btn-sm" id="add_modal" onclick="return openAssignForm()">
                        Assign Manager
                    </a>
                    &emsp;
                    <a type="button" class="btn btn-info btn-sm" id="add_modal" onclick="return openChangeForm()">
                        Replace / Transfer Manager
                    </a>
                </div>

            </div>
        </div>
        @if ($page_type)
            @include('pages.reporting._treeview')
        @else
            @include('pages.reporting._tableview')
        @endif
    </div>
@endsection

@section('add_on_script')
    <script>
        $(function() {
            $('.genealogy-tree ul').hide();
            $('.genealogy-tree>ul').show();
            $('.genealogy-tree ul.active').show();
            $('.genealogy-tree li').on('click', function(e) {
                var children = $(this).find('> ul');
                if (children.is(":visible")) children.hide('fast').removeClass('active');
                else children.show('fast').addClass('active');
                e.stopPropagation();
            });
        });

        function openTopLevelForm() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('reporting.assign.form') }}",
                type: 'POST',
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })
        }

        function openAssignForm() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('reporting.manager.modal') }}",
                type: 'POST',
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })
        }

        function openChangeForm() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('reporting.manager.change.modal') }}",
                type: 'POST',
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })
        }

        function deleteManager(id) {
            Swal.fire({
                text: "Are you sure you would like to delete Manager?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('reporting.delete') }}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(res) {

                            if (res.error == 0) {

                                Swal.fire({
                                    title: "Deleted!",
                                    text: res.message,
                                    icon: "success",
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    },
                                    timer: 3000
                                });
                                setTimeout(() => {
                                    console.log('deleted')
                                    location.reload();
                                }, 1000);
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: res.message,
                                    icon: "error",
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    },
                                    // timer: 3000
                                });
                            }

                        },
                        error: function(xhr, err) {
                            if (xhr.status == 403) {
                                toastr.error(xhr.statusText, 'UnAuthorized Access');
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
