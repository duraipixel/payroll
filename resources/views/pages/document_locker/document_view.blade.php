<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .btn-info-blue {
            color: #00d6f7;
            background-color: #f9ffff;
            border-color: #17a2b8 !important;
        }
    </style>

    <div class="container">
        @include('pages.document_locker._tab_view')
    </div>

@endsection

@section('add_on_script')
    <script>
        function changeDocumentStatus(id, type, status) {

            Swal.fire({
                text: "Are you sure you would like to change status?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, Change it!",
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
                        url: "{{ route('document_status') }}",
                        type: 'POST',
                        data: {
                            id: id,
                            type: type,
                            status: status
                        },
                        success: function(res) {
                            window.location.reload();
                            Swal.fire({
                                title: "Updated!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                timer: 3000
                            });

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
        navTabs = $('.nav-tabs')
        navTabs[0].firstElementChild.classList.add('active')
        tabContent = $('.tab-content')
        tabContent[0].firstElementChild.classList.add('show')
        tabContent[0].firstElementChild.classList.add('active')
        console.log(tabContent[0].firstElementChild.classList)
    </script>
@endsection
