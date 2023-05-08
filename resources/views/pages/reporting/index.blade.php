@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    @include('pages.reporting.tree_css')
    <div class="card">
        <div class="card-header border-0 pt-6">

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a type="button" class="btn btn-primary btn-sm" id="add_modal" onclick="return openTopLevelForm()">
                        Assign Top Level Manager
                    </a>
                    &emsp;
                    <a type="button" class="btn btn-primary btn-sm" id="add_modal" onclick="return openAssignForm()">
                        Assign Manager
                    </a>
                </div>

            </div>
        </div>

        <div class="card-body py-4">
            <div class="body genealogy-body genealogy-scroll">
                <div class="genealogy-tree">
                    <ul>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="member-view-box">
                                    <div class="member-image">
                                        <img src="http://localhost/amalpayroll/assets/images/no_Image.jpg" alt="Member">
                                        <div class="member-details">
                                            <h3>{{ $reporting_data->manager->name }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @isset($reporting_data)
                            {{ buildTree($reporting_data->reportee_id); }}
                        @endisset
                        </li>
                    </ul>
                </div>
            </div>

        </div>
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
    </script>
@endsection
